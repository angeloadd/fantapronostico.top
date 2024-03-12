<x-layouts.app>
    <x-slot:title>{{__('auth.'. str_replace('-', '_',$type) .'.title')}}</x-slot>
    <x-auth::shared.layout>
        <x-dynamic-component :component="'auth::shared.'.$type"  :type />
    </x-auth::shared.layout>
</x-layouts.app>
