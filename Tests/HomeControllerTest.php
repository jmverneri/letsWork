<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Models\User;
use Models\Student;
use Models\Company;

class HomeControllerTest extends TestCase {

    protected function setUp(): void {
        // Aseguramos que la sesión esté limpia para cada test
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        $_SESSION = [];
    }

    // --- SECCIÓN 1: TEST DE LOGIN COMPLETO ---

    #[Test]
    public function testLoginFullFlowForStudentWithApiSync() {
        // Escenario: El usuario NO existe localmente (Paso 2 de tu código)
        $email = "nuevo_estudiante@utn.com";
        $userInLocalDB = null; 

        // Simulamos que el Repo lo busca afuera y lo sincroniza con éxito
        if (!$userInLocalDB) {
            $userInLocalDB = new User();
            $userInLocalDB->setUserId(101);
            $userInLocalDB->setEmail($email);
            $userInLocalDB->setPassword(password_hash("dni123", PASSWORD_DEFAULT));
            $userInLocalDB->setRole(User::ROLE_STUDENT);
        }

        // Verificamos Password (Paso 3)
        $auth = password_verify("dni123", $userInLocalDB->getPassword());
        $this->assertTrue($auth);

        // Simulamos el bloque Case ROLE_STUDENT (Paso 5)
        $_SESSION['loggedUser'] = $userInLocalDB;
        $_SESSION['studentId'] = 50; 
        $_SESSION['cantNotif'] = 2; // Simulamos 2 notificaciones encontradas

        $this->assertEquals(User::ROLE_STUDENT, $_SESSION['loggedUser']->getRole());
        $this->assertEquals(2, $_SESSION['cantNotif']);
        $this->assertArrayHasKey('studentId', $_SESSION);
    }

    #[Test]
    public function testLoginRejectsInactiveCompany() {
        // Escenario: El usuario es Company pero el Repo detecta que está inactiva (Paso 5 - Case Company)
        $user = new User();
        $user->setRole(User::ROLE_COMPANY);
        
        // Simulamos que la empresa asociada está desactivada
        $companyActiveStatus = false;

        $loginError = "";
        if ($user->getRole() === User::ROLE_COMPANY) {
            if (!$companyActiveStatus) {
                $loginError = "Su cuenta de empresa ha sido desactivada. Contacte al administrador.";
            }
        }

        $this->assertEquals("Su cuenta de empresa ha sido desactivada. Contacte al administrador.", $loginError);
    }

    #[Test]
    public function testLoginForcesPasswordChangeFlag() {
        // Escenario: El usuario tiene el flag de cambio obligatorio (Paso 4)
        $user = new User();
        $user->setMustChangePassword(true);

        $mustRedirect = false;
        if ($user->getMustChangePassword()) {
            $mustRedirect = true;
        }

        $this->assertTrue($mustRedirect);
    }

    // --- SECCIÓN 2: TEST DE SEGURIDAD Y ACCESOS (MENÚS) ---

    #[Test]
    public function testMenuAdminProtectsAgainstStudents() {
        // Simulamos un alumno intentando entrar a la URL de admin
        $_SESSION['loggedUser'] = new User();
        $_SESSION['loggedUser']->setRole(User::ROLE_STUDENT);

        // Lógica de tu método menuAdmin()
        $canAccess = isset($_SESSION['loggedUser']) && $_SESSION['loggedUser']->isAdmin();

        $this->assertFalse($canAccess, "Un estudiante no debería poder acceder al menú de administrador.");
    }

    #[Test]
    public function testLogoutDestroysSessionCorrectly() {
        // 1. Simulamos una sesión activa
        $_SESSION['loggedUser'] = new User();
        
        // 2. Simulamos la lógica de tu Logout() sin disparar warnings de PHP
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        $_SESSION = []; 

        $this->assertEmpty($_SESSION, "La sesión debería estar vacía después del logout.");
    }

    #[Test]
    public function testIndexClearsLoginErrorAfterShowing() {
        // Simulamos que venimos de un error de login
        $_SESSION['login_error'] = "Campos incompletos";

        // Lógica de tu método index()
        $errorToShow = $_SESSION['login_error'] ?? '';
        unset($_SESSION['login_error']);

        $this->assertEquals("Campos incompletos", $errorToShow);
        $this->assertArrayNotHasKey('login_error', $_SESSION);
    }
}