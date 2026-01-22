<?php
namespace DAO;

use Models\JobOffer;
use DAO\Connection;

class JobOfferDAOMySQL implements IJobOfferDAO
{
    private Connection $connection;

    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    public function add(JobOffer $jobOffer): void
    {
        $query = "
            INSERT INTO job_offers 
            (title, description, salary, start_date, deadline, status, company_id, career_id, job_position_id)
            VALUES (:title, :description, :salary, :start_date, :deadline, :status, :company_id, :career_id, :job_position_id)
        ";

        $this->connection->executeNonQuery($query, [
            "title" => $jobOffer->getTitle(),
            "description" => $jobOffer->getDescription(),
            "salary" => $jobOffer->getSalary(),
            "start_date" => $jobOffer->getStartDate(),
            "deadline" => $jobOffer->getDeadline(),
            "status" => $jobOffer->getStatus(),
            "company_id" => $jobOffer->getCompanyId(),
            "career_id" => $jobOffer->getCareerId(),
            "job_position_id" => $jobOffer->getJobPositionId()
        ]);
    }

    public function update(JobOffer $jobOffer): void
    {
        $query = "
            UPDATE job_offers SET
                title = :title,
                description = :description,
                salary = :salary,
                deadline = :deadline,
                status = :status
            WHERE job_offer_id = :id
        ";

        $this->connection->executeNonQuery($query, [
            "title" => $jobOffer->getTitle(),
            "description" => $jobOffer->getDescription(),
            "salary" => $jobOffer->getSalary(),
            "deadline" => $jobOffer->getDeadline(),
            "status" => $jobOffer->getStatus(),
            "id" => $jobOffer->getJobOfferId()
        ]);
    }

    public function delete(int $jobOfferId): void
    {
        $query = "DELETE FROM job_offers WHERE job_offer_id = :id";
        $this->connection->executeNonQuery($query, ["id" => $jobOfferId]);
    }

    public function getById(int $jobOfferId)
    {
        $query = "SELECT * FROM job_offers WHERE job_offer_id = :id";
        $result = $this->connection->execute($query, ["id" => $jobOfferId]);

        return $result ? $this->mapRow($result[0]) : null;
    }

    public function getAll()
    {
        $query = "SELECT * FROM job_offers";
        return $this->mapList($this->connection->execute($query));
    }

    public function getByCompany(int $companyId)
    {
        $query = "SELECT * FROM job_offers WHERE company_id = :id";
        return $this->mapList($this->connection->execute($query, ["id" => $companyId]));
    }

    public function getByCareer(int $careerId)
    {
        $query = "SELECT * FROM job_offers WHERE career_id = :id";
        return $this->mapList($this->connection->execute($query, ["id" => $careerId]));
    }

    public function getPublished()
    {
        $query = "SELECT * FROM job_offers WHERE status = 'published'";
        return $this->mapList($this->connection->execute($query));
    }

    public function getActivePublished()
    {
        $query = "
            SELECT * FROM job_offers 
            WHERE status = 'published' AND deadline >= CURDATE()
        ";
        return $this->mapList($this->connection->execute($query));
    }

    private function mapList(array $rows)
    {
        return array_map(fn($row) => $this->mapRow($row), $rows);
    }

    private function mapRow(array $row)
    {
        $job = new JobOffer();
        $job->setJobOfferId($row["job_offer_id"])
            ->setTitle($row["title"])
            ->setDescription($row["description"])
            ->setSalary($row["salary"])
            ->setStartDate($row["start_date"])
            ->setDeadline($row["deadline"])
            ->setStatus($row["status"])
            ->setCompanyId($row["company_id"])
            ->setCareerId($row["career_id"])
            ->setJobPositionId($row["job_position_id"]);

        return $job;
    }
}
