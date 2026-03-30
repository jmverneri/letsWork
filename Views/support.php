<?php
use Utils\Utils;

require_once(VIEWS_PATH . "header.php");

Utils::checkNav(); 
?>

<div class="container py-5 text-center" style="min-height: 70vh;">
    <h1 class="fw-bold mb-4">Centro de Soporte</h1>
    <div class="card shadow-sm p-5 border-0" style="border-radius: 15px;">
        <i class="bi bi-headset mb-3" style="font-size: 3rem; color: #37352f;"></i>
        <h3>¿Necesitas ayuda?</h3>
        <p class="text-muted">Si tienes problemas con tu cuenta de alumno o empresa, contacta a nuestro administrador.</p>
        <a href="mailto:admin@letsjob.com" class="btn btn-dark mt-3 px-4">Enviar Email</a>
    </div>
</div>
