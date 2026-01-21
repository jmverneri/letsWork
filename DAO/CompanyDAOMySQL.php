<?php
    namespace DAO;

    use Models\Company;
    use PDO;
    use PDOException;

    class CompanyDAOMySQL implements ICompanyDAO
    {
        private PDO $connection;
        private string $tableName = "companies";

        public function __construct()
        {
            $this->connection = Connection::getInstance();
        }

        public function add(Company $company): void
        {
            $query = "INSERT INTO {$this->tableName} (name, email, active)
                    VALUES (:name, :email, :active)";

            $parameters = [
                "name"   => $company->getName(),
                "email"  => $company->getEmail(),
                "active" => $company->getActive()
            ];

            $this->connection->executeNonQuery($query, $parameters);
        }

        public function getAll(): array
        {
            $companyList = [];

            $query = "SELECT * FROM {$this->tableName}";

            $result = $this->connection->execute($query);

            foreach ($result as $row) {
                $company = new Company();
                $company->setCompanyId($row["companyId"]);
                $company->setName($row["name"]);
                $company->setEmail($row["email"]);
                $company->setActive($row["active"]);

                $companyList[] = $company;
            }

            return $companyList;
        }

        public function getById(int $id): ?Company
        {
            $query = "SELECT * FROM {$this->tableName} WHERE companyId = :id";

            $parameters = ["id" => $id];

            $result = $this->connection->execute($query, $parameters);

            if (!empty($result)) {
                $row = $result[0];

                $company = new Company();
                $company->setCompanyId($row["companyId"]);
                $company->setName($row["name"]);
                $company->setEmail($row["email"]);
                $company->setActive($row["active"]);

                return $company;
            }

            return null;
        }

        public function update(Company $company): void
        {
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
        }

        public function delete(int $id): void
        {
            $query = "DELETE FROM {$this->tableName} WHERE companyId = :id";

            $parameters = ["id" => $id];

            $this->connection->executeNonQuery($query, $parameters);
        }
    }
