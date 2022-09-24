<?php

    namespace DAO;

    use Models\JobOffer as JobOffer;

    interface IJobOfferDAO 
    {
        public function getAllJobOffer();
        public function deleteJobOffer($idJobOffer);
        public function addJobOffer(JobOffer $jobOffer);
        public function updateJobOffer(JobOffer $jobOffer);
        public function searchJobOfferById($jobOfferId);
        public function searchJobOfferByName($jobOfferId);
       
    }
    
    ?>