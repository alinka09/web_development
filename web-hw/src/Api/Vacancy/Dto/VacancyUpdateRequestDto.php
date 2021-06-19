<?php

declare(strict_types=1);

namespace App\Api\Vacancy\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class VacancyUpdateRequestDto
{
    /**
     * @Assert\Length(max=50)
     */
    public ?string $name = null;

    /**
     * @Assert\Length(max=1000)
     */
    public ?string $description = null;

    public ?string $img = null;

    /**
     * @Assert\Length(max=15)
     */
    public ?int $salary = null;

    /**
     * @Assert\Length(max=10)
     */
    public ?string $place_date = null;

    /**
     * @Assert\Length(max=25)
     */
    public ?string $division = null;

    /**
     * @Assert\Length(max=20)
     */
    public ?string $city = null;

    public ?string $company_key = null;
}
