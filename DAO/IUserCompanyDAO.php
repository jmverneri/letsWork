<?php
    namespace DAO;

    

    interface IUserCompanyDAO
    {
        function getUserCompanyByEmail($email);
        function getCompaniesByUserCompany($userCompanyId);
    }
?>