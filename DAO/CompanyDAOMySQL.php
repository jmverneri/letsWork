<?php
    namespace DAO;

    use Models\Company;
    use \Exception as Exception;

    class CompanyDAOMySQL implements ICompanyDAO
    {
        private Connection $connection;
        private string $tableName = "companies";

        public function __construct()
        {
            $this->connection = Connection::GetInstance();
        }

        /**
         * Agrega una empresa vinculándola a un userId previamente creado
         */
        public function add(Company $company): void
        {
            try {
                $query = "INSERT INTO {$this->tableName} (userId, name, cuit, city, description, phoneNumber, active)
                        VALUES (:userId, :name, :cuit, :city, :description, :phoneNumber, :active)";

                $parameters = [
                    "userId"      => $company->getUserId(),
                    "name"        => $company->getName(),
                    "cuit"        => $company->getCuit(),
                    "city"        => $company->getCity(),
                    "description" => $company->getDescription(),
                    "phoneNumber" => $company->getPhoneNumber(),
                    "active"      => $company->isActive() ? 1 : 0
                ];

                $this->connection->executeNonQuery($query, $parameters);
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public function getAll(): array
        {
            try {
                $companyList = [];
                $query = "SELECT * FROM {$this->tableName}";
                $result = $this->connection->execute($query);

                foreach ($result as $row) {
                    $companyList[] = $this->map($row);
                }

                return $companyList;
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public function getById(int $id): ?Company
        {
            try {
                $query = "SELECT * FROM {$this->tableName} WHERE companyId = :id";
                $parameters = ["id" => $id];
                $result = $this->connection->execute($query, $parameters);

                return (!empty($result)) ? $this->map($result[0]) : null;
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public function getByCuit(string $cuit): ?Company
        {
            try {
                $query = "SELECT * FROM {$this->tableName} WHERE cuit = :cuit";
                $parameters = ["cuit" => $cuit];
                $result = $this->connection->execute($query, $parameters);

                return (!empty($result)) ? $this->map($result[0]) : null;
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public function getByUserId(int $userId): ?Company
        {
            try {
                $query = "SELECT * FROM {$this->tableName} WHERE userId = :userId";
                $parameters = ["userId" => $userId];
                $result = $this->connection->execute($query, $parameters);

                return (!empty($result)) ? $this->map($result[0]) : null;
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        // Agregamos ": void" al final para que coincida con la interfaz
        public function update(Company $company): void
        {
            try {
                $query = "UPDATE " . $this->tableName . " SET 
                    name = :name, 
                    cuit = :cuit, 
                    city = :city, 
                    description = :description, 
                    phoneNumber = :phoneNumber, 
                    active = :active 
                    WHERE companyId = :companyId;";

                $parameters["name"] = $company->getName();
                $parameters["cuit"] = $company->getCuit();
                $parameters["city"] = $company->getCity();
                $parameters["description"] = $company->getDescription();
                $parameters["phoneNumber"] = $company->getPhoneNumber();
                $parameters["active"] = $company->isActive() ? 1 : 0;
                $parameters["companyId"] = $company->getCompanyId();

                $this->connection = Connection::GetInstance();
                
                // Ejecutamos, pero no retornamos el valor para cumplir con el ": void"
                $this->connection->ExecuteNonQuery($query, $parameters);

            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public function delete(int $id): void
        {
            try {
                $query = "DELETE FROM {$this->tableName} WHERE companyId = :id";
                $parameters = ["id" => $id];
                $this->connection->executeNonQuery($query, $parameters);
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /**
         * Método privado para convertir filas de la DB en objetos Company
         */
        private function map($row): Company
        {
            $company = new Company();
            $company->setCompanyId($row["companyId"]);
            $company->setUserId($row["userId"] ?? 0);
            $company->setName($row["name"]);
            $company->setCuit($row["cuit"] ?? null);
            $company->setCity($row["city"] ?? null);
            $company->setDescription($row["description"] ?? null);
            $company->setPhoneNumber($row["phoneNumber"] ?? null);
            $company->setActive((bool)$row["active"]);

            // 🔑 Mapeamos el email que viene del INNER JOIN con la tabla Users
            if(isset($row["email"])) {
                $company->setEmail($row["email"]);
            }

            return $company;
        }
    }