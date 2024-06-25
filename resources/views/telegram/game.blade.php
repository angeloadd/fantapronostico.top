@php
/** @var \App\Modules\League\Dto\TelegramReminderViewDto $dto */

$route = route('prediction.create', ['game' => $dto->gameId]);
@endphp

<a href="{{$route}}">{{$route}}</a>
<strong>{{__($dto->homeTeamName)}}</strong> - <strong>{{__($dto->awayTeamName)}}</strong>
<strong>{{$dto->formattedBefore}}</strong>
