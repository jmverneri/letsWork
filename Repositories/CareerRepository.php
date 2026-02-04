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

    public function getById($careerId)
    {
        // 1. Intentamos buscar en la base de datos local
        $career = $this->db->getById($careerId);

        // 2. Si no existe, lo buscamos en la API
        if (!$career) {
            $career = $this->careerDAOApi->getById($careerId);

            // 3. Si la API lo encontró, lo guardamos en nuestra BD para el futuro
            if ($career) {
                $this->careerDAOMySQL->add($career);
            }
        }

        return $career;
    }
}