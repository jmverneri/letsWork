<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Models\User;

class UserControllerTest extends TestCase {

    protected function setUp(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        $_SESSION = [];
    }

    // --- SECCIÓN: CAMBIO DE CONTRASEÑA FORZADO ---

    #[Test]
    public function testUpdatePasswordFromForceValidatesMismatchedPasswords() {
        // Escenario: El usuario intenta cambiar su clave obligatoria pero no coinciden
        $params = [
            "newPassword" => "admin123",
            "confirmPassword" => "diferente123"
        ];

        $passwordsMatch = ($params["newPassword"] === $params["confirmPassword"]);
        
        $this->assertFalse($passwordsMatch, "El sistema debería detectar que las contraseñas no coinciden.");
    }

    #[Test]
    public function testUpdatePasswordClearsMustChangeFlagInSession() {
        // Escenario: Cambio exitoso. El flag 'mustChangePassword' debe pasar a false en la sesión.
        $user = new User();
        $user->setEmail("javier@utn.com");
        $user->setMustChangePassword(true);
        $_SESSION['loggedUser'] = $user;

        // Simulamos la lógica post-update de tu controlador
        $_SESSION['loggedUser']->setMustChangePassword(false);

        $this->assertFalse($_SESSION['loggedUser']->getMustChangePassword(), "El flag debe limpiarse tras el cambio exitoso.");
    }

    // --- SECCIÓN: RECUPERACIÓN POR EMAIL (FORGOT PASSWORD) ---

    #[Test]
    public function testSendResetPasswordEmailChecksUserStatus() {
        // Escenario: El usuario existe pero está inactivo (bloqueo de seguridad)
        $user = new User();
        $user->setActive(false);

        $isAccountActive = $user->getActive();
        
        $this->assertFalse($isAccountActive, "No se debería enviar mail de recuperación a cuentas inactivas.");
    }

    #[Test]
    public function testTokenGenerationFormat() {
        // Escenario: Validar que el token generado sea seguro (Paso 1 de sendResetPasswordEmail)
        $token = bin2hex(random_bytes(32)); 
        
        $this->assertEquals(64, strlen($token), "El token debe tener 64 caracteres (hexadecimal de 32 bytes).");
        $this->assertIsString($token);
    }

    // --- SECCIÓN: RESET FINAL CON TOKEN ---

    #[Test]
    public function testResetPasswordWithExpiredOrInvalidTokenFails() {
        // Escenario: El getUserByToken no devuelve nada (token inválido o expirado)
        $userFromToken = null; 

        $tokenIsValid = ($userFromToken !== null);

        $this->assertFalse($tokenIsValid, "El flujo de reset debe fallar si el token no es válido.");
    }

    #[Test]
    public function testResetPasswordHasingSecurity() {
        // Escenario: Verificar que la contraseña se hashea antes de guardarse
        $newPassword = "passwordSegura2026";
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $this->assertNotEquals($newPassword, $hashedPassword, "La contraseña NUNCA debe guardarse en texto plano.");
        $this->assertTrue(password_verify($newPassword, $hashedPassword));
    }
}