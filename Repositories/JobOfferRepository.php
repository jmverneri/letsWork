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

    /** @var JobOffer[] */ // Esto le dice a VSCode que el método devuelve una lista de ofertas
    public function getByCompanyId($companyId)
    {
        $allOffers = $this->getAll();
        $filtered = array_filter($allOffers, function($offer) use ($companyId) {
            return $offer->getCompanyId() == $companyId;
        });

        // Usamos array_values para resetear los índices y que sea un array limpio [0, 1, 2...]
        return array_values($filtered);
    }

    public function update(JobOffer $jobOffer)
    {
        // Le pasamos la pelota al DAO, que es el que sabe hablar con la DB
        $this->jobOfferDAO->update($jobOffer);
    }

    public function updateActiveStatus($id, $status)
    {
        // Pasamos el ID y el nuevo estado (true/false o 1/0)
        $this->jobOfferDAO->updateActiveStatus($id, $status);
    }
}