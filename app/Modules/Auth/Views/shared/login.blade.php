<x-auth::shared.nav>
    <x-auth::shared.form
        action="{{route('login')}}"
        method="POST"
        prefix="login"
        :formControls="[
        [
            'name' => 'email',
            'type' => 'email',
            'placeholder' => 'Email',
        ],
        [
            'name' => 'password',
            'type' => 'password',
            'placeholder' => 'Password',
        ],
        [
            'name' => 'remember',
            'type' => 'hidden',
            'placeholder' => 'Remember',
            'value' => '1',
        ],
    ]"
        btnText="{{__('auth.login.btn')}}"
        passwordReset="true"
    />
</x-auth::shared.nav>
