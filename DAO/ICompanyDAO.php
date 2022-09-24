<?php
    namespace DAO;

    use Models\Company as Company;

    interface ICompanyDAO
    {
        function AddCompany(Company $company);
        function update(Company $company);
        public function GetAll();

    }
?>