<?php
namespace Repositories;

use DAO\JobOfferDAOMySQL as JobOfferDAO;
use DAO\JobPositionDAOMySQL as JobPositionDAO;
use Models\JobOffer as JobOffer;

class JobOfferRepository
{
    private $jobOfferDAO;
    private $jobPositionDAO;

    public function __construct()
    {
        $this->jobOfferDAO = new JobOfferDAO();
        $this->jobPositionDAO = new JobPositionDAO();
    }

    public function add(JobOffer $jobOffer)
    {
        // Aquí podrías validar que la fecha de cierre sea posterior a la de inicio
        $this->jobOfferDAO->add($jobOffer);
    }

    public function getAll()
    {
        return $this->jobOfferDAO->getAll();
    }

    public function getById($id)
    {
        return $this->jobOfferDAO->getById($id);
    }

    public function delete($id)
    {
        // Borrado lógico
        $this->jobOfferDAO->updateActiveStatus($id, false);
    }

    // Método extra para el Admin: Filtrar ofertas por empresa
    public function getByCompanyId($companyId)
    {
        return array_filter($this->getAll(), function($offer) use ($companyId) {
            return $offer->getCompanyId() == $companyId;
        });
    }
}