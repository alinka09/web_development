<?php

declare(strict_types=1);

namespace App\Api\Vacancy\Dto;

use App\Core\Vacancy\Validator\VacancyExists;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @VacancyExists()
 */
class VacancyCreateRequestDto
{
    /**
     * @Assert\Length(max=50)
     */
    public ?string $name;

    /**
     * @Assert\Length(max=1000)
     */
    public ?string $description;

    public ?string $img;

    /**
     * @Assert\Length(max=10)
     */
    public int $salary;

    /**
     * @Assert\Length(max=10)
     */
    public ?string $place_date;

    /**
     * @Assert\Length(max=30)
     */
    public ?string $division;

    /**
     * @Assert\Length(max=20)
     */
    public ?string $city;

    /**
     * @Assert\Length(max=15)
     */
    public ?string $company_key;

}
