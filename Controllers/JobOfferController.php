<?php

namespace Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Models\JobOffer as JobOffer;
use DAO\JobOfferDAO as JobOfferDAO;
use Models\JobPosition as JobPosition;
use DAO\JobPositionDAO as JobPositionDAO;
use Models\Career as Career;
use DAO\CareerDAO as CareerDAO;
use DAO\StudentByJobOfferDAO as StudentByJobOfferDao;
use Models\StudentByJobOffer as StudentByJobOffer;
use Models\Student as Student;
use DAO\StudentDAO as StudentDAO;

use DAO\IJobOfferDAO as IJobOfferDAO;
use DAO\IJobPossitionDAO as IJobPositionDAO;
use DAO\CompanyDAO as CompanyDAO;
use Models\Company as Company;
use Utils\Utils as Utils;
use DAO\JobOfferByCompanyDAO as JobOfferByCompanyDAO;
use FPDF;
use Models\JobOfferByCompany as JobOfferByCompany;
use \PDOException as PDOException;

use fpdf\fpdf as Pdf;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

class JobOfferController
{
    private $jobPositionDAO;
    private $jobPositionList;
    private $jobOfferDAO;
    private $jobOfferList;
    private $careerDAO;
    private $careerList;
    private $career;
    private $jobOfferByCompanyDAO;
    private $jobOfferByCompany;
    private $companiesList;
    private $companyDao;
    private $company;
    private $jobOffer;
    private $expiredJobOffers;
    private $studentByJobOfferdao;
    private $studentByJobOffer;
    private $student;
    private $stundentDao;
    private $studentXJobOfferDao;
    private $pdf;


    public function __construct()
    {
        $this->jobPositionDAO = new JobPositionDAO();
        $this->jobPositionList = array();
        $this->jobOfferDAO = new JobOfferDAO();
        $this->careerDAO = new CareerDAO();
        $this->careerList = array();
        $this->career = new Career();
        $this->companiesList = array();
        $this->companyDao = new CompanyDAO;
        $this->company = new Company();
        $this->jobOffer = new JobOffer();
        $this->jobOfferList = array();
        $this->expiredJobOffers = array();
        $this->studentByJobOfferdao = new StudentByJobOfferDao();
        $this->studentByJobOffer = new StudentByJobOffer();
        $this->student = new Student();
        $this->stundentDao = new StudentDAO();
        $this->studentXJobOfferDao = new StudentByJobOfferDAO();
        $this->pdf = new FPDF();
    }

    public function RedirectAddJobForm()
    {
        Utils::checkAdminSession();
        $this->companiesList = $this->companyDao->GetAll();
        $this->careerList = $this->careerDAO->GetAllActive();
        $this->jobPositionList = $this->jobPositionDAO->getAllJobpositions();
        require_once(ADMIN_VIEWS . "jobOffer-add.php");
    }


    public function ShowJobOfferAddView($message = "")
    {
        require_once(ADMIN_VIEWS . "jobOffer-add.php");
    }

    public function ShowListCompanyList($message = "")
    {
        $this->companiesList = $this->companyDao->GetAll();
        require_once(ADMIN_VIEWS . "company-delete.php");
    }

    public function showAddjobOfferForCompany($companyId)
    {

        $this->company = $this->companyDao->Search($companyId);
        $this->careerList = $this->careerDAO->GetAllActive();
        $this->jobPositionList = $this->jobPositionDAO->getAllJobpositions();

        require_once(ADMIN_VIEWS . "jobOffer-add.php");
    }

    public function showJobOfferView()
    {
        Utils::checkSession();
        $this->jobOfferList = $this->jobOfferDAO->GetAllJobOffer();

        require_once(ADMIN_VIEWS . "company-job-offers.php");   
    }

    public function getJobOfferById($id)
    {
        Utils::checkSession();
        $jobOffer = $this->jobOfferDAO->searchJobOfferById($id);

        require_once(VIEWS_PATH . "jobOffer-view.php");
    }
    public function getJobOfferByName($search)
    {
        Utils::checkSession();
        $this->jobOfferList = $this->jobOfferDAO->searchJobOfferByName($search);

        if ($search != null) {
            $search = strtolower($search);
            $filteredJobOffer = array();

            foreach ($this->jobOfferList as $jobOffer) {
                $jobOfferName = strtolower($jobOffer->getName());

                if (Utils::strStartsWith($jobOfferName, $search)) {
                    array_push($filteredJobOffer, $jobOffer);
                }
            }
            require_once(VIEWS_PATH . "job-offers-by-company.php");
        } else {
            echo "Aca";
        }
    }


    public function showModifyJobOfferView($jobOfferId)
    {
        $this->jobOffer = $this->jobOfferDAO->searchJobOfferById($jobOfferId);
        $this->careerList = $this->careerDAO->GetAllActive();
        $this->jobPositionList = $this->jobPositionDAO->getAllJobpositions();
        require_once(ADMIN_VIEWS . "modify-jobOffer-view.php");
    }

    public function addJobOffer($companyId, $name, $startDay, $deadline, $description, $salary, $careerId, $jobPositionId)
    {
        //Utils::checkAdminSession();

        $jobOffer = new JobOffer();
        $jobOffer->setCompanyId($companyId);
        $jobOffer->setName($name);
        $jobOffer->setStartDay($startDay);
        $jobOffer->setDeadLine($deadline);
        $jobOffer->setActive(true);
        $jobOffer->setDescription($description);
        $jobOffer->setSalary($salary);
        $jobOffer->setCareerId($careerId);
        $jobOffer->setJobPositionId($jobPositionId);

        $this->jobOfferDAO->addJobOffer($jobOffer);

        $this->ShowListCompanyList("The job offer had been loaded successfully");
    }

    public function updateJobOffer($jobOfferId, $name, $startDay, $deadline, $description, $salary, $careerId, $jobPositionId)
    {
        Utils::checkSession();

        $jobOffer = new JobOffer();
        $jobOffer->setJobOfferId($jobOfferId);
        $jobOffer->setName($name);
        $jobOffer->setStartDay($startDay);
        $jobOffer->setDeadLine($deadline);
        $jobOffer->setDescription($description);
        $jobOffer->setSalary($salary);
        $jobOffer->setCareerId($careerId);
        $jobOffer->setJobPositionId($jobPositionId);

        $this->jobOfferDAO->updateJobOffer($jobOffer);

        $this->showJobOfferView("The job offer had been updated successfully");
    }

    public function deleteJobOffer($jobOfferId)
    {

        $this->jobOfferDAO->deleteJobOffer($jobOfferId);

        $this->showJobOfferView("The job offer had been deleted successfully");
    }

    ///Filtro de job offers
    public function jobOffersForJobPosition($positionId)
    {
        Utils::checkSession();
        //    $this->jobOfferList = $this->jobOfferDAO->GetAllJobPosition();
        $results = array();

        foreach ($this->jobOfferList as $offer) {
            if ($offer['jobPositionId'] == $positionId) {
                array_push($results, $offer);
            }
        }
        return $results;
    }

    public function addStudentToAJobOffer($jobOfferId, $studentId)
    {
        $controlScritpt = null;
        try {
            $this->studentXJobOfferDao->addStudentToAJobOffer($jobOfferId, $studentId);
            $this->companiesList = $this->companyDao->GetAll();
        } catch (PDOException $ex) {
            $controlScritpt = true;
            $message = 'error en la base';
            require_once(STUDENT_VIEWS . "student-profile.php");
        }
        $message = "student added to a job offer";
        require_once(STUDENT_VIEWS . "menu-student.php");
    }

    public function showJobsOffersViewByCareer($careerId)
    {
        $this->jobOfferList = $this->jobOfferDAO->getJobOfferByCareer($careerId);
        $this->career = $this->careerDAO->GetCareerById($careerId);
       require_once(VIEWS_PATH . "job-offers-by-career.php");
    }


    public function showJobsOffersViewByCompany($companyId)
    {

        $this->jobOfferList = $this->jobOfferDAO->getJobOfferByCompany($companyId);
        $this->company = $this->companyDao->Search($companyId);
        require_once(VIEWS_PATH . "job-offers-by-company.php");
    }

    public function ShowJobsViews($search = "")
    {
        if ($search == "") {
            $this->jobOfferList = $this->jobOfferDAO->getAllJobOffer();
            $this->careerList = $this->careerDAO->GetAll();
            $this->companiesList = $this->companyDao->GetAll();
            if ($_SESSION['admin']) {               //PENSAR COMO SOLUCIONAR. CONTROLADORAS SEPARADAS?
                require_once(ADMIN_VIEWS . "company-job-offers-admin.php");
            } else {
                require_once(STUDENT_VIEWS . "company-job-offers-students.php");
            }
        } else {
            $search = strtolower($search);
            $filteredOffers = array();
            $this->jobOfferList = $this->jobOfferDAO->getAllJobOffer();
            $this->careerList = $this->careerDAO->GetAll();
            $this->companiesList = $this->companyDao->GetAll();
            
            foreach ($this->jobOfferList as $jobOffer) {
                $jobOfferName = strtolower($jobOffer->getName());

                if (Utils::strStartsWith($jobOfferName, $search)) {
                    array_push($filteredOffers, $jobOffer);
                }
            }
            $this->jobOffersList = $filteredOffers;
            require_once(ADMIN_VIEWS . "company-job-offers-admin.php");
        }
    }

    public function finishedJobOffers()
    {
        Utils::checkAdminSession();
        $this->jobOfferList = $this->jobOfferDAO->getAllJobOffer();
        $this->careerList = $this->careerDAO->getAll();
        $this->companiesList = $this->companyDao->getAll();
        // $this->expiredJobOffers = array();
        if (!empty($this->jobOfferList)) {
            foreach ($this->jobOfferList as $jobOfferEach) {
                if (strtotime($jobOfferEach->getDeadLine()) < strtotime(date("Y-m-d H:i:00", time()))) {
                    array_push($this->expiredJobOffers, $jobOfferEach);
                }
            }       ///De donde es la fecha que devuelve???
        }

        require_once(ADMIN_VIEWS . "expired-job-offers.php");
    }

    public function notificationByEmail($jobOfferId)
    {
        Utils::checkAdminSession();

        //buscar por el id de la job  offer, del id sacas el id del estudiante, con el id del stud buscas el mail.
        $this->jobOfferList = $this->studentByJobOfferdao->getByJobOfferId($jobOfferId);

        $to = array();
        $subject = "Gratitude";
        $message = "We appreciate your application to the job. The job offer had expired";

        if ($this->jobOfferList != null) {
            foreach ($this->jobOfferList as $jobOffer) {
                $studentId = $jobOffer['studentId'];
                $student = new Student();
                $student = $this->stundentDao->getStudentById($studentId);


                $studentsEmail = $student->getEmail();
                array_push($to, $studentsEmail);
            }
            foreach ($to as $forEmail) {
                $hola = $this->sendMail($forEmail["email"], $subject, $message);
            }
            echo "The emails has been sent succesfully";
        } else {
            echo "The list is empty";
            //echo "<script> if(confirm('The list is empty'));";  
            //echo "window.location = 'student-profile.php'; </script>";
        }
        require_once(ADMIN_VIEWS . "menu-admin.php");
    }

    public function sendMail($recipientMail, $subject, $message)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            //Server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'utnmdp2021@gmail.com';
            $mail->Password   = '123456..!';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            //Recipients
            $mail->setFrom('utnmdp2021@gmail.com', 'Lets Work');
            $mail->addAddress($recipientMail);
            $mail->addCC("jamartinezverneri@gmail.com");

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->send();
            return 'Message has been sent';
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    public function createPdf($jobOfferId)
    {
        $jobOffers = $this->studentXJobOfferDao->getByJobOfferId($jobOfferId);
        $students = $this->stundentDao->GetAll();
        
        $this->pdf->Image('logo.png', 10, 8, 33);
        // Arial bold 15
        $this->pdf->SetFont('Arial', 'B', 15);
        // Movernos a la derecha
        $this->pdf->Cell(80);
        // Título
        $this->pdf->Cell(30, 10, 'Postulantes', 0, 0, 'C');
        // Salto de línea
        $this->pdf->Ln(20);

        // Posición: a 1,5 cm del final
        $this->pdf->SetY(-15);
        // Arial italic 8
        $this->pdf->SetFont('Arial', 'I', 8);
        // Número de página
        $this->pdf->Cell(0, 10, 'Page ' . $this->pdf->PageNo() . '/{nb}', 0, 0, 'C');

        $this->pdf->AddPage();
        $this->pdf->AliasNbPages();
        $this->pdf->SetFont('Arial', 'B', 16);
        $this->pdf->Cell(40, 10, '¡Hola, Mundo!');  ///hacer un while
        $this->pdf->Output();
    }
}
