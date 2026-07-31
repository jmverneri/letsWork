<?php

namespace Repositories;

use DAO\CareerDAOMySQL;
use DAO\CareerDAOApi;
use Models\Career;

class CareerRepository 
{
    private CareerDAOMySQL $db;
    private CareerDAOApi $api;

    public function __construct() 
    {
        $this->db = new CareerDAOMySQL();
        $this->api = new CareerDAOApi();
    }

    public function syncFromApi() 
    {
        // 1. El DAOApi devuelve un array de OBJETOS Career
        $careerList = $this->api->getAll();

        if ($careerList && is_array($careerList)) {
            foreach ($careerList as $apiCareer) {
                
                // 2. Verificamos si la carrera ya existe en MySQL
                $localCareer = $this->db->getById($apiCareer->getCareerId());

                if (!$localCareer) {
                    // Si NO existe, la insertamos
                    $this->db->add($apiCareer);
                } else {
                    // Si YA existe, actualizamos solo la descripción de la API
                    // y mantenemos el estado 'active' que tiene localmente
                    $localCareer->setDescription($apiCareer->getDescription());
                    
                    $this->db->update($localCareer);
                }
            }
            return true;
        }
        
        return false;
    }

    public function getAll() 
    {
        return $this->db->getAll();
    }

    public function getById($careerId)
    {
        // 1. Buscamos en BD local
        $career = $this->db->getById($careerId);

        // 2. Si no está, lo buscamos en la API (usando los nombres correctos del constructor)
        if (!$career) {
            $career = $this->api->getById($careerId);

            if ($career) {
                $this->db->addFromApi($career);
            }
        }

        return $career;
    }
}