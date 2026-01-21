<?php
    namespace DAO;

    use Models\JobOffer;

    class JobOfferDAOMock implements IJobOfferDAO
    {
        private array $jobOfferList = [];

        public function __construct()
        {
            // Datos mock de ejemplo
            $job1 = new JobOffer();
            $job1->setJobOfferId(1)
                ->setTitle("Backend Developer")
                ->setDescription("PHP Backend Developer")
                ->setSalary(300000)
                ->setStartDate("2025-03-01")
                ->setDeadline("2025-04-30")
                ->setStatus("published")
                ->setCompanyId(1)
                ->setCareerId(2)
                ->setJobPositionId(1);

            $this->jobOfferList[] = $job1;
        }

        public function add(JobOffer $jobOffer)
        {
            $jobOffer->setJobOfferId(count($this->jobOfferList) + 1);
            $this->jobOfferList[] = $jobOffer;
        }

        public function update(JobOffer $jobOffer)
        {
            foreach ($this->jobOfferList as $key => $value) {
                if ($value->getJobOfferId() == $jobOffer->getJobOfferId()) {
                    $this->jobOfferList[$key] = $jobOffer;
                    return;
                }
            }
        }

        public function delete(int $jobOfferId)
        {
            $this->jobOfferList = array_filter(
                $this->jobOfferList,
                fn($job) => $job->getJobOfferId() != $jobOfferId
            );
        }

        public function getById(int $jobOfferId)
        {
            foreach ($this->jobOfferList as $job) {
                if ($job->getJobOfferId() == $jobOfferId) {
                    return $job;
                }
            }
            return null;
        }

        public function getAll()
        {
            return $this->jobOfferList;
        }

        public function getByCompany(int $companyId)
        {
            return array_filter(
                $this->jobOfferList,
                fn($job) => $job->getCompanyId() == $companyId
            );
        }

        public function getByCareer(int $careerId)
        {
            return array_filter(
                $this->jobOfferList,
                fn($job) => $job->getCareerId() == $careerId
            );
        }

        public function getPublished()
        {
            return array_filter(
                $this->jobOfferList,
                fn($job) => $job->getStatus() === 'published'
            );
        }

        public function getActivePublished()
        {
            $today = date('Y-m-d');

            return array_filter(
                $this->jobOfferList,
                fn($job) =>
                    $job->getStatus() === 'published' &&
                    $job->getDeadline() >= $today
            );
        }
    }
