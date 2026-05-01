<?php
namespace DAO;

use \Exception as Exception;
use Models\Career as Career;
use DAO\Connection as Connection;

class CareerDAOMySQL {
    private $connection;
    private $tableName = "careers";

    public function __construct($connection = null) {
        $this->connection = $connection ?? Connection::GetInstance();
    }

    // Busca una carrera específica en la BD Local (para el perfil del alumno)
    public function getById($careerId) {
        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE careerId = :careerId";
            $parameters["careerId"] = $careerId;

            $resultSet = $this->connection->Execute($query, $parameters);

            if($resultSet) {
                $row = $resultSet[0];
                $career = new Career();
                $career->setCareerId($row["careerId"]);
                $career->setDescription($row["description"]);
                $career->setActive($row["active"]);
                return $career;
            }
            return null;
        } catch (Exception $ex) { throw $ex; }
    }

    // El "Sincronizador": Trae de API y guarda en BD Local
    public function refreshCareersFromApi() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/careers'); // Ajustá a tu endpoint de la API
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('x-api-key: 4f3b75d0-055a-49a6-8480-281b32f4a434')); // Tu API KEY

        $response = curl_exec($ch);
        $decodedData = json_decode($response, true);

        foreach($decodedData as $careerData) {
            $this->addFromApi($careerData);
        }
    }

    public function addFromApi($data) {
        try {
            // Usamos REPLACE para que si la carrera ya existe, la actualice
            $query = "REPLACE INTO " . $this->tableName . " (careerId, description, active) 
                      VALUES (:careerId, :description, :active);";

            $parameters["careerId"] = $data->getCareerId();
            $parameters["description"] = $data->getDescription();
            $parameters["active"] = $data->getActive() ? 1 : 0;

            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) { throw $ex; }
    }

    public function getAll()
    {
        $careerList = array();
        $query = "SELECT * FROM " . $this->tableName . " ORDER BY description ASC";

        try {
            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $career = new Career();
                $career->setCareerId($row["careerId"]);
                $career->setDescription($row["description"]);
                $career->setActive($row["active"]);
                
                array_push($careerList, $career);
            }
            return $careerList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}