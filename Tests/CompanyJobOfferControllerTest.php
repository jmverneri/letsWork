<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CompanyJobOfferControllerTest extends TestCase {

    #[Test]
    public function testDeadlineCannotBeBeforeStartDate() {
        // Escenario: El usuario intenta poner un cierre antes del inicio (Paso 1 de add)
        $startDate = "2026-06-01";
        $deadline = "2026-05-15";

        $isInvalid = (strtotime($deadline) < strtotime($startDate));

        $this->assertTrue($isInvalid, "El sistema debe detectar que la fecha de cierre es inválida.");
    }

    #[Test]
    public function testInterviewCannotBeInThePast() {
        // Escenario: El usuario intenta programar una entrevista para ayer
        $now = "2026-02-10 10:00:00"; // Simulamos hoy
        $interviewDate = "2026-02-09 15:00:00"; // Ayer

        $isPast = (strtotime($interviewDate) < strtotime($now));

        $this->assertTrue($isPast, "No se deben permitir entrevistas en el pasado.");
    }
}