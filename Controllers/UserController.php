<?php
namespace Controllers;

use Repositories\UserRepository;
use Models\User;
use Utils\MailService;
use Exception;

class UserController {
    private $userRepo;

    public function __construct() {
        $this->userRepo = new UserRepository();
    }

    public function ShowForgotPasswordView($message = "", $type = "") {
        require_once(VIEWS_PATH . "forgot-password.php");
    }

    // Procesa el envío del mail de recuperación
    public function SendResetPasswordEmail($emailPost) {

        $email = (is_array($emailPost)) ? $emailPost["email"] : $emailPost;
        try {
            $user = $this->userRepo->GetByEmail($email);

            if ($user) {
                $passwordProvisoria = substr(bin2hex(random_bytes(4)), 0, 8);
    
            // 2. La guardamos en la BD (Hasheada si es que usas password_hash en tu login)
            // Suponiendo que tenés un método UpdatePassword en tu Repo:
            $hash = password_hash($passwordProvisoria, PASSWORD_DEFAULT);
            $this->userRepo->UpdatePassword($user->getEmail(), $hash);

            $subject = "Nueva contraseña temporal - Let's Job";
            $message = "
                <html>
                <head>
                    <meta charset='UTF-8'>
                </head>
                <body style='font-family: sans-serif; color: #37352f;'>
                    <h2>Hola, " . $user->getEmail() . "</h2>
                    <p>Has solicitado recuperar tu acceso a <strong>Let's Job</strong>.</p>
                    <p>Hemos generado una clave temporal para ti:</p>
                    <p style='background: #f4f4f4; padding: 15px; display: inline-block; font-size: 1.5rem; font-weight: bold; border-radius: 8px;'>
                        " . $passwordProvisoria . "
                    </p>
                    <p><strong>Importante:</strong> Por seguridad, cambia esta contraseña apenas ingreses al sistema.</p>
                    <br>
                    <p>Saludos,<br>El equipo de Let's Job.</p>
                </body>
                </html>";

                // Usamos el MailService que ya tenemos configurado con Mailtrap
                MailService::send($email, $subject, $message);

                //$this->ShowForgotPasswordView("¡Listo! Revisa tu casilla de correo.", "success");
                $messageSuccess = "¡Listo! Revisa tu correo e ingresa con la nueva clave.";
            require_once(VIEWS_PATH . "login.php"); 
            // O si tu Router permite redirección: 
            // header("location: " . FRONT_ROOT . "Home/Index?message=" . $messageSuccess);
            } else {
                $this->ShowForgotPasswordView("El email ingresado no coincide con ningún usuario registrado.", "danger");
            }
        } catch (Exception $ex) {
            $this->ShowForgotPasswordView("Error al procesar la solicitud: " . $ex->getMessage(), "danger");
        }
    }

    // En UserController.php

// Muestra la vista con el formulario
public function ShowChangePasswordView($message = "") {
    require_once(VIEWS_PATH . "change-password-forced.php");
}

// Procesa el cambio
public function UpdatePasswordFromForce($params) {
    $newPassword = $params["newPassword"] ?? '';
    $confirmPassword = $params["confirmPassword"] ?? '';    

    if ($newPassword !== $confirmPassword) {
            return $this->ShowChangePasswordView("Las contraseñas no coinciden.");
        }

        $user = $_SESSION['loggedUser'];
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        try {
            // 1. Actualizamos en BD: Nueva pass Y seteamos mustChangePassword = 0
            $this->userRepo->UpdatePasswordAndClearFlag($user->getEmail(), $hashedPassword);
            
            // 2. Actualizamos el objeto en la Sesión para que el login lo deje pasar ahora
            $user->setMustChangePassword(false);
            $_SESSION['loggedUser'] = $user;

            // 3. Ahora sí, lo mandamos a su menú correspondiente
            header("Location: " . FRONT_ROOT . "Home/Index"); 
        } catch (Exception $ex) {
            $this->ShowChangePasswordView("Error al actualizar: " . $ex->getMessage());
        }
    }
}