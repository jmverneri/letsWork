<?php
    namespace Services;

    use DAO\IJobOfferDAO;
    use Config\DAOFactory;
    use Models\JobOffer;

    class JobOfferService
    {
        private IJobOfferDAO $jobOfferDAO;

        public function __construct()
        {
            $this->jobOfferDAO = DAOFactory::getJobOfferDAO();
        }

        /* =======================
        MÉTODOS DE NEGOCIO
        ======================= */

        public function getAll(): array
        {
            return $this->jobOfferDAO->getAll();
        }

        public function getById(int $id): ?JobOffer
        {
            return $this->jobOfferDAO->getById($id);
        }

        public function getActive(): array
        {
            return $this->jobOfferDAO->getActive();
        }

        public function getByCompany(int $companyId): array
        {
            return $this->jobOfferDAO->getByCompany($companyId);
        }

        public function getByCareer(int $careerId): array
        {
            return $this->jobOfferDAO->getByCareer($careerId);
        }

        public function add(JobOffer $jobOffer): void
        {
            $this->jobOfferDAO->add($jobOffer);
        }

        public function update(JobOffer $jobOffer): void
        {
            $this->jobOfferDAO->update($jobOffer);
        }

        public function delete(int $jobOfferId): void
        {
            $this->jobOfferDAO->delete($jobOfferId);
        }

        public function getExpired(): array
        {
            return $this->jobOfferDAO->getByStatus('expired');
        }

    }
