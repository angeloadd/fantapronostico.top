@if($errors->any())
    @foreach($errors->all() as $error)
        <x-partials.notifications.toast-message :validation="$error"/>
    @endforeach
@endif
<x-layouts.with-drawer>
    <div class="size-full flex flex-col items-center justify-start">
        <x-partials.header.header bgColor="bg-primary" text="Pronostico"/>
        {{$slot}}
    </div>
</x-layouts.with-drawer>
