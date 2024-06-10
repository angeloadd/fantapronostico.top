<div class="flex justify-center items-center space-x-2">
    <input
        id="{{$label}}"
        type="radio"
        value="{{$value}}"
        name="sign"
        class="radio bg-white @error('sign') border-error @enderror"
        @checked(null !== $prediction && old('sign', $prediction->sign) === $value)
    />
    <label for="{{$label}}">{{strtoupper($value)}}: {{__($teamName)}}</label>
</div>
