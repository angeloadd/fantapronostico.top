<div class="w-full space-y-1 flex flex-col justify-center items-center">
    <h2 class="text-xl">
        {{__('auth.verify_email.salutation', ['username' => Auth::user()->name])}}
    </h2>
    <h1 class="text-2xl">{{__('auth.verify_email.heading')}}</h1>
    <p class="text-center text-lg">
        {{__('auth.verify_email.paragraph', ['email' => Auth::user()->email])}}
    </p>
    <p class="lg:px-20 py-5 text-center text-sm">
        {{__('auth.verify_email.paragraph2', ['email' => Auth::user()->email])}}
    </p>
    <button class="btn btn-primary text-base-100">{{__('auth.verify_email.btn')}}</button>
</div>
