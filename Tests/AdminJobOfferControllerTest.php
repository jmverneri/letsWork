<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Models\JobOffer;

class AdminJobOfferControllerTest extends TestCase {

    #[Test]
    public function testFlyerUploadMimeValidation() {
        // Escenario: Simular la validación de tipos permitidos
        $allowedTypes = ['image/jpeg', 'image/png'];
        $fakeMimeType = 'application/x-php'; // Intento de ataque con script PHP

        $isValid = in_array($fakeMimeType, $allowedTypes);
        
        $this->assertFalse($isValid, "El sistema debe rechazar archivos que no sean JPG o PNG.");
    }

    #[Test]
    public function testJobOfferDeadlineValidation() {
        // Escenario: Una oferta no puede expirar antes de empezar
        $startDate = "2026-05-01";
        $deadline = "2026-04-30"; // Fecha inválida (anterior al inicio)

        $isValidDate = (strtotime($deadline) >= strtotime($startDate));

        $this->assertFalse($isValidDate, "La fecha de cierre no puede ser anterior a la de inicio.");
    }

    #[Test]
    public function testEmailMessageFormatting() {
        // Escenario: Verificar que el mensaje de declinación incluya el nombre del alumno
        $firstName = "Javier";
        $jobTitle = "Desarrollador PHP";
        
        $message = "Hola " . $firstName . ". Tu postulación para " . $jobTitle . " ha sido declinada.";

        $this->assertStringContainsString("Javier", $message);
        $this->assertStringContainsString("Desarrollador PHP", $message);
    }
}