<?php
    namespace Controllers;

    use Models\JobPosition as JobPosition;
    use DAO\JobPositionDAO as JobPositionDAO;
    use DAO\IJobPossitionDAO as IJobPositionDAO;
    use Utils\Utils as Utils;

    class JobPositionController{
        private $jobPositionDAO;
        private $jobsList;

        public function __construct()
        {
            $this->jobPositionDAO = new JobPositionDAO();
        }

        public function ShowJobPositionAddView($message = "")
        {
            require_once(VIEWS_PATH . "jobPosition-add.php");
        }

        public function showJobPositionView(){
            Utils::checkSession();
            $this->jobsList = $this->jobPositionDAO->GetAllJobPositions();
            
            require_once(VIEWS_PATH."jobPosition-list.php");    ///Falta crear
        }

        public function ShowJobPositionViewById($id){
            Utils::checkSession();
            $jobPosition = $this->jobPositionDAO->SearchJobPositionById($id);
        
            require_once(VIEWS_PATH . "jobPosition-view.php");      ///Falta crear
        }

        public function getJobPositionByCareerId($careerId){

            $this->jobsList=$this->jobPositionDAO->searchJobPositionByCareerId($careerId);
            return $this->jobsList;
        }

        public function addJobPosition($jobId, $careerId, $descrpition){
            Utils::checkAdminSession();

            $jobPosition = new JobPosition();
            $jobPosition->setJobPositionId($jobId);
            $jobPosition->setCareerId($careerId);
            $jobPosition->setDescription($descrpition);

            $this->jobPositionDAO->addJobPosition($jobPosition);

            $this->ShowjobPositionAddView("The job position had been loaded successfully");
        }

        public function updateJobPosition($jobId, $careerId, $descrpition)
        {
            Utils::checkSession();
            $jobPosition = new JobPosition();

            $jobPosition = new JobPosition();
            $jobPosition->setJobPositionId($jobId);
            $jobPosition->setCareerId($careerId);
            $jobPosition->setDescription($descrpition);

            $this->JobPositionDAO->updateJobPosition($jobPosition);

            $this->ShowJobPositionAddView("The job position had been updated successfully");
        }

        public function deleteJobPosition($jobPositionId)
        {

            $this->jobPositionDAO->deleteJobPosition($jobPositionId);

            $this->ShowjobPositionAddView("The job position had been deleted successfully");
        }
    }
?>