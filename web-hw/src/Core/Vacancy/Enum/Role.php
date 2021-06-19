<?php

declare(strict_types=1);

namespace App\Core\Vacancy\Enum;

use App\Core\Common\Enum\AbstractEnum;

class Role extends AbstractEnum
{
    public const EXPERT  = 'ROLE_EXPERT';
    public const MODERATOR  = 'ROLE_MODERATOR';
    public const USER  = 'ROLE_USER';
}
