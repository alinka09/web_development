<?php

declare(strict_types=1);

namespace App\Core\Vacancy\Command;

use App\Core\Vacancy\Document\Company;
use App\Core\Vacancy\Repository\CompanyRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUser extends Command
{
    protected static $defaultName = 'app:core:create-company-vacancy';

    private CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        parent::__construct();

        $this->companyRepository = $companyRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a new company.')
            ->setHelp('This command allows you to create a company...')
            ->addOption('email',        null, InputOption::VALUE_OPTIONAL, 'Email')
            ->addOption('city_company', null, InputOption::VALUE_OPTIONAL, 'City')
            ->addOption('rating',       null, InputOption::VALUE_OPTIONAL, 'Rating')
            ->addOption('reg_date',     null, InputOption::VALUE_OPTIONAL, 'Registration date')
            ->addOption('phone',        null, InputOption::VALUE_OPTIONAL, 'Phone')
            ->addOption('name',         null, InputOption::VALUE_OPTIONAL, 'Name')
            ->addOption('company_key',  null, InputOption::VALUE_OPTIONAL, 'Company key')
            ->addOption('roles',        null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Roles');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($company = $this->companyRepository->findOneBy(['phone' => $input->getOption('phone')])) {
            $output->writeln(
                [
                    'Company already exists!',
                    '============',
                    $this->formatCompanyLine($company),
                ]
            );

            return Command::SUCCESS;
        }

        $company = new Company(
            $input->getOption('email'),
            $input->getOption('city_company'),
            $input->getOption('rating'),
            $input->getOption('reg_date'),
            $input->getOption('phone'),
            $input->getOption('name'),
            $input->getOption('company_key'),
            $input->getOption('roles')
        );
        $company->setEmail($input->getOption('email'));
        $company->setCityCompany($input->getOption('city_company'));
        $company->setRating($input->getOption('rating'));
        $company->setRegDate($input->getOption('reg_date'));
        $company->setPhone($input->getOption('phone'));
        $company->setName($input->getOption('name'));
        $company->setCompanyKey($input->getOption('company_key'));
        $company->setRoles($input->getOption('roles'));


        $this->companyRepository->save($company);

        $output->writeln(
            [
                'Company is created!',
                '============',
                $this->formatCompanyLine($company),
            ]
        );

        return Command::SUCCESS;
    }

    private function formatCompanyLine(Company $company): string
    {
        return sprintf(
            'id: %s, email: %s, city_company: %s, rating: %s, reg_date: %s, phone: %s, name: %s, company_key: %s, roles: %s',
            $company->getId(),
            $company->getEmail(),
            $company->getCityCompany(),
            $company->getRating(),
            $company->getRegDate(),
            $company->getPhone(),
            $company->getName(),
            $company->getCompanyKey(),
            implode(',', $company->getRoles()),
        );
    }
}
