# syntax = docker/dockerfile:experimental

# PHP_VERSION and other build args needs to be repeated in case they are used in places different then from:
# See https://docs.docker.com/engine/reference/builder/#understand-how-arg-and-from-interact

### ARG FOR BUILD ###

# Valid version values are PHP 7.4+ for fly-laravel image
ARG PHP_VERSION=8.2
# Use this node version for both dev and prod
ARG NODE_VERSION=21
# Conditional build. By Injecting this argument we include dev build or prod build
ARG BUILD_VERSION=prod
# Add arguments in composer run
ARG COMPOSER_ARGS="--no-dev --optimize-autoloader"

### BASE BUILD STAGE ###

# Start from fly-laravel container instead of using sail because it is simpler to understand and there is already a
# lot of optimization for deploying on fly.io platform that is the target platform for this web-app
FROM fideloper/fly-laravel:${PHP_VERSION} as base

# Look above to know why this is needed here
ARG COMPOSER_ARGS

# Leave this from original Dockerfile template as it might be needed for fly.io platform configuration
LABEL fly_launch_runtime="laravel"

# copy application code, skipping files based on .dockerignore
COPY . /var/www/html

# Run composer install. Add possible flags as argument as we could need different flags depending on env
RUN composer install ${COMPOSER_ARGS} \
    && mkdir -p storage/logs \
#    && php artisan optimize:clear \
    && chown -R www-data:www-data /var/www/html \
    && echo "MAILTO=\"\"\n* * * * * www-data /usr/bin/php /var/www/html/artisan schedule:run" > /etc/cron.d/laravel \
    && cp .fly/entrypoint.sh /entrypoint \
    && chmod +x /entrypoint

### DEV BUILD STAGE ###

# From our base container created above, we add node to be able to work with assets and JS.
# This step is run only if BUILD_VERSION=dev is provided. It enables usage of node in the container.
FROM base as dev

# Look above to know why this is needed here
ARG NODE_VERSION

# install nvm
# https://github.com/creationix/nvm#install-script
RUN curl --silent -o- https://raw.githubusercontent.com/creationix/nvm/master/install.sh | bash

# install node and npm
RUN . ~/.bashrc \
    && nvm install $NODE_VERSION \
    && nvm alias default $NODE_VERSION \
    && nvm use default

RUN echo "[ -f /var/www/html/.bashrc ] && . /var/www/html/.bashrc fi" >> ~/.bashrc
RUN echo "PS1='\[\e[38;5;44;1m\]\h\[\e[0m\]@\[\e[38;5;84;1m\]\u\[\e[0m\]🐋 \[\e[38;5;176;1m\]\w \[\e[0m\]\$ '" >> ~/.bashrc

### ASSETS BUILD STAGE

# Multi-stage build: Build static assets for prod build. A different build is needed for just building the assets so
# we don't include the whole layer into the final image. At least from what I understood this reduces sensibly the
# image weight and it allows us to not include Node within the final container.
FROM node:${NODE_VERSION} as node_modules_go_brrr

RUN mkdir -p  /app
WORKDIR /app
COPY . .
COPY --from=base /var/www/html/vendor /app/vendor

RUN npm install && npm run build;

### PROD BUILD STAGE ###

# From our base container created above, we create our assert layer, adding in static assets that we generated above
# This step is run only if BUILD_VERSION=prod is provided. It copies assets in public avoiding the need to build final
# image with node and npm installed as backend only needs PHP runtime.
FROM base as prod

# Packages like Laravel Nova may have added assets to the public directory
# or maybe some custom assets were added manually! Either way, we merge
# in the assets we generated above rather than overwrite them
COPY --from=node_modules_go_brrr /app/public /var/www/html/public-npm
RUN rsync -ar /var/www/html/public-npm/ /var/www/html/public/ \
    && rm -rf /var/www/html/public-npm \
    && chown -R www-data:www-data /var/www/html/public

# This is the final step, where we provide the build based on the BUILD_VERSION arg, we expose the port and run the
# entrypoint script and every other script needed to setup. You can include scripts or modify the entrypoint in the
# .fly folder located in the current project.
FROM ${BUILD_VERSION} as final

EXPOSE 8080

# We provide a command in docker-compose that will be appended to the entrypoint. This is how normally entrypoint and
# commands interact in Docker. We take advantage of this by appending supervisord bootstrap to pass to entrypoint file
# on dev env. In prod the entrypoint will revert to default and use litefs to boot the app
ENTRYPOINT ["/entrypoint"]
