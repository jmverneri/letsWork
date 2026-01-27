<?php
namespace Services;

use DAO\ICompanyDAO;
use Config\DAOFactory;
use Models\Company;
use Exception;

class CompanyService
{
    private ICompanyDAO $companyDAO;

    public function __construct()
    {
        $this->companyDAO = DAOFactory::getCompanyDAO();
    }

    /**
     * Obtiene la lista procesada (con filtro opcional)
     */
    public function getList(string $search = ""): array
    {
        $companies = $this->companyDAO->getAll();

        if (empty($search)) {
            return $companies;
        }

        $search = strtolower($search);
        return array_filter($companies, function($company) use ($search) {
            return str_contains(strtolower($company->getName()), $search);
        });
    }

    public function getById(int $id): ?Company
    {
        return $this->companyDAO->getById($id);
    }

    /**
     * Lógica de Negocio: Agregar empresa con validación de CUIT
     */
    public function addCompany(Company $company): bool
    {
        if ($this->isCuitDuplicate($company->getCuit())) {
            throw new Exception("There is already a company with that CUIT.");
        }

        return $this->companyDAO->AddCompany($company);
    }

    /**
     * Lógica de Negocio: Actualizar empresa validando CUIT si cambió
     */
    public function updateCompany(Company $company): bool
    {
        $existing = $this->companyDAO->getById($company->getCompanyId());
        
        // Si el CUIT cambió, verificamos que el nuevo no esté duplicado
        if ($existing && $existing->getCuit() !== $company->getCuit()) {
            if ($this->isCuitDuplicate($company->getCuit())) {
                throw new Exception("The new CUIT is already in use by another company.");
            }
        }

        return $this->companyDAO->Update($company);
    }

    public function deleteCompany(int $id): bool
    {
        // Aquí podrías agregar lógica extra, ej: no borrar si tiene ofertas activas
        return $this->companyDAO->delete($id);
    }

    /**
     * Validación interna de CUIT
     */
    private function isCuitDuplicate(string $cuit): bool
    {
        $companies = $this->companyDAO->getAll();
        foreach ($companies as $company) {
            if ($company->getCuit() === $cuit) {
                return true;
            }
        }
        return false;
    }
}