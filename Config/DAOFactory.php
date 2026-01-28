<?php
    namespace Config;

    use DAO\IStudentDAO; 
    use DAO\StudentDAOMock;
    use DAO\StudentDAOApi;
    use DAO\StudentDAOMySQL;
    use DAO\ICareerDAO;
    use DAO\CareerDAOMock;
    use DAO\CareerDAOApi;
    use DAO\CareerDAOMySQL;
    use DAO\ICompanyDAO;
    use DAO\CompanyDAOMock;
    use DAO\CompanyDAOApi;
    use DAO\CompanyDAOMySQL;
    use DAO\IJobOfferDAO;
    use DAO\JobOfferDAOMock;
    use DAO\JobOfferDAOApi;
    use DAO\JobOfferDAOMySQL;
    use DAO\IUserDAO;   
    use DAO\UserDAOMock;
    use DAO\IUserCompanyDAO;   
    use DAO\UserCompanyDAOMock;

    class DAOFactory
    {
        public static function getUserDAO(): IUserDAO
        {
            // Cambiás SOLO esta línea
            return new UserDAOMock();
            // return new UserDAOApi();
            // return new UserDAOMySQL();
        }

        public static function getStudentDAO(): IStudentDAO
        {
            // Cambiás SOLO esta línea
            return new StudentDAOMock();
            // return new StudentDAOApi();
            // return new StudentDAOMySQL();
        }

        public static function getCareerDAO(): ICareerDAO
        {
            return new CareerDAOMock();
            // return new CareerDAOApi();
            // return new CareerDAOMySQL();
        }

        public static function getUserCompanyDAO(): IUserCompanyDAO
        {
            return new UserCompanyDAOMock();
            //return new UserCompanyDAOApi();
            //return new UserCompanyDAOMySQL();
        }

        public static function getJobOfferDAO()
        {
            return new JobOfferDAOMock();
            //return new JobOfferDAOApi();
            //return new JobOfferDAOMySQL();
        }
    }
