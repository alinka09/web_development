<?php

declare(strict_types=1);

namespace App\Core\Vacancy\Document;

use App\Core\Common\Document\AbstractDocument;
use App\Core\Vacancy\Enum\Role;
use App\Core\Vacancy\Enum\UserStatus;
use App\Core\Vacancy\Repository\CompanyRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @MongoDB\Document(repositoryClass=CompanyRepository::class, collection="Company")
 */
class Company extends AbstractDocument implements UserInterface
{
    /**
     * @MongoDB\Id
     */
    protected ?string $id = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $email;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $city_company = null;

    /**
     * @MongoDB\Field(type="float")
     */
    protected ?float $rating = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $reg_date = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $phone = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $name;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $company_key;

    /**
     * @var string[]
     *
     * @MongoDB\Field(type="collection")
     */
    protected array $roles = [];

    public function __construct(
        string $email,
        string $cityCompany,
        float  $rating,
        string $reg_date,
        string $phone,
        string $name,
        string $company_key,
        array  $roles
    ) {
        $this->email        = $email;
        $this->city_company = $cityCompany;
        $this->rating       = $rating;
        $this->reg_date     = $reg_date;
        $this->phone        = $phone;
        $this->name         = $name;
        $this->company_key  = $company_key;

        array_map([$this, 'addRole'], $roles);

        $this->addDefaultRole();
    }


    /**
     * @return array<string>
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array<string> $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;

        $this->addDefaultRole();
    }

    public function addRole(string $role): void
    {
        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }
    }


    public function getId(): ?string
    {
        return $this->id;
    }


    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getCityCompany(): ?string
    {
        return $this->city_company;
    }

    public function setCityCompany(?string $city_company): void
    {
        $this->city_company = $city_company;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): void
    {
        $this->rating = $rating;
    }

    public function getRegDate(): ?string
    {
        return $this->reg_date;
    }

    public function setRegDate(?string $reg_date): void
    {
        $this->reg_date = $reg_date;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    private function addDefaultRole(): void
    {
        $this->addRole(Role::USER);
    }

    public function getPassword(): string
    {
        return $this->phone;
    }

    public function getSalt(): string
    {
        return md5($this->company_key);
    }

    public function getUsername(): string
    {
        return $this->company_key;
    }

    public function getCompanyKey(): ?string
    {
        return $this->company_key;
    }

    public function setCompanyKey(?string $company_key): void
    {
        $this->company_key = $company_key;
    }

    public function eraseCredentials(): void
    {
    }
}
