<?php
    namespace DAO;

    use Models\JobOffer;

    interface IJobOfferDAO
    {
        /* =======================
        CRUD BÁSICO
        ======================= */

        public function add(JobOffer $jobOffer): void;

        public function update(JobOffer $jobOffer): void;

        public function delete(int $jobOfferId): void;

        public function getById(int $jobOfferId): ?JobOffer;

        public function getAll(): array;


        /* =======================
        CONSULTAS DE NEGOCIO
        ======================= */

        /**
         * Devuelve todas las ofertas de una empresa
         */
        public function getByCompanyId(int $companyId): array;

        /**
         * Devuelve todas las ofertas asociadas a una carrera
         */
        public function getByCareerId(int $careerId): array;

        /**
         * Devuelve ofertas por estado (draft | published | closed)
         */
        public function getByStatus(string $status): array;

        /**
         * Ofertas publicadas y vigentes (deadline >= hoy)
         * Caso típico para estudiantes
         */
        public function getActivePublished(): array;

    }
