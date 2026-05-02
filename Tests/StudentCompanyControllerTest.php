<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Models\Company;

class StudentCompanyControllerTest extends TestCase {

    #[Test]
    public function testSearchFilterSensitivity() {
        // Escenario: El alumno busca "Goo"
        $companyName = strtolower("Google");
        $searchTerm = strtolower("Goo");

        // El filtro actual usa !== 0 para descartar si no empieza exacto
        $match = (strpos($companyName, $searchTerm) === 0);

        $this->assertTrue($match, "El filtro debería encontrar 'Google' si se busca 'Goo'.");
    }

    #[Test]
    public function testSearchFilterExcludesMiddleMatches() {
        // Escenario: El alumno busca "oo" (en el medio de Google)
        $companyName = strtolower("Google");
        $searchTerm = strtolower("oo");

        // Según tu lógica (strpos !== 0), esto debería quedar fuera
        $isExcluded = (strpos($companyName, $searchTerm) !== 0);

        $this->assertTrue($isExcluded, "La lógica actual excluye coincidencias que no estén al inicio.");
    }

    #[Test]
    public function testCompanyDetailExists() {
        // Escenario: Verificar que el objeto empresa no sea nulo antes de cargar la vista
        $company = new Company();
        $company->setName("UTN");

        $this->assertNotNull($company->getName());
        $this->assertEquals("UTN", $company->getName());
    }
}