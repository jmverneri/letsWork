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
         * Método estándar para agregar una empresa manualmente desde el sistema
         */
        public function add(Company $company): void
        {
            try {
                $query = "INSERT INTO {$this->tableName} (name, email, active)
                        VALUES (:name, :email, :active)";

                $parameters = [
                    "name"   => $company->getName(),
                    "email"  => $company->getEmail(),
                    "active" => $company->getActive()
                ];

                $this->connection->executeNonQuery($query, $parameters);
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        /**
         * Método especial para el REPOSITORY: 
         * Si el externalId existe, actualiza. Si no, inserta.
         */
        public function addOrUpdateFromApi(Company $company): void
        {
            try {
                $query = "INSERT INTO {$this->tableName} (externalId, name, email, active)
                        VALUES (:externalId, :name, :email, :active)
                        ON DUPLICATE KEY UPDATE 
                        name = :name, email = :email, active = :active";

                $parameters = [
                    "externalId" => $company->getExternalId(),
                    "name"       => $company->getName(),
                    "email"      => $company->getEmail(),
                    "active"     => $company->getActive() ? 1 : 0
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
                    $company = new Company();
                    $company->setCompanyId($row["companyId"]);
                    $company->setExternalId($row["externalId"] ?? null);
                    $company->setName($row["name"]);
                    $company->setEmail($row["email"]);
                    $company->setActive($row["active"]);

                    $companyList[] = $company;
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

                if (!empty($result)) {
                    $row = $result[0];
                    $company = new Company();
                    $company->setCompanyId($row["companyId"]);
                    $company->setExternalId($row["externalId"] ?? null);
                    $company->setName($row["name"]);
                    $company->setEmail($row["email"]);
                    $company->setActive($row["active"]);

                    return $company;
                }
                return null;
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public function update(Company $company): void
        {
            try {
                $query = "UPDATE {$this->tableName}
                        SET name = :name, email = :email, active = :active
                        WHERE companyId = :companyId";

                $parameters = [
                    "companyId" => $company->getCompanyId(),
                    "name"      => $company->getName(),
                    "email"     => $company->getEmail(),
                    "active"    => $company->getActive()
                ];

                $this->connection->executeNonQuery($query, $parameters);
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
    }