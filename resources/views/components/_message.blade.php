@php
    $message = session('message');
    $error = session('error_message');
@endphp
@if(isset($message) || isset($error))
<div class="row-span-12 justify-center mb-5">
    <div class="col-8">
        @if(isset($message))
            <div class="alert alert-success text-center text-success">
                {{$message}}
            </div>
        @endif
    </div>
    <div class="col-8">
        @if(isset($error))
            <div class="alert alert-danger text-center text-danger">
                {{$error}}
            </div>
        @endif
    </div>
</div>
@endif
