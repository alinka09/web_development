<?php

declare(strict_types=1);

namespace App\Core\Vacancy\Document;

use App\Core\Common\Document\AbstractDocument;
use App\Core\Vacancy\Enum\Role;
use App\Core\Vacancy\Enum\UserStatus;
use App\Core\Vacancy\Repository\VacancyRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass=VacancyRepository::class, collection="Vacancy")
 */
class Vacancy extends AbstractDocument
{
    /**
     * @MongoDB\Id
     */
    protected ?string $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $name;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $description;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $img;

    /**
     * @MongoDB\Field(type="int")
     */
    protected int $salary;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $place_date;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $division;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $city;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $company_key;

    public function __construct(
        string $name,
        string $description,
        string $img,
        int    $salary,
        string $place_date,
        string $division,
        string $city,
        string $company_key
    ) {
        $this->name        = $name;
        $this->description = $description;
        $this->img         = $img;
        $this->salary      = $salary;
        $this->place_date  = $place_date;
        $this->division    = $division;
        $this->city        = $city;
        $this->company_key = $company_key;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): void
    {
        $this->img = $img;
    }

    public function getSalary(): int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): void
    {
        $this->salary = $salary;
    }

    public function getPlaceDate(): ?string
    {
        return $this->place_date;
    }

    public function setPlaceDate(?string $place_date): void
    {
        $this->place_date = $place_date;
    }

    public function getDivision(): ?string
    {
        return $this->division;
    }

    public function setDivision(?string $division): void
    {
        $this->division = $division;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    public function getCompanyKey(): ?string
    {
        return $this->company_key;
    }

    public function setCompanyKey(?string $company_key): void
    {
        $this->company_key = $company_key;
    }
}
