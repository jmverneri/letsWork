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
        // 1. El DAOApi ya te devuelve un array de OBJETOS Career
        $careerList = $this->api->getAll();

        if ($careerList && is_array($careerList)) {
            foreach ($careerList as $career) {
                // Solo lo mandamos a la base de datos.
                $this->db->addFromApi($career);
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