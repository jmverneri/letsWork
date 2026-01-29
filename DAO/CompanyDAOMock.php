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
                    ->setUserId(4)
                    ->setName("Google")
                    ->setYearFoundation(1980)
                    ->setCity("Mar del Plata")
                    ->setDescription("IT")
                    ->setPhoneNumber("2235888333")
                    ->setActive(true);

            $company2 = new Company();
            $company2->setCompanyId(2)
                    ->setUserId(5)
                    ->setName("Amazon")
                    ->setYearFoundation(1975)
                    ->setCity("CABA")
                    ->setDescription("IT")
                    ->setPhoneNumber("11555333")
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

        public function getByUserId(int $userId): ?Company
        {
            foreach ($this->companyList as $company) {
                if ($company->getUserId() === $userId) {
                    return $company;
                }
            }
            return null;
        }
    }
