<?php
        namespace Models;

        class Company
        {
        private int $companyId;
        private int $userId;

        private string $name;
        private ?string $city = null;
        private ?string $description = null;
        private ?string $logo = null;
        private ?string $phoneNumber = null;
        private ?string $cuit= null;
        private bool $active;

        public function __construct()
        {
           
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