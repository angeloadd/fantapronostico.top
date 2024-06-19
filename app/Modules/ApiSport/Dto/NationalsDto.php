<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Dto;

final class NationalsDto
{
    /**
     * @var NationalDto[]
     */
    private array $nationals;

    public function __construct(NationalDto ...$nationals)
    {
        $this->nationals = $nationals;
    }

    /**
     * @return NationalDto[]
     */
    public function nationals(): array
    {
        return $this->nationals;
    }

    public function add(NationalDto $national): self
    {
        $this->nationals[] = $national;

        return $this;
    }
}
