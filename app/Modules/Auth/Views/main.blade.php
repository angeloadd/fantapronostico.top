<x-layouts.app>
    <x-slot name="title">{{__('auth.'. str_replace('-', '_',$pageName) .'.title')}}</x-slot>
    <x-auth::shared.layout>
        <x-dynamic-component :component="'auth::shared.'.$pageName" />
    </x-auth::shared.layout>
</x-layouts.app>
