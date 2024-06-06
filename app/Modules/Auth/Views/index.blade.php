<x-layouts.app>
    <x-slot name="title">{{__('auth.'. str_replace('-', '_',$pageName) .'.title')}}</x-slot>
    <x-auth::shared.layout>
        <x-dynamic-component :component="'auth::shared.'.$pageName" :leagues="$leagues ?? collect([])"/>
    </x-auth::shared.layout>
</x-layouts.app>
