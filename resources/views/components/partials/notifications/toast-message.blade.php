@if(null !== session($sessionKey ?? 'message'))
    <template x-teleport="#toastWrapper">
        <x-partials.notifications.toast :text="session($sessionKey ?? 'message')" type="success"/>
    </template>
@endif
@if(null !== session($errorKey ?? 'error_message'))
    <template x-teleport="#toastWrapper">
        <x-partials.notifications.toast :text="session($errorKey ?? 'error_message')" type="error"/>
    </template
@endif
@if(null !== session($warningKey ?? 'warning_message'))
    <template x-teleport="#toastWrapper">
        <x-partials.notifications.toast :text="session($warningKey ?? 'warning_message')" type="warning"/>
    </template
@endif
@if(null !== session($infoKey ?? 'info_message'))
    <template x-teleport="#toastWrapper">
        <x-partials.notifications.toast :text="session($infoKey ?? 'info_message')" type="info"/>
    </template
@endif
