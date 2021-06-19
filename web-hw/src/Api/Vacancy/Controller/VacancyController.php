<?php

declare(strict_types=1);

namespace App\Api\Vacancy\Controller;

use App\Api\Vacancy\Dto\VacancyCreateRequestDto;
use App\Api\Vacancy\Dto\VacancyListResponseDto;
use App\Api\Vacancy\Dto\VacancyResponseDto;
use App\Api\Vacancy\Dto\VacancyUpdateRequestDto;
use App\Api\Vacancy\Dto\CompanyResponseDto;
use App\Api\Vacancy\Dto\ValidationExampleRequestDto;
use App\Api\Vacancy\Factory\ResponseFactory;
use App\Core\Common\Dto\ValidationFailedResponse;
use App\Core\Common\Factory\HTTPResponseFactory;
use App\Core\Vacancy\Document\Company;
use App\Core\Vacancy\Document\Vacancy;
use App\Core\Vacancy\Enum\Permission;
use App\Core\Vacancy\Enum\Role;
use App\Core\Vacancy\Enum\RoleHumanReadable;
use App\Core\Vacancy\Repository\CompanyRepository;
use App\Core\Vacancy\Repository\VacancyRepository;
use App\Core\Vacancy\Service\VacancyService;
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
     * @param ResponseFactory $responseFactory
     *
     * @return VacancyResponseDto
     */
    public function show(
        Vacancy           $vacancy = null,
        CompanyRepository $companyRepository,
        ResponseFactory   $responseFactory
    ): VacancyResponseDto
    {
        if (!$vacancy) {
            throw $this->createNotFoundException('Vacancy not found');
        }

        $company = $companyRepository->findOneBy(['company_key' => $vacancy->getCompanyKey()]);

        return $responseFactory->createVacancyResponse($vacancy, $company);
    }

    /**
     * @Route(path="", methods={"GET"})
     * @IsGranted(Permission::VACANCY_INDEX)
     * @Rest\View()
     *
     * @param Request           $request
     * @param VacancyRepository $vacancyRepository
     * @param ResponseFactory   $responseFactory
     *
     * @return VacancyListResponseDto|ValidationFailedResponse
     */
    public function index(
        Request           $request,
        VacancyRepository $vacancyRepository,
        ResponseFactory   $responseFactory
    ): VacancyListResponseDto {
        $page     = (int)$request->get('page');
        $quantity = (int)$request->get('slice');

        $job      = $vacancyRepository->findBy([], [], $quantity, $quantity * ($page - 1));

        return new VacancyListResponseDto(
            ... array_map(
                    function (Vacancy $vacancy) use ($responseFactory) {
                        return $responseFactory->createVacancyResponse($vacancy, null);
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
     * @param VacancyService                     $service
     * @param ResponseFactory                    $responseFactory
     * @param HTTPResponseFactory                $HTTPResponseFactory
     *
     * @return VacancyResponseDto|Response
     */
    public function create(
        VacancyCreateRequestDto            $requestDto,
        ConstraintViolationListInterface   $validationErrors,
        VacancyService                     $service,
        ResponseFactory                    $responseFactory,
        HTTPResponseFactory                $HTTPResponseFactory
    ) {
        if ($validationErrors->count() > 0) {
            return $HTTPResponseFactory->createValidationFailedResponse($validationErrors);
        }

        return $responseFactory->createVacancyResponse($service->createVacancy($requestDto));

    }

    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"PUT"})
     * @IsGranted(Permission::VACANCY_UPDATE)
     * @ParamConverter("company")
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View()
     *
     * @param Vacancy|null                       $vacancy
     * @param VacancyUpdateRequestDto            $requestDto
     * @param ConstraintViolationListInterface   $validationErrors
     * @param VacancyService                     $service
     * @param ResponseFactory                    $responseFactory
     *
     * @return VacancyResponseDto|ValidationFailedResponse|Response
     */
    public function update(
        Vacancy                            $vacancy = null,
        VacancyUpdateRequestDto            $requestDto,
        ConstraintViolationListInterface   $validationErrors,
        VacancyService                     $service,
        ResponseFactory                    $responseFactory
    ) {
        if (!$vacancy) {
            throw $this->createNotFoundException('Vacancy not found');
        }

        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

        return $responseFactory->createVacancyResponse($service->updateVacancy($vacancy, $requestDto));
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
}
