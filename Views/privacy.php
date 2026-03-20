<?php
use Utils\Utils;

require_once(VIEWS_PATH . "header.php");

Utils::checkNav(); 
?> 

<div class="container py-5" style="min-height: 70vh;">
    <h1 class="fw-bold mb-4">Política de Privacidad</h1>
    <p class="text-muted">En <strong>Let's Job</strong>, nos tomamos muy en serio la seguridad de tus datos.</p>
    <hr>
    <h3>1. Recopilación de Datos</h3>
    <p>Solo solicitamos información necesaria para la gestión de ofertas laborales y perfiles académicos.</p>
    <h3>2. Uso de la Información</h3>
    <p>Tus datos no serán compartidos con terceros ajenos al proceso de selección de las empresas registradas.</p>
</div>
<div class="mt-5 text-center">
    <a href="<?php echo FRONT_ROOT ?>Home/Index" class="btn btn-outline-dark px-4" style="border-radius: 8px;">
        <i class="bi bi-arrow-left me-2"></i> Volver al Inicio
    </a>
</div>