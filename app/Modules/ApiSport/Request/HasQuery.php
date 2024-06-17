<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Request;

use ReflectionClass;

trait HasQuery
{
    /**
     * @return array<string, int|string>
     */
    public function toQuery(): array
    {
        $query = [];

        foreach ((new ReflectionClass($this))->getProperties() as $property) {
            $query[$property->getName()] = $property->getValue($this);
        }

        return $query;
    }
}
