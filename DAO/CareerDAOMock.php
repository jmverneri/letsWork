<?php
namespace DAO;

use Models\Career;

class CareerDAOMock implements ICareerDAO
{
    private array $careerList = [];

    public function __construct()
    {
        $career1 = (new Career())
            ->setCareerId(1)
            ->setDescription("Computer Science")
            ->setActive(true);

        $career2 = (new Career())
            ->setCareerId(2)
            ->setDescription("Law")
            ->setActive(true);

        $this->careerList = [$career1, $career2];
    }

    public function getAll(): array
    {
        return $this->careerList;
    }

    public function getById(int $careerId): ?Career
    {
        foreach ($this->careerList as $career) {
            if ($career->getCareerId() === $careerId) {
                return $career;
            }
        }
        return null;
    }

    public function add(Career $career): bool
    {
        $this->careerList[] = $career;
        return true;
    }
}
