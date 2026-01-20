<?php 
namespace Models;

class User
{
    private $email;
    private $password;
    
    /**
     * Constructor - Acepta parámetros opcionales
     */
    public function __construct($email = null, $password = null)
    {
        $this->email = $email;
        $this->password = $password;
    }
    
    // ══════════════════════════════════════════════════════════
    // GETTERS
    // ══════════════════════════════════════════════════════════
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    // ══════════════════════════════════════════════════════════
    // SETTERS
    // ══════════════════════════════════════════════════════════
    
    public function setEmail($email)
    {
        $this->email = $email;
        return $this; // Para permitir chaining: $user->setEmail()->setPassword()
    }
    
    public function setPassword($password)
    {
        $this->password = $password;
        return $this; // Para permitir chaining
    }
}
?>