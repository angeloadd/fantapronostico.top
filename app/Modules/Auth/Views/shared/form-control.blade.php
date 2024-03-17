<div class="form-control">
    <label for="{{$name}}" class="label">{{$label ?? ''}}</label>
    <input
        id="{{$name}}"
        name="{{$name}}"
        type="{{$type}}"
        @isset($placeholder) placeholder="{{$placeholder}}" @endisset
        class="input input-bordered @error($name) border-error @enderror"
        required
        @if('password' !== $type) value="{{old($name, '')}}" @endif
    />
    @error($name)
        @foreach($errors->get($name) as $error)
            <span class="text-error text-sm">{{$error}}</span>
        @endforeach
    @enderror
</div>
