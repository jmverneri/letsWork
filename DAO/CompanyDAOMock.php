<?php
    namespace DAO;

    use Models\Company;

    class CompanyDAOMock implements ICompanyDAO
    {
        private array $companyList = [];

        public function __construct()
        {
            $company1 = new Company();
            $company1->setCompanyId(1)
                    ->setUserId(3)
                    ->setName("Google")
                    ->setYearFoundation()
                    ->setCity()
                    ->setDescription()
                    ->setLogo()
                    ->setPhoneNumber()
                    ->setCuit()
                    ->setActive(true);

            $company2 = new Company();
            $company2->setCompanyId(2)
                    ->setUserId(4)
                    ->setName("Amazon")
                    ->setYearFoundation()
                    ->setCity()
                    ->setDescription()
                    ->setLogo()
                    ->setPhoneNumber()
                    ->setCuit()
                    ->setActive(true);

            $this->companyList[] = $company1;
            $this->companyList[] = $company2;
        }

        public function add(Company $company): void
        {
            $this->companyList[] = $company;
        }

        public function getAll(): array
        {
            return $this->companyList;
        }

        public function getById(int $id): ?Company
        {
            foreach ($this->companyList as $company) {
                if ($company->getCompanyId() === $id) {
                    return $company;
                }
            }
            return null;
        }

        public function update(Company $company): void
        {
            foreach ($this->companyList as $key => $value) {
                if ($value->getCompanyId() === $company->getCompanyId()) {
                    $this->companyList[$key] = $company;
                    return;
                }
            }
        }

        public function delete(int $id): void
        {
            foreach ($this->companyList as $key => $company) {
                if ($company->getCompanyId() === $id) {
                    unset($this->companyList[$key]);
                }
            }
        }
    }
