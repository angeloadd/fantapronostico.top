<form action="{{$action}}" method="{{$method}}">
    @method($method)
    @csrf
    @foreach($formControls as $formControl)
        <x-auth::shared.form-control
            name="{{$formControl['name']}}"
            type="{{$formControl['type']}}"
            placeholder="{{$formControl['placeholder']}}"
            prefix="{{$prefix}}"
            value="{{$formControl['value'] ?? ''}}"
        />
    @endforeach
    @if(isset($btnText) && ! isset($btn))
        <div class="form-control mt-6">
            @if($passwordReset ?? false)
                <a
                    href="{{route('password.email')}}"
                    class="link text-sm pb-2 pr-2 w-full text-right"
                >{{__('auth.login.request_password_reset')}}</a>
            @endif
            <button class="btn btn-primary text-base-100 fp2024-title">{{$btnText}}</button>
        </div>
    @else
    {{$btn}}
    @endif
</form>
