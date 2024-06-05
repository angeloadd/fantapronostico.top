<x-_message sessionKey="status"/>

<div class="w-full space-y-1">
    <span class="w-full text-center text-sm">{{__('auth.request_password_reset.paragraph')}}</span>
    <x-auth::shared.form
        action="{{route('password.email')}}"
        method="POST"
        prefix="reset-password"
        :formControls="[
        [
            'name' => 'email',
            'type' => 'email',
            'placeholder' => 'Email',
        ]
        ]"
        btnText="{{__('auth.request_password_reset.btn')}}"
    />
</div>
