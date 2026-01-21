<?php
namespace DAO;

use Models\Career;

class CareerDAOApi implements ICareerDAO
{
    public function getAll(): array
    {
        $options = [
            'http' => [
                'method'  => 'GET',
                'header'  => "x-api-key: " . API_KEY
            ]
        ];

        $context  = stream_context_create($options);
        $response = file_get_contents(API_URL . 'careers', false, $context);
        $data     = json_decode($response, true);

        $careerList = [];

        foreach ($data as $item) {
            $career = (new Career())
                ->setCareerId($item['careerId'])
                ->setDescription($item['description'])
                ->setActive($item['active']);

            $careerList[] = $career;
        }

        return $careerList;
    }

    public function getById(int $careerId): ?Career
    {
        foreach ($this->getAll() as $career) {
            if ($career->getCareerId() === $careerId) {
                return $career;
            }
        }
        return null;
    }

    public function add(Career $career): bool
    {
        // opcional según tu API
        return true;
    }
}
