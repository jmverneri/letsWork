<!--?php
        namespace Models;

        class Admin
        {
        private $administratorId;
        private $userId;

        private $firstName;
        private $lastName;
        private $dni;
        private $phoneNumber;

        public function getAdministratorId()
        {
                return $this->administratorId;
        }

        public function setAdministratorId($administratorId)
        {
                $this->administratorId = $administratorId;
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

        public function getFirstName()
        {
                return $this->firstName;
        }

        public function setFirstName($firstName)
        {
                $this->firstName = $firstName;
                return $this;
        }

        public function getLastName()
        {
                return $this->lastName;
        }

        public function setLastName($lastName)
        {
                $this->lastName = $lastName;
                return $this;
        }

        public function getDni()
        {
                return $this->dni;
        }

        public function setDni($dni)
        {
                $this->dni = $dni;
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
        }

?>

//USO DIRECTAMENTE USER