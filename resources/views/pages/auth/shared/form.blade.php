<form action="{{$action}}" method="{{$method}}">
    @method($method)
    @csrf
    @foreach($formControls as $formControl)
        <x-auth::shared.form-control
                name="{{$formControl['name']}}"
                type="{{$formControl['type']}}"
                placeholder="{{$formControl['placeholder']}}"
                prefix="{{$prefix}}"/>
    @endforeach
    <div class="form-control mt-6">
        <button class="btn btn-primary text-base-100 fp2024-title">{{$btnText}}</button>
    </div>
</form>
