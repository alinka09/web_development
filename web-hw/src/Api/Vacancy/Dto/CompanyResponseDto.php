<?php

declare(strict_types=1);

namespace App\Api\Vacancy\Dto;

class CompanyResponseDto
{
    public ?string $id;

    public ?string $email;

    public ?string $city_company;

    public ?float  $rating;

    public ?string $reg_date;

    public ?string $phone;

    public ?string $name;

    public ?string $company_key;

    public array   $roles;
}
