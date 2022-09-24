<?php

    namespace DAO;

    use Models\JobPosition as JobPosition;

    interface IJobPositionDAO
    {
        public function GetAllJobpositions();
        public function DeleteJobPosition($jobPosition);
        public function AddJobPosition(JobPosition $jobPosition);
        public function UpdateJobPosition(JobPosition $jobPosition);
        public function SearchJobPositionById($jobPosition);
    }

    ?>