<?php

declare(strict_types=1);

namespace App\Api\Vacancy\Dto;

class VacancyListResponseDto
{
    public array $data;

    public function __construct(VacancyResponseDto ... $data)
    {
        $this->data = $data;
    }
}
