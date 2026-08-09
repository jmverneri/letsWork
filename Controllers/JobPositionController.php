<?php
    namespace Controllers;

    use Models\JobPosition as JobPosition;
    use Repositories\JobPositionRepository;
    use Repositories\CareerRepository;
    use Utils\Utils as Utils;

    class JobPositionController{
        private $jobPositionRepo;
        private $careerRepo;
        private $jobsList;

        public function __construct()
        {
            $this->jobPositionRepo = new JobPositionRepository();
            $this->careerRepo = new CareerRepository();
        }

        // Página principal de gestión: listado + formulario de alta + papelera
        public function showJobPositionAddView($message = "")
        {
            Utils::checkAdminSession();

            $jobsList = $this->jobPositionRepo->getAll();
            $inactiveJobsList = $this->jobPositionRepo->getInactive();
            $careerList = $this->careerRepo->getAll();

            require_once(ADMIN_VIEWS . "job-position-add.php");
        }

        public function showJobPositionView(){
            Utils::checkAdminSession();
            $this->jobsList = $this->jobPositionRepo->getAll();

            require_once(ADMIN_VIEWS."jobPosition-list.php");
        }

        // Formulario de edición de un puesto puntual
        public function showJobPositionViewById($id){
            Utils::checkAdminSession();
            $jobPosition = $this->jobPositionRepo->getById($id);
            $careerList = $this->careerRepo->getAll();

            require_once(ADMIN_VIEWS . "jobPosition-view.php");
        }

        public function getJobPositionByCareerId($careerId){
            $this->jobsList = $this->jobPositionRepo->searchJobPositionByCareerId($careerId);
            return $this->jobsList;
        }

        public function addJobPosition($formData){
            Utils::checkAdminSession();

            try {
                $jobPosition = new JobPosition();
                $jobPosition->setCareerId((int)($formData['careerId'] ?? 0));
                $jobPosition->setDescription($formData['description'] ?? '');

                $this->jobPositionRepo->add($jobPosition);

                $this->showJobPositionAddView("El puesto laboral fue cargado satisfactoriamente.");
            } catch (\Exception $ex) {
                $this->showJobPositionAddView("Error al cargar el puesto laboral.");
            }
        }

        public function updateJobPosition($formData)
        {
            Utils::checkAdminSession();

            try {
                $jobPosition = new JobPosition();
                $jobPosition->setJobPositionId((int)($formData['jobPositionId'] ?? 0));
                $jobPosition->setCareerId((int)($formData['careerId'] ?? 0));
                $jobPosition->setDescription($formData['description'] ?? '');

                $this->jobPositionRepo->update($jobPosition);

                $this->showJobPositionAddView("El puesto laboral fue actualizado satisfactoriamente.");
            } catch (\Exception $ex) {
                $this->showJobPositionAddView("Error al actualizar el puesto laboral.");
            }
        }

        public function deleteJobPosition($jobPositionId)
        {
            Utils::checkAdminSession();

            try {
                $this->jobPositionRepo->delete((int)$jobPositionId);
                $this->showJobPositionAddView("Este puesto laboral fue borrado satisfactoriamente.");
            } catch (\Exception $ex) {
                $this->showJobPositionAddView("Error: no se pudo borrar el puesto laboral (puede estar en uso por una oferta laboral).");
            }
        }

        public function restoreJobPosition($jobPositionId)
        {
            Utils::checkAdminSession();

            try {
                $this->jobPositionRepo->restore((int)$jobPositionId);
                $this->showJobPositionAddView("El puesto laboral fue restaurado satisfactoriamente.");
            } catch (\Exception $ex) {
                $this->showJobPositionAddView("Error al restaurar el puesto laboral.");
            }
        }
    }
?>