<div class="w-full space-y-1">
    <nav role="tablist" class="tabs tabs-bordered tabs-lg">
        <x-auth::shared.tab name="login" text="{{__('auth.login.nav')}}"/>
        <x-auth::shared.tab name="register" text="{{__('auth.register.nav')}}"/>
    </nav>
    {{$slot}}
</div>
