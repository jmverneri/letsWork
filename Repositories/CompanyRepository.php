<?php

namespace Repositories;

use DAO\CompanyDAOMySQL;
use Models\Company;

class CompanyRepository {
    private $dao;

    public function __construct() {
        $this->dao = new CompanyDAOMySQL();
    }

    public function syncFromApi() {
        // Llamada a la API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/companies"); // O el link que uses
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('x-api-key: 4f3b75d0-055a-49a6-8480-281b32f4a434'));
        
        $response = curl_exec($ch);
        $decodedData = json_decode($response, true);
        curl_close($ch);

        if($decodedData) {
            foreach($decodedData as $data) {
                $company = new Company();
                $company->setExternalId($data['companyId']); // ID de la API
                $company->setName($data['name']);
                $company->setEmail($data['email'] ?? '');
                $company->setActive($data['active']);

                // El DAO usa INSERT ... ON DUPLICATE KEY UPDATE
                $this->dao->addOrUpdateFromApi($company);
            }
        }
    }
}