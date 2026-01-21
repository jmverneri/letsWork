<?php
    namespace DAO;

    use Models\JobOffer;

    class JobOfferDAOApi implements IJobOfferDAO
    {
        private string $apiUrl = "https://api.example.com/joboffers";

        public function add(JobOffer $jobOffer)
        {
            // POST
        }

        public function update(JobOffer $jobOffer)
        {
            // PUT
        }

        public function delete(int $jobOfferId)
        {
            // DELETE
        }

        public function getById(int $jobOfferId)
        {
            // GET /joboffers/{id}
        }

        public function getAll()
        {
            // GET /joboffers
            return [];
        }

        public function getByCompany(int $companyId)
        {
            // GET /joboffers?companyId=
            return [];
        }

        public function getByCareer(int $careerId)
        {
            return [];
        }

        public function getPublished()
        {
            return [];
        }

        public function getActivePublished()
        {
            return [];
        }
    }
