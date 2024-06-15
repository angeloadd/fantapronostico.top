<template x-teleport="#toastWrapper">
    @if(null !== session($sessionKey ?? 'message'))
        <x-partials.notifications.toast :text="session($sessionKey ?? 'message')" type="success"/>
    @elseif(null !== session($errorKey ?? 'error_message'))
        <x-partials.notifications.toast :text="session($errorKey ?? 'error_message')" type="error"/>
    @elseif(null !== session($warningKey ?? 'warning_message'))
        <x-partials.notifications.toast :text="session($warningKey ?? 'warning_message')" type="warning"/>
    @elseif(null !== session($infoKey ?? 'info_message'))
        <x-partials.notifications.toast :text="session($infoKey ?? 'info_message')" type="info"/>
    @endif
</template>
