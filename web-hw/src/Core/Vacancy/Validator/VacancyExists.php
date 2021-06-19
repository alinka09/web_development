<?php

declare(strict_types=1);

namespace App\Core\Vacancy\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class VacancyExists extends Constraint
{
    public $message = 'Vacancy already exists, title: {{ title }}';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}