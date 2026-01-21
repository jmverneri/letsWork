<?php
    namespace DAO;

    use Models\Company;

    interface ICompanyDAO
    {
        public function add(Company $company): void;

        public function getAll(): array;

        public function getById(int $id): ?Company;

        public function update(Company $company): void;

        public function delete(int $id): void;
    }
