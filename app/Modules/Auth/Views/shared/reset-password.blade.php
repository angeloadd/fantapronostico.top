<div class="w-full space-y-1">
    <span class="w-full text-center text-sm">{{__('auth.request_password_reset.paragraph')}}</span>
    <x-auth::shared.form
        action="{{route('password.update')}}"
        method="POST"
        prefix="reset-password"
        :formControls="[
        [
            'name' => 'password',
            'type' => 'password',
            'placeholder' => 'Nuova Password',
        ],
        [
            'name' => 'token',
            'type' => 'hidden',
            'placeholder' => 'Token',
            'value' => request()->token
        ],
        [
            'name' => 'email',
            'type' => 'hidden',
            'placeholder' => 'Email',
            'value' => request()->email
        ]
    ]"
        btnText="{{__('auth.reset-password.btn')}}"
    />
</div>
