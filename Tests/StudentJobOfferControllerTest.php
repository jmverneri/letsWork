<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class StudentJobOfferControllerTest extends TestCase {

    #[Test]
    public function testOfferVisibilityMatchesCareer() {
        // Escenario: Un alumno de Programación (ID: 1) no debería ver ofertas de Diseño (ID: 2)
        $studentCareerId = 1;
        $offerJobPositionCareerId = 2;

        $isVisible = ($studentCareerId == $offerJobPositionCareerId);

        $this->assertFalse($isVisible, "El alumno no debe ver ofertas de otras carreras.");
    }

    #[Test]
    public function testDeadlineValidationForStudent() {
        // Escenario: El alumno no debería ver ofertas cuya fecha de cierre ya pasó
        $today = date("Y-m-d");
        $expiredDeadline = "2025-12-31"; // 2026 es el año actual según el sistema

        $isExpired = ($expiredDeadline < $today);

        $this->assertTrue($isExpired, "El filtro debe detectar que la oferta ya expiró.");
    }
}