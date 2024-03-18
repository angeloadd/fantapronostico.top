<x-auth::shared.nav>
    <x-auth::shared.form
        action="{{route('api.login')}}"
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
    ]"
        btnText="{{__('auth.login.btn')}}"
    />
</x-auth::shared.nav>
