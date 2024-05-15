<?php

declare(strict_types=1);

namespace App\Helpers;

final class Constants
{
    public const DATE_FORMAT = 'd-m-Y H:i:s.u';

    //'18-12-2022 18:00'
    public const FINAL_DATE = 1815536019;

    //18-12-2022 23:59:59
    public const WINNER_DECLARATION_DATE = 1671404399;

    //17-12-2022 18:00
    public const VALIDITY_TIME_FOR_FINAL_BET = 1671296400;

    //20-11-2022 17:00 orario italiano
    public const FIRST_GAME_SART_TIMESTAMP = 1668960000;
}
