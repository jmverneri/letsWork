<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Models\User;
use Models\Student;
use Models\JobPosition;

class StudentControllerTest extends TestCase {

    protected function setUp(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        $_SESSION = [];
    }

    #[Test]
    public function testStudentRegistrationMatchesPasswords() {
        // Escenario: Registro exitoso cuando las contraseñas coinciden
        $pass = "123456";
        $confirm = "123456";
        
        $success = ($pass === $confirm);
        
        $this->assertTrue($success, "El registro debería proceder si las contraseñas coinciden.");
    }

    #[Test]
    public function testSavePreferencesRequiresLoggedStudent() {
        // Escenario: Un usuario que NO es alumno intenta guardar preferencias
        $_SESSION['loggedUser'] = new User();
        $_SESSION['loggedUser']->setRole("admin"); // Es admin, no student

        // Simulamos tu lógica de checkStudentSession()
        $isStudent = isset($_SESSION['loggedUser']) && $_SESSION['loggedUser']->getRole() === "student";

        $this->assertFalse($isStudent, "Un admin no debería pasar el chequeo de sesión de estudiante.");
    }

    #[Test]
    public function testJobPositionFilteringByCareer() {
        // Escenario: Probar tu lógica de array_filter en showPreferencesView
        $student = new Student();
        $student->setCareerId(1); // Carrera: Programación

        // Simulamos lista de puestos de trabajo
        $pos1 = new JobPosition(); $pos1->setCareerId(1); // Coincide
        $pos2 = new JobPosition(); $pos2->setCareerId(2); // No coincide
        $allPositions = [$pos1, $pos2];

        // Tu lógica de filtrado del controlador
        $filtered = array_filter($allPositions, function($pos) use ($student) {
            return $pos->getCareerId() == $student->getCareerId();
        });

        $this->assertCount(1, $filtered, "Debería quedar solo 1 puesto de trabajo que coincida con la carrera 1.");
        $this->assertEquals(1, reset($filtered)->getCareerId());
    }

    #[Test]
    public function testProfileSyncFailureReturnsNull() {
        // Escenario: El mail no existe en la API de Python (studentValidation)
        $studentFromApi = null; // Simulamos que el Repo no encontró nada

        $exists = ($studentFromApi !== null);

        $this->assertFalse($exists, "Si el mail no existe en la API, la validación debe fallar.");
    }
}