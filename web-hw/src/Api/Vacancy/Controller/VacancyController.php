<?php

declare(strict_types=1);

namespace App\Api\Vacancy\Controller;

use App\Api\Vacancy\Dto\VacancyCreateRequestDto;
use App\Api\Vacancy\Dto\VacancyListResponseDto;
use App\Api\Vacancy\Dto\VacancyResponseDto;
use App\Api\Vacancy\Dto\VacancyUpdateRequestDto;
use App\Api\Vacancy\Dto\CompanyResponseDto;
use App\Api\Vacancy\Dto\ValidationExampleRequestDto;
use App\Core\Common\Dto\ValidationFailedResponse;
use App\Core\Vacancy\Document\Company;
use App\Core\Vacancy\Document\Vacancy;
use App\Core\Vacancy\Enum\Permission;
use App\Core\Vacancy\Enum\Role;
use App\Core\Vacancy\Enum\RoleHumanReadable;
use App\Core\Vacancy\Repository\CompanyRepository;
use App\Core\Vacancy\Repository\VacancyRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @Route("/vacancy")
 */
class VacancyController extends AbstractController
{
    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"GET"})
     *
     * @IsGranted(Permission::VACANCY_SHOW)
     *
     * @ParamConverter("vacancy")
     *
     * @Rest\View()
     *
     * @param Vacancy|null $vacancy
     *
     * @return VacancyResponseDto
     */
    public function show(
        Vacancy $vacancy = null,
        CompanyRepository $companyRepository
    ): VacancyResponseDto
    {
        if (!$vacancy) {
            throw $this->createNotFoundException('Vacancy not found');
        }

        $company = $companyRepository->findOneBy(['company_key' => $vacancy->getCompanyKey()]);

        return $this->createVacancyResponse($vacancy, $company);
    }

    /**
     * @Route(path="", methods={"GET"})
     * @IsGranted(Permission::VACANCY_INDEX)
     * @Rest\View()
     *
     * @return VacancyListResponseDto|ValidationFailedResponse
     */
    public function index(
        Request $request,
        VacancyRepository $vacancyRepository
    ): VacancyListResponseDto {
        $page     = (int)$request->get('page');
        $quantity = (int)$request->get('slice');

        $job      = $vacancyRepository->findBy([], [], $quantity, $quantity * ($page - 1));

        return new VacancyListResponseDto(
            ... array_map(
                    function (Vacancy $vacancy) {
                        return $this->createVacancyResponse($vacancy, null);
                    },
                    $job
                )
        );
    }

    /**
     * @Route(path="", methods={"POST"})
     * @IsGranted(Permission::VACANCY_CREATE)
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View(statusCode=201)
     *
     * @param VacancyCreateRequestDto            $requestDto
     * @param ConstraintViolationListInterface   $validationErrors
     * @param VacancyRepository                  $vacancyRepository
     *
     * @return VacancyResponseDto|ValidationFailedResponse|Response
     */
    public function create(
        VacancyCreateRequestDto            $requestDto,
        ConstraintViolationListInterface   $validationErrors,
        VacancyRepository                  $vacancyRepository
    ) {
        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

        if ($vacancy = $vacancyRepository->findOneBy(['name' => $requestDto->name])) {
            return new Response('Vacancy already exists', Response::HTTP_BAD_REQUEST);
        }

        $vacancy = new Vacancy(
            $requestDto->name,
            $requestDto->description,
            $requestDto->img,
            $requestDto->salary,
            $requestDto->place_date,
            $requestDto->division,
            $requestDto->city,
            $requestDto->company_key,
        );
        $vacancy->setName($requestDto->name);
        $vacancy->setDescription($requestDto->description);
        $vacancy->setImg($requestDto->img);
        $vacancy->setSalary($requestDto->salary);
        $vacancy->setPlaceDate($requestDto->place_date);
        $vacancy->setDivision($requestDto->division);
        $vacancy->setCity($requestDto->city);
        $vacancy->setCompanyKey($requestDto->company_key);

        $vacancyRepository->save($vacancy);

        return $this->createVacancyResponse($vacancy, null);
    }

    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"PUT"})
     * @IsGranted(Permission::VACANCY_UPDATE)
     * @ParamConverter("company")
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View()
     *
     * @param VacancyUpdateRequestDto            $requestDto
     * @param ConstraintViolationListInterface   $validationErrors
     * @param VacancyRepository                  $vacancyRepository
     *
     * @return VacancyResponseDto|ValidationFailedResponse|Response
     */
    public function update(
        Vacancy                            $vacancy = null,
        VacancyUpdateRequestDto            $requestDto,
        ConstraintViolationListInterface   $validationErrors,
        VacancyRepository                  $vacancyRepository
    ) {
        if (!$vacancy) {
            throw $this->createNotFoundException('Vacancy not found');
        }

        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

        $vacancy->setName($requestDto->name);
        $vacancy->setDescription($requestDto->description);
        $vacancy->setImg($requestDto->img);
        $vacancy->setSalary($requestDto->salary);
        $vacancy->setPlaceDate($requestDto->place_date);
        $vacancy->setDivision($requestDto->division);
        $vacancy->setCity($requestDto->city);
        $vacancy->setCompanyKey($requestDto->company_key);

        $vacancyRepository->save($vacancy);

        return $this->createVacancyResponse($vacancy, null);
    }

    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"DELETE"})
     * @IsGranted(Permission::VACANCY_DELETE)
     * @ParamConverter("company")
     *
     * @Rest\View()
     *
     * @param Vacancy|null      $vacancy
     * @param VacancyRepository $vacancyRepository
     *
     * @return VacancyResponseDto|ValidationFailedResponse
     */
    public function delete(
        VacancyRepository $vacancyRepository,
        Vacancy           $vacancy = null
    ) {
        if (!$vacancy) {
            throw $this->createNotFoundException('Vacancy not found');
        }

        $vacancyRepository->remove($vacancy);
    }

    /**
     * @Route(path="/validation", methods={"POST"})
     * @IsGranted(Permission::VACANCY_VALIDATION)
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View()
     *
     * @return ValidationExampleRequestDto|ValidationFailedResponse
     */
    public function validation(
        ValidationExampleRequestDto      $requestDto,
        ConstraintViolationListInterface $validationErrors
    ) {
        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

        return $requestDto;
    }

    /**
     * @param Vacancy $vacancy
     *
     * @param Company|null $company
     *
     * @return VacancyResponseDto
     */
    private function createVacancyResponse(Vacancy $vacancy, ?Company $company): VacancyResponseDto
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
