<?php

declare(strict_types=1);

namespace App\Api\Vacancy\Dto;

class VacancyResponseDto
{
    public ?string $id;

    public ?string $name;

    public ?string $description;

    public ?string $img;

    public ?int    $salary;

    public ?string $place_date;

    public ?string $division;

    public ?string $city;

    public ?string $company_key;

    public CompanyResponseDto $company;
}
