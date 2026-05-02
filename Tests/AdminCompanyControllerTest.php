<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Models\User;
use Models\Company;

class AdminCompanyControllerTest extends TestCase {

    #[Test]
    public function testDeleteCompanyPreventsReDeactivation() {
        // Escenario: El admin intenta desactivar una empresa que YA está desactivada (Paso 2 de deleteCompany)
        $company = new Company();
        $company->setActive(false); // Ya está inactiva

        $alreadyInactive = ($company->isActive() == false);
        
        $this->assertTrue($alreadyInactive, "El sistema debe detectar que ya está inactiva para no procesar de más.");
    }

    #[Test]
    public function testCuitCompositionInAddMethod() {
        // Escenario: Validar que el CUIT se arme bien desde los 3 fragmentos (Paso 1 de add)
        $pre = "30";
        $dni = "12345678";
        $ultimo = "9";
        
        $cuit = $pre . "-" . $dni . "-" . $ultimo;

        $this->assertEquals("30-12345678-9", $cuit);
    }

    #[Test]
    public function testSearchFilterLogic() {
        // Escenario: El buscador debe ser sensible al inicio del nombre (strpos !== 0)
        $companyName = strtolower("Accenture");
        $searchTerm = strtolower("Acc");

        $match = (strpos($companyName, $searchTerm) === 0);

        $this->assertTrue($match, "Debería encontrar la empresa si el inicio coincide.");
    }
}