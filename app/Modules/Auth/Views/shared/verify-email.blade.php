<x-partials.notifications.toast-message sessionKey="status"/>

<div class="flex flex-col justify-center items-center w-full space-y-1">
    <h2 class="text-xl">
        {{__('auth.verify_email.salutation', ['username' => Auth::user()->name])}}
    </h2>
    <h1 class="text-2xl">{{__('auth.verify_email.heading')}}</h1>
    <p class="text-center text-lg">
        {{__('auth.verify_email.paragraph', ['email' => Auth::user()->email])}}
    </p>
    <p class="py-5 lg:px-20 text-center text-sm">
        {{__('auth.verify_email.paragraph2', ['email' => Auth::user()->email])}}
    </p>
    <x-auth::shared.form :formControls="[]" action="{{route('verification.send')}}" method="POST" btnText="{{__('auth.verify_email.btn')}}"/>
</div>
