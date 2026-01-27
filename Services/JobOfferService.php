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

        /* =======================
       LÓGICA DE POSTULACIÓN (ESTUDIANTES)
         ======================= */

        /**
         * Registra la postulación de un estudiante a una oferta.
         * Este es el método que te faltaba.
         */
        public function addStudentToJobOffer(int $jobOfferId, int $studentId): void
        {
            // 1. Validar si la oferta sigue vigente
            $offer = $this->getById($jobOfferId);
            if (!$offer) {
                throw new Exception("The job offer does not exist.");
            }

            $today = date("Y-m-d");
            if ($offer->getDeadline() < $today) {
                throw new Exception("This job offer has expired.");
            }

            // 2. Llamar al DAO para persistir la relación
            // Asegúrate de que tu DAO tenga este método para insertar en la tabla intermedia
            $this->jobOfferDAO->addPostulation($jobOfferId, $studentId);
        }

        /**
         * Verifica si un estudiante ya se postuló a una oferta específica
         */
        public function isStudentEnrolled(int $jobOfferId, int $studentId): bool
        {
            return $this->jobOfferDAO->checkPostulation($jobOfferId, $studentId);
        }
    }
