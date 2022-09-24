<?php
    namespace DAO;

    use Models\Administrator as Administrator;

    interface IAdministratorDAO
    {
        function AddAdministrator(Administrator $administrator);
        function update(Administrator $administrator);
        public function GetAll();

    }
?>