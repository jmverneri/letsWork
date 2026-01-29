<?php
namespace Services;

use DAO\IJobOfferDAO;
use Config\DAOFactory;
use Models\JobOffer;
use Exception;

class JobOfferService
{
    private IJobOfferDAO $jobOfferDAO;

    public function __construct()
    {
        $this->jobOfferDAO = DAOFactory::getJobOfferDAO();
    }

    /* =======================
       MÉTODOS DE CONSULTA
    ======================= */

    public function getAll(): array
    {
        return $this->jobOfferDAO->getAll();
    }

    public function getById(int $id): ?JobOffer
    {
        $offer = $this->jobOfferDAO->getById($id);
        if (!$offer) {
            throw new Exception("The requested job offer does not exist.");
        }
        return $offer;
    }

    public function getActive(): array
    {
        return $this->jobOfferDAO->getActive();
    }

    public function getByCompany(int $companyId): array
    {
        return $this->jobOfferDAO->getByCompanyId($companyId);
    }

    public function getByCareer(int $careerId): array
    {
        return $this->jobOfferDAO->getByCareer($careerId);
    }

     public function getExpired(): array
    {

    return $this->jobOfferDAO->getByStatus('expired');

    } 

    /* =======================
       LÓGICA DE GESTIÓN (ABM)
    ======================= */

    public function add(JobOffer $jobOffer): void
    {
        // Regla de Negocio: No se pueden crear ofertas con fechas pasadas
        if ($jobOffer->getDeadline() < date("Y-m-d")) {
            throw new Exception("The deadline cannot be in the past.");
        }
        
        $this->jobOfferDAO->add($jobOffer);
    }

    public function update(JobOffer $jobOffer): void
    {
        // Validar existencia antes de actualizar
        $this->getById($jobOffer->getJobOfferId());
        $this->jobOfferDAO->update($jobOffer);
    }

    public function delete(int $jobOfferId): void
    {
        // Regla de Negocio: Podrías validar que no tenga postulantes antes de borrar
        $applicants = $this->jobOfferDAO->getApplicants($jobOfferId);
        if (!empty($applicants)) {
            throw new Exception("Cannot delete an offer that already has applicants.");
        }
        
        $this->jobOfferDAO->delete($jobOfferId);
    }

    /* =======================
       LÓGICA DE POSTULACIÓN
    ======================= */

    public function addStudentToJobOffer(int $jobOfferId, int $studentId): void
    {
        // 1. Validar existencia y vigencia
        $offer = $this->getById($jobOfferId);

        if (!$offer->getActive()) {
            throw new Exception("This job offer is no longer active.");
        }

        if ($offer->getDeadline() < date("Y-m-d")) {
            throw new Exception("This job offer has expired.");
        }

        // 2. Validar que no esté postulado ya
        if ($this->isStudentEnrolled($jobOfferId, $studentId)) {
            throw new Exception("You are already enrolled in this offer.");
        }

        $this->jobOfferDAO->addPostulation($jobOfferId, $studentId);
    }

    public function isStudentEnrolled(int $jobOfferId, int $studentId): bool
    {
        return $this->jobOfferDAO->checkPostulation($jobOfferId, $studentId);
    }
}