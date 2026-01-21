<?php
    namespace DAO;

    use Models\Company;

    class CompanyDAOApi implements ICompanyDAO
    {
        private string $apiUrl = "https://api.example.com/companies";

        public function add(Company $company): void
        {
            // Simulación POST a API
            // En un caso real usarías cURL o Guzzle
        }

        public function getAll(): array
        {
            // Simulación de respuesta API
            $companyList = [];

            $company1 = new Company();
            $company1->setCompanyId(1);
            $company1->setName("Globant");
            $company1->setEmail("rrhh@globant.com");
            $company1->setActive(true);

            $company2 = new Company();
            $company2->setCompanyId(2);
            $company2->setName("Mercado Libre");
            $company2->setEmail("rrhh@mercadolibre.com");
            $company2->setActive(true);

            $companyList[] = $company1;
            $companyList[] = $company2;

            return $companyList;
        }

        public function getById(int $id): ?Company
        {
            foreach ($this->getAll() as $company) {
                if ($company->getCompanyId() === $id) {
                    return $company;
                }
            }
            return null;
        }

        public function update(Company $company): void
        {
            // Simulación PUT/PATCH a API
        }

        public function delete(int $id): void
        {
            // Simulación DELETE a API
        }
    }
