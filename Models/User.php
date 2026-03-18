<?php 
namespace Models;

class User
{
    // ══════════════════════════════════════════════════════════
    // CONSTANTES DE ROLES
    // ══════════════════════════════════════════════════════════
    const ROLE_ADMIN = 'admin';
    const ROLE_STUDENT = 'student';
    const ROLE_COMPANY = 'company';
    
    // Array de roles válidos para validación
    const VALID_ROLES = [
        self::ROLE_ADMIN,
        self::ROLE_STUDENT,
        self::ROLE_COMPANY
    ];
    
    
    // ══════════════════════════════════════════════════════════
    // PROPIEDADES
    // ══════════════════════════════════════════════════════════
    private $userId;
    private $email;
    private $password;
    private $role;
    private bool $mustChangePassword = false;
    private $active;
    
    // ══════════════════════════════════════════════════════════
    // CONSTRUCTOR
    // ══════════════════════════════════════════════════════════
    public function __construct($email = null, $password = null, $role = null)
    {
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }
    
    
    // ══════════════════════════════════════════════════════════
    // GETTERS
    // ══════════════════════════════════════════════════════════
    
    public function getUserId()
    {
        return $this->userId;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    public function getRole()
    {
        return $this->role;
    }

    public function mustChangePassword(): bool
    {
        return $this->mustChangePassword;
    }
    
    // ══════════════════════════════════════════════════════════
    // SETTERS CON VALIDACIÓN
    // ══════════════════════════════════════════════════════════
    
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }
    
    public function setEmail($email)
    {
        // Validación básica de email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Email inválido: $email");
        }
        
        $this->email = $email;
        return $this;
    }
    
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }
    
    public function setRole($role)
    {
        // Validar que el rol sea válido
        if (!in_array($role, self::VALID_ROLES)) {
            throw new \InvalidArgumentException(
                "Rol inválido: $role. Roles válidos: " . 
                implode(', ', self::VALID_ROLES)
            );
        }
        
        $this->role = $role;
        return $this;
    }
    
    // ══════════════════════════════════════════════════════════
    // MÉTODOS DE VERIFICACIÓN DE ROL (muy útiles!)
    // ══════════════════════════════════════════════════════════
    
    /**
     * Verifica si el usuario es administrador
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }
    
    /**
     * Verifica si el usuario es estudiante
     * @return bool
     */
    public function isStudent()
    {
        return $this->role === self::ROLE_STUDENT;
    }
    
    /**
     * Verifica si el usuario es empresa
     * @return bool
     */
    public function isCompany()
    {
        return $this->role === self::ROLE_COMPANY;
    }
    
    /**
     * Verifica si el usuario tiene un rol específico
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }
    
    
    // ══════════════════════════════════════════════════════════
    // MÉTODOS DE SEGURIDAD
    // ══════════════════════════════════════════════════════════
    
    /**
     * Hashea la contraseña (usar antes de guardar en BD)
     * @param string $password
     * @return string
     */
    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    /**
     * Verifica si una contraseña coincide con el hash
     * @param string $password Contraseña en texto plano
     * @param string $hash Hash almacenado
     * @return bool
     */
    public static function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
    
    /**
     * Verifica si la contraseña del objeto coincide
     * (útil si guardás hash en la propiedad)
     * @param string $passwordToCheck
     * @return bool
     */
    public function checkPassword($passwordToCheck)
    {
        return password_verify($passwordToCheck, $this->password);
    }
    
    
    // ══════════════════════════════════════════════════════════
    // MÉTODOS ÚTILES
    // ══════════════════════════════════════════════════════════
    
    /**
     * Retorna un array con los datos del usuario
     * (útil para JSON, logging, etc.)
     * @return array
     */
    public function toArray()
    {
        return [
            'userId' => $this->userId,
            'email' => $this->email,
            'role' => $this->role
            // NO incluir password por seguridad
        ];
    }
    
    /**
     * Retorna representación string del usuario
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            "User[%s] - %s (%s)",
            $this->userId ?? 'new',
            $this->email,
            $this->role
        );
    }
    
    /**
     * Verifica si el usuario está completo (tiene todos los datos necesarios)
     * @return bool
     */
    public function isValid()
    {
        return !empty($this->email) && 
               !empty($this->password) && 
               in_array($this->role, self::VALID_ROLES);
    }

    public function getActive() { 
        return $this->active; 
    }

    public function setActive($active) { 
        $this->active = $active; 
    }

    public function getMustChangePassword() {
        return $this->mustChangePassword;
    }

    public function setMustChangePassword($mustChangePassword) {
        $this->mustChangePassword = $mustChangePassword;
    }
}
?>