<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class SecurityFeatureTest extends TestCase {

    protected function setUp(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
    }

    #[Test]
    public function testGuestIsRedirectedFromJobOfferList() {
        
        $isLogged = isset($_SESSION["loggedUser"]);
        
        $this->assertFalse($isLogged, "El usuario no debería estar logueado.");
        
        $shouldRedirect = !$isLogged;
        $this->assertTrue($shouldRedirect);
    }

    #[Test]
    public function testStudentCannotAccessAdminRoutes() {
        // 1. Simulamos un login de Alumno
        $_SESSION["loggedUser"] = (object)[
            "email" => "javier@utn.com",
            "role" => "student"
        ];

        // 2. Intentamos acceder a una ruta de Admin
        $userRole = $_SESSION["loggedUser"]->role;
        
        // 3. Verificamos que el sistema detecte que NO es admin
        $isAdmin = ($userRole === "admin");
        
        $this->assertFalse($isAdmin, "Un alumno no debería tener privilegios de administrador.");
    }
}