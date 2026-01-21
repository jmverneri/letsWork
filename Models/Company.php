<?php
        namespace Models;

        class Company extends User
        {
        private $companyId;
        private $userId; // FK al User que representa a la empresa

        private $name;
        private $yearFoundation;
        private $city;
        private $description;
        private $logo;
        private $phoneNumber;
        private $cuit;
        private $active;

        public function __construct()
        {
            parent::__construct();
            $this->setRole(self::ROLE_COMPANY);
        }

        public function getCompanyId()
        {
                return $this->companyId;
        }

        public function setCompanyId($companyId)
        {
                $this->companyId = $companyId;
                return $this;
        }

        public function getUserId()
        {
                return $this->userId;
        }

        public function setUserId($userId)
        {
                $this->userId = $userId;
                return $this;
        }

        public function getName()
        {
                return $this->name;
        }

        public function setName($name)
        {
                $this->name = $name;
                return $this;
        }

        public function getYearFoundation()
        {
                return $this->yearFoundation;
        }

        public function setYearFoundation($yearFoundation)
        {
                $this->yearFoundation = $yearFoundation;
                return $this;
        }

        public function getCity()
        {
                return $this->city;
        }

        public function setCity($city)
        {
                $this->city = $city;
                return $this;
        }

        public function getDescription()
        {
                return $this->description;
        }

        public function setDescription($description)
        {
                $this->description = $description;
                return $this;
        }

        public function getLogo()
        {
                return $this->logo;
        }

        public function setLogo($logo)
        {
                $this->logo = $logo;
                return $this;
        }

        public function getPhoneNumber()
        {
                return $this->phoneNumber;
        }

        public function setPhoneNumber($phoneNumber)
        {
                $this->phoneNumber = $phoneNumber;
                return $this;
        }

        public function getCuit()
        {
                return $this->cuit;
        }

        public function setCuit($cuit)
        {
                $this->cuit = $cuit;
                return $this;
        }

        public function isActive()
        {
                return $this->active;
        }

        public function setActive($active)
        {
                $this->active = $active;
                return $this;
        }
        }
?>