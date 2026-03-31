<?php
    namespace Controllers;

    use Models\JobPosition as JobPosition;
    use Repositories\JobPositionRepository;
    use DAO\IJobPossitionDAO as IJobPositionDAO;
    use Utils\Utils as Utils;

    class JobPositionController{
        private $jobPositionRepo;
        private $jobsList;

        public function __construct()
        {
            $this->jobPositionRepo = new JobPositionRepository();
        }

        public function showJobPositionAddView($message = "")
        {
            require_once(VIEWS_PATH . "jobPosition-add.php");
        }

        public function showJobPositionView(){
            Utils::checkSession();
            $this->jobsList = $this->jobPositionRepo->getAll();
            
            require_once(VIEWS_PATH."jobPosition-list.php");    ///Falta crear
        }

        public function showJobPositionViewById($id){
            Utils::checkSession();
            $jobPosition = $this->jobPositionRepo->getById($id);
        
            require_once(VIEWS_PATH . "jobPosition-view.php");      ///Falta crear
        }

        public function getJobPositionByCareerId($careerId){

            $this->jobsList=$this->jobPositionRepo->searchJobPositionByCareerId($careerId);
            return $this->jobsList;
        }

        public function addJobPosition($jobId, $careerId, $descrpition){
            Utils::checkAdminSession();

            $jobPosition = new JobPosition();
            $jobPosition->setJobPositionId($jobId);
            $jobPosition->setCareerId($careerId);
            $jobPosition->setDescription($descrpition);

            $this->jobPositionRepo->add($jobPosition);

            $this->showJobPositionAddView("El puesto laboral fue cargado satisfactoriamente");
        }

        public function updateJobPosition($jobId, $careerId, $descrpition)
        {
            Utils::checkSession();
            $jobPosition = new JobPosition();

            $jobPosition = new JobPosition();
            $jobPosition->setJobPositionId($jobId);
            $jobPosition->setCareerId($careerId);
            $jobPosition->setDescription($descrpition);

            $this->jobPositionRepo->update($jobPosition);

            $this->showJobPositionAddView("El puesto laboral fue actualizado satisfactoriamente");
        }

        public function deleteJobPosition($jobPositionId)
        {

            $this->jobPositionRepo->delete($jobPositionId);

            $this->showJobPositionAddView("Este puesto laboral fue borrado satisfactoriamente");
        }
    }
?>