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
        require_once(VIEWS_PATH . "forgot-password-nueva.php");
    }

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
        
        public function sendResetPasswordEmail($params) {
        try {
            $email = (is_array($params)) ? $params["email"] : $params;
            $user = $this->userRepo->getByEmail($email);
            
            if ($user && $user->getActive()) {
                // 1. Generamos el token y la expiración
                $token = bin2hex(random_bytes(32)); 
                $expires = date("Y-m-d H:i:s", strtotime("+1 hour")); 

                // 2. Guardamos en la BD
                $this->userRepo->setResetToken($email, $token, $expires);

                // 3. Preparamos el Mail
                $subject = "Recuperar contraseña - Let's Work";
                
                $resetLink = BASE_URL . "index.php?url=User/showNewPasswordForm&token=" . $token;

                $message = "
                    <html>
                    <body style='font-family: Arial, sans-serif; line-height: 1.6;'>
                        <h2>Solicitud de restablecimiento de contraseña</h2>
                        <p>Hola,</p>
                        <p>Has solicitado restablecer tu contraseña en <strong>Let's Work</strong>. Para continuar, haz clic en el siguiente botón:</p>
                        <p style='text-align: center;'>
                            <a href='$resetLink' style='background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;'>
                                Restablecer Contraseña
                            </a>
                        </p>
                        <p>Este enlace expirará en 1 hora.</p>
                        <p>Si no solicitaste esto, puedes ignorar este correo.</p>
                        <br>
                        <p>Saludos,<br>El equipo de Let's Work.</p>
                    </body>
                    </html>";

                // 4. Enviamos usando tu MailService
                MailService::send($email, $subject, $message);

                $messageSuccess = "¡Listo! Enviamos un link de recuperación a tu correo.";
                require_once(VIEWS_PATH . "login.php");
            } elseif ($user && !$user->getActive()) {
                // Caso: El usuario existe pero está inhabilitado
                $message = "Tu cuenta se encuentra inactiva. Por favor, contacta a Bedelía.";
                $type = "warning";
                require_once(VIEWS_PATH . "forgot-password.php");

            } else {
                // Caso: El usuario no existe (mensaje genérico por seguridad)
                $message = "Si el correo es válido, recibirás un link de recuperación.";
                $type = "info";
                require_once(VIEWS_PATH . "forgot-password-nueva.php");
            }
        } catch (Exception $ex) {
            $message = "Error al procesar la solicitud: " . $ex->getMessage();
            require_once(VIEWS_PATH . "forgot-password.php");
        }
    }

        public function showNewPasswordForm($params = null) {
            try {
                // 1. Limpieza del parámetro que viene del Router
                // Si el Router manda ['token' => 'abc...'], extraemos solo 'abc...'
                $token = (is_array($params)) ? ($params["token"] ?? null) : $params;

                if (!$token) {
                    $message = "Token no proporcionado.";
                    return require_once(VIEWS_PATH . "forgot-password.php");
                }

                // 2. Ahora sí, mandamos un STRING al repo
                $user = $this->userRepo->getUserByToken($token);

                if ($user) {
                    // El token es válido, mostramos la vista
                    // IMPORTANTE: Pasamos el $token a la vista para el input hidden
                    require_once(VIEWS_PATH . "new-password.php");
                } else {
                    $message = "El link ha expirado o es inválido. Por favor, solicita uno nuevo.";
                    $type = "danger";
                    require_once(VIEWS_PATH . "forgot-password.php");
                }
            } catch (Exception $ex) {
                $message = "Error al validar el acceso: " . $ex->getMessage();
                require_once(VIEWS_PATH . "forgot-password.php");
            }
        }

        public function ResetPassword($params) {
            // 1. Extraemos los datos del array que mandó el Formulario
            $token = $params["token"] ?? null;
            $newPassword = $params["newPassword"] ?? '';
            $confirmPassword = $params["confirmPassword"] ?? '';

            // 2. Validaciones básicas
            if ($newPassword !== $confirmPassword) {
                $message = "Las contraseñas no coinciden.";
                $type = "danger";
                // IMPORTANTE: Para que la vista no explote, necesitamos que el $token siga existiendo
                return require_once(VIEWS_PATH . "new-password.php");
            }

            try {
                // 3. Buscamos al usuario por el token (usando el string limpio)
                $user = $this->userRepo->getUserByToken($token);

                if ($user) {
                    // 4. Hasheamos la nueva password
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    
                    // 5. Actualizamos y LIMPIAMOS el token en la BD (el método que agregamos al DAO)
                    $this->userRepo->updatePasswordAndResetToken($user->getUserId(), $hashedPassword);
                    
                    $message = "¡Contraseña actualizada! Ya puedes ingresar con tu nueva clave.";
                    $type = "success";
                    require_once(VIEWS_PATH . "login.php");
                } else {
                    $message = "El token es inválido o ya fue utilizado.";
                    $type = "danger";
                    require_once(VIEWS_PATH . "forgot-password.php");
                }
            } catch (Exception $ex) {
                $message = "Error técnico: " . $ex->getMessage();
                $type = "danger";
                require_once(VIEWS_PATH . "forgot-password.php");
            }
        }
}