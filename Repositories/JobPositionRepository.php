<?php
namespace Repositories;

use DAO\JobPositionDAOMySQL as JobPositionDAO;
use Models\JobPosition as JobPosition;

class JobPositionRepository {
    private $jobPositionDAO;
    private $jobPositionList;

    public function __construct() {
        $this->jobPositionDAO = new JobPositionDAO();
        $this->jobPositionList = array();
    }

    public function add(JobPosition $jobPosition) {
        return $this->jobPositionDAO->add($jobPosition);
    }

    /**
     * Trae todas las posiciones desde la base de datos
     */
    public function getAll() {
        // Podríamos cachear la lista en el atributo para no ir a la BD dos veces
        if(empty($this->jobPositionList)) {
            $this->jobPositionList = $this->jobPositionDAO->getAll();
        }
        return $this->jobPositionList;
    }

    /**
     * Busca una posición específica por su ID
     */
    public function getById($id) {
        return $this->jobPositionDAO->getById($id);
    }

    public function update(JobPosition $jobPosition) {
        $this->jobPositionDAO->update($jobPosition);
    }

    public function delete($id) {
        $this->jobPositionDAO->delete($id);
    }

    public function restore($id) {
        $this->jobPositionDAO->restore($id);
    }

    public function getInactive() {
        return $this->jobPositionDAO->getInactive();
    }

    public function searchJobPositionByCareerId($careerId) {
        $this->jobPositionDAO->getByCareerId($careerId);
    }
}