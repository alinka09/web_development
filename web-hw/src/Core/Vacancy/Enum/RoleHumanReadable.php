<?php

declare(strict_types=1);

namespace App\Core\Vacancy\Enum;

use App\Core\Common\Enum\AbstractEnum;

final class RoleHumanReadable extends AbstractEnum
{
    public const EXPERT = 'Экспертный модератор';
    public const MODERATOR  = 'Обычный модератор';
    public const USER  = 'Пользователь';
}
