@php
    $message = session('message');
    $error = session('error_message');
@endphp
@isset($message)
    <template x-teleport=".toast">
        <x-partials.notifications.toast :text="$message" type="success" />
    </template>
@endisset
@isset($error)
    <template x-teleport=".toast">
        <x-partials.notifications.toast :text="$error" type="error" />
    </template
@endisset
