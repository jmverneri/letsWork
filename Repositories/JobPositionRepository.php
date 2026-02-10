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
        $this->getAll(); // Cargamos la lista si está vacía
        
        foreach($this->jobPositionList as $position) {
            if($position->getJobPositionId() == $id) {
                return $position;
            }
        }
        return null;
    }
}