<?php
    namespace DAO;

    use Models\Admin as Admin;

    interface IAdministratorDAO
    {
        function AddAdministrator(Admin $administrator);
        function update(Admin $administrator);
        public function GetAll();

    }
?>