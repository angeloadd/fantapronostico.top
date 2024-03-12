#!/usr/bin/env bash

STORAGE_PATH=/var/www/html/storage
FOLDER="$STORAGE_PATH/database"
if [ ! -d "$FOLDER" ]; then
    echo "$FOLDER is not a directory, ensuring paths..."
    cp -r /var/www/html/storage_/. $STORAGE_PATH
    echo "Deleting storage_..."
    rm -rf /var/www/html/storage_
fi
