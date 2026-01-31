<?php
namespace DAO;

class CareerDAOApi 
{
    public function getAll() 
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/careers/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Importante para FastAPI
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'x-api-key: ' . API_KEY, 
            'Accept: application/json'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode !== 200) {
            // Podrías loguear el error aquí si quisieras
            return null;
        }

        return json_decode($response, true);
    }
}