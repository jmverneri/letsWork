<?php
    namespace Controllers;

    use DAO\NotificationDAO as NotificationDAO;
    use Repositories\StudentRepository as StudentRepository;
    use Utils\Utils;

    class NotificationController {
        private $notificationDAO;
        private $studentRepo;

        public function __construct() {
            $this->notificationDAO = new NotificationDAO();
            $this->studentRepo = new StudentRepository();
        }

        public function showListView() {

            Utils::checkStudentSession();
            $user = $_SESSION['loggedUser'];
            
            $student = $this->studentRepo->getByUserId($user->getUserId());
            $studentId = $student->getStudentId();

            // 1. Buscamos todas las notificaciones para el historial
            $notificationList = $this->notificationDAO->getAllByStudent($studentId);

            // 2. IMPORTANTE: También necesitamos las NO leídas para que la campana no desaparezca en esta vista
            $notifications = $this->notificationDAO->getUnreadByStudent($studentId);
            $cantNotif = count($notifications);

            require_once(STUDENT_VIEWS . "notification-list.php");
        }
    }
?>