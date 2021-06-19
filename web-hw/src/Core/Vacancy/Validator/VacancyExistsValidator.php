<?php

declare(strict_types=1);

namespace App\Core\Vacancy\Validator;

use App\Core\Vacancy\Repository\VacancyRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class VacancyExistsValidator extends ConstraintValidator
{
    /**
     * @var VacancyRepository
     */
    private VacancyRepository $vacancyRepository;

    public function __construct(VacancyRepository $vacancyRepository)
    {
        $this->vacancyRepository = $vacancyRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof VacancyExists) {
            throw new UnexpectedTypeException($constraint, VacancyExists::class);
        }

        $vacancy = $this->vacancyRepository->findOneBy(['name' => $value->name]);

        if($vacancy) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ title }}', $vacancy->getName())
                ->addViolation();
        }
    }
}
