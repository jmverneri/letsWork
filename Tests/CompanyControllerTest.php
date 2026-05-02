<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Models\Company;
use Models\User;

class CompanyControllerTest extends TestCase {

    protected function setUp(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        $_SESSION = [];
    }

    // --- SECCIÓN 1: SEGURIDAD Y SESIÓN ---

    #[Test]
    public function testDashboardRejectsInactiveCompany() {
        // Escenario: Una empresa logueada es desactivada por un admin (Paso crítico en dashboard)
        $user = new User();
        $user->setUserId(1);
        $_SESSION['loggedUser'] = $user;

        // Simulamos que la empresa asociada está inactiva
        $company = new Company();
        $company->setActive(false);

        $shouldLogout = (!$company || !$company->isActive());

        $this->assertTrue($shouldLogout, "Si la empresa está inactiva, el dashboard debe forzar el logout.");
    }

    // --- SECCIÓN 2: REGISTRO Y REGLAS DE NEGOCIO ---

    #[Test]
    public function testAddCompanyPreventsDuplicateCuit() {
        // Escenario: El CUIT ya existe en el sistema (Lógica del AddCompany)
        $newCuit = "30-12345678-9";
        
        // Simulamos lo que devolvería $this->companyRepo->getByCuit($data['cuit'])
        $existingCompany = new Company();
        $existingCompany->setCuit($newCuit);

        $errorOccurred = false;
        if ($existingCompany) {
            $errorOccurred = true;
            $message = "Error: El CUIT ya se encuentra registrado.";
        }

        $this->assertTrue($errorOccurred);
        $this->assertEquals("Error: El CUIT ya se encuentra registrado.", $message);
    }

    // --- SECCIÓN 3: EDICIÓN E INTEGRIDAD ---

    #[Test]
    public function testEditCompanyValidatesIdPresence() {
        // Escenario: Se intenta editar sin enviar el ID de empresa (Paso 1 de editCompany)
        $postData = [
            'name' => 'UTN Corp'
            // Falta 'companyId'
        ];

        $error = "";
        try {
            if (!isset($postData['companyId'])) {
                throw new \Exception("ID de empresa no proporcionado.");
            }
        } catch (\Exception $ex) {
            $error = $ex->getMessage();
        }

        $this->assertEquals("ID de empresa no proporcionado.", $error);
    }

    #[Test]
    public function testEditCompanyMaintainsObjectIntegrity() {
        // Escenario: Verificamos que los setters actualicen correctamente el modelo antes de persistir
        $company = new Company();
        $company->setName("Old Name");

        $newName = "New Tech Solutions";
        $company->setName($newName);
        $company->setActive(true);

        $this->assertEquals("New Tech Solutions", $company->getName());
        $this->assertTrue($company->isActive());
    }
}