<?php

declare(strict_types=1);

namespace App\Core\Vacancy\Service;

use App\Api\Vacancy\Dto\VacancyCreateRequestDto;
use App\Api\Vacancy\Dto\VacancyUpdateRequestDto;
use App\Core\Vacancy\Document\Vacancy;
use App\Core\Vacancy\Factory\VacancyFactory;
use App\Core\Vacancy\Repository\VacancyRepository;
use Psr\Log\LoggerInterface;

class VacancyService
{
    /**
     * @var VacancyRepository
     */
    private VacancyRepository $vacancyRepository;
    /**
     * @var VacancyFactory
     */
    private VacancyFactory $vacancyFactory;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct
    (
        LoggerInterface $logger,
        VacancyRepository $vacancyRepository,
        VacancyFactory    $vacancyFactory
    )
    {
        $this->vacancyRepository = $vacancyRepository;
        $this->vacancyFactory    = $vacancyFactory;
        $this->logger            = $logger;
    }

    public function createVacancy(VacancyCreateRequestDto $requestDto): Vacancy
    {
        $vacancy = $this->vacancyFactory->create
        (
            $requestDto->name,
            $requestDto->description,
            $requestDto->img,
            $requestDto->salary,
            $requestDto->place_date,
            $requestDto->division,
            $requestDto->city,
            $requestDto->company_key
        );
        $vacancy->setName($requestDto->name);
        $vacancy->setDescription($requestDto->description);
        $vacancy->setImg($requestDto->img);
        $vacancy->setSalary($requestDto->salary);
        $vacancy->setPlaceDate($requestDto->place_date);
        $vacancy->setDivision($requestDto->division);
        $vacancy->setCity($requestDto->city);
        $vacancy->setCompanyKey($requestDto->company_key);

        $vacancy = $this->vacancyRepository->save($vacancy);

        $this->logger->info('Vacancy created successfully', [
            'id' => $vacancy->getId()
        ]);

        return $vacancy;
    }

    public function updateVacancy(Vacancy $vacancy = null, VacancyUpdateRequestDto $requestDto): Vacancy
    {
        $vacancy->setName($requestDto->name);
        $vacancy->setDescription($requestDto->description);
        $vacancy->setImg($requestDto->img);
        $vacancy->setSalary($requestDto->salary);
        $vacancy->setPlaceDate($requestDto->place_date);
        $vacancy->setDivision($requestDto->division);
        $vacancy->setCity($requestDto->city);
        $vacancy->setCompanyKey($requestDto->company_key);

        $vacancy = $this->vacancyRepository->save($vacancy);

        $this->logger->info('Vacancy updated successfully', [
            'id' => $vacancy->getId()
        ]);

        return $vacancy;
    }
}