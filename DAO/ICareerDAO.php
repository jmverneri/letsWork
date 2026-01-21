<?php

    namespace DAO;

    use Models\Career;

    interface ICareerDAO
    {
        public function getAll(): array;
        public function getById(int $careerId): ? Career;
        public function add(Career $career): bool;
    }

?> 