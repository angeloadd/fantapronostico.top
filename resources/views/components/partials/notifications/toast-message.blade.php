@if(!isset($validation))
@if(null !== session($sessionKey ?? 'message'))
    <template x-teleport="#toastWrapper">
        <x-partials.notifications.toast :text="session($sessionKey ?? 'message')" type="success"/>
    </template>
@elseif(null !== session($errorKey ?? 'error_message'))
    <template x-teleport="#toastWrapper">
        <x-partials.notifications.toast :text="session($errorKey ?? 'error_message')" type="error"/>
    </template>
@elseif(null !== session($warningKey ?? 'warning_message'))
    <template x-teleport="#toastWrapper">
        <x-partials.notifications.toast :text="session($warningKey ?? 'warning_message')" type="warning"/>
    </template>
@elseif(null !== session($infoKey ?? 'info_message'))
    <template x-teleport="#toastWrapper">
        <x-partials.notifications.toast :text="session($infoKey ?? 'info_message')" type="info"/>
    </template>
@endif
@endif
@if(null !== ($validation ?? null))
    <template x-teleport="#toastWrapper">
        <x-partials.notifications.toast :text="$validation" type="error"/>
    </template>
@endif
