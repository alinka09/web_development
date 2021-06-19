<?php

declare(strict_types=1);

namespace App\Api\Vacancy\Factory;


use App\Api\Vacancy\Dto\VacancyResponseDto;
use App\Api\Vacancy\Dto\CompanyResponseDto;
use App\Core\Vacancy\Document\Vacancy;
use App\Core\Vacancy\Document\Company;
use Symfony\Component\HttpFoundation\Response;

class ResponseFactory
{
    /**
     * @param Vacancy     $vacancy
     *
     * @param Company|null $company
     *
     * @return VacancyResponseDto
     */
    public function createVacancyResponse(Vacancy $vacancy, ?Company $company = null): VacancyResponseDto
    {
        $dto = new VacancyResponseDto();

        $dto->id          = $vacancy->getId();
        $dto->name        = $vacancy->getName();
        $dto->description = $vacancy->getDescription();
        $dto->img         = $vacancy->getImg();
        $dto->salary      = $vacancy->getSalary();
        $dto->place_date  = $vacancy->getPlaceDate();
        $dto->division    = $vacancy->getDivision();
        $dto->city        = $vacancy->getCity();
        $dto->company_key = $vacancy->getCompanyKey();

        if($company){
            $companyResponseDto               = new CompanyResponseDto();
            $companyResponseDto->id           = $company->getId();
            $companyResponseDto->name         = $company->getName();
            $companyResponseDto->phone        = $company->getPhone();
            $companyResponseDto->email        = $company->getEmail();
            $companyResponseDto->reg_date     = $company->getRegDate();
            $companyResponseDto->city_company = $company->getCityCompany();
            $companyResponseDto->rating       = $company->getRating();
            $companyResponseDto->company_key  = $company->getCompanyKey();
            $companyResponseDto->roles        = $company->getRoles();

            $dto->company = $companyResponseDto;
        }

        return $dto;
    }
}