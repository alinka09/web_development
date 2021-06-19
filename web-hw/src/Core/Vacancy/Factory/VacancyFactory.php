<?php

declare(strict_types=1);

namespace App\Core\Vacancy\Factory;

use App\Core\Vacancy\Document\Vacancy;

class VacancyFactory
{
    public function create
    (
        string $name,
        string $description,
        string $img,
        int    $salary,
        string $place_date,
        string $division,
        string $city,
        string $company_key
    ): Vacancy
    {
        return new Vacancy(
            $name,
            $description,
            $img,
            $salary,
            $place_date,
            $division,
            $city,
            $company_key
        );
    }

    public function update
    (
        string $name,
        string $description,
        string $img,
        int    $salary,
        string $place_date,
        string $division,
        string $city,
        string $company_key
    ): Vacancy
    {
        return new Vacancy(
            $name,
            $description,
            $img,
            $salary,
            $place_date,
            $division,
            $city,
            $company_key
        );
    }
}