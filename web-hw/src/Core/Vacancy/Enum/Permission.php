<?php

declare(strict_types=1);

namespace App\Core\Vacancy\Enum;

use App\Core\Common\Enum\AbstractEnum;

class Permission extends AbstractEnum
{
    public const VACANCY_SHOW       = 'ROLE_VACANCY_SHOW';
    public const VACANCY_INDEX      = 'ROLE_VACANCY_INDEX';
    public const VACANCY_CREATE     = 'ROLE_VACANCY_CREATE';
    public const VACANCY_UPDATE     = 'ROLE_VACANCY_UPDATE';
    public const VACANCY_DELETE     = 'ROLE_VACANCY_DELETE';
    public const VACANCY_VALIDATION = 'ROLE_VACANCY_VALIDATION';
}
