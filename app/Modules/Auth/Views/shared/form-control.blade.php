<div class="form-control">
    <label for="{{$name}}" class="label @if(!empty($hidden ?? null)) hidden @endif">{{$label ?? ''}}</label>
    <input
        id="{{$name}}"
        name="{{$name}}"
        type="{{$type}}"
        placeholder="{{!empty($placeholder ?? null) ? $placeholder : null}}"
        class="input input-bordered @error($name) border-error @enderror @if(!empty($hidden ?? null)) hidden @endif"
        required
        @checked(!empty($checked ?? null) && $type === 'checkbox')
        @if('password' !== $type) value="{{old($name, $value ?? null)}}" @endif
    />
    @error($name)
    @foreach($errors->get($name) as $error)
        <span class="text-error text-sm">{{$error}}</span>
    @endforeach
    @enderror
</div>
