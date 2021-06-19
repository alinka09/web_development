<?php

declare(strict_types=1);

namespace App\Core\Vacancy\Repository;

use App\Core\Common\Repository\AbstractRepository;
use App\Core\Vacancy\Document\Company;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;

/**
 * @method Company      save(Company $company)
 * @method Company|null find(string $id)
 * @method Company|null findOneBy(array $criteria)
 * @method Company      getOne(string $id)
 */
class CompanyRepository extends AbstractRepository
{
    public function getDocumentClassName(): string
    {
        return Company::class;
    }

    /**
     * @throws LockException
     * @throws MappingException
     */
    public function getCompanyById(string $id): ?Company
    {
        return $this->find($id);
    }
}
