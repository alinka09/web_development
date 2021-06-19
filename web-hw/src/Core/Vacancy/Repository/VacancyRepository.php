<?php

declare(strict_types=1);

namespace App\Core\Vacancy\Repository;

use App\Core\Common\Repository\AbstractRepository;
use App\Core\Vacancy\Document\Vacancy;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;

/**
 * @method Vacancy      save(Vacancy $vacancy)
 * @method Vacancy|null find(string $id)
 * @method Vacancy|null findOneBy(array $criteria)
 * @method Vacancy      getOne(string $id)
 */
class VacancyRepository extends AbstractRepository
{
    public function getDocumentClassName(): string
    {
        return Vacancy::class;
    }

    /**
     * @throws LockException
     * @throws MappingException
     */
    public function getVacancyById(string $id): ?Vacancy
    {
        return $this->find($id);
    }
}
