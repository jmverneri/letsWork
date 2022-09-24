<?php

    namespace DAO;

    use Models\JobOffer as JobOffer;

    interface IStudentByJobOfferDAO
    {
        //public function getAllStudentByJobOffer();
        public function getOne($studentId, $jobOfferId);
        public function getByJobOfferId($jobOfferId);
        public function addStudentToAJobOffer($jobOfferid, $studentId);
       // public function updateJobOffer(JobOffer $jobOffer);
        //public function searchJobOfferById($jobOfferId);
        //public function searchJobOfferByName($jobOfferId);
       
    }
    
    ?>