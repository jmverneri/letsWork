<?php
use Utils\Utils;

require_once(VIEWS_PATH . "header.php");

Utils::checkNav(); 
?>

<div class="container py-5" style="min-height: 70vh; max-width: 800px;">
    <div class="text-center mb-5">
        <i class="bi bi-file-earmark-text mb-3" style="font-size: 3rem; color: #37352f;"></i>
        <h1 class="fw-bold">Términos y Condiciones de Uso</h1>
        <p class="text-muted">Última actualización: <?= date('d/m/Y') ?></p>
    </div>

    <div class="card border-0 shadow-sm p-4 p-md-5" style="border-radius: 15px;">
        <section class="mb-4">
            <h4 class="fw-bold">1. Aceptación de los Términos</h4>
            <p class="text-muted">Al acceder y utilizar <strong>Let's Job</strong>, el usuario acepta cumplir con los presentes términos. Si no está de acuerdo, deberá abstenerse de utilizar la plataforma.</p>
        </section>

        <section class="mb-4">
            <h4 class="fw-bold">2. Responsabilidad de los Datos</h4>
            <p class="text-muted">Los estudiantes son responsables de la veracidad de la información en sus perfiles. Las empresas son responsables de la legalidad de las ofertas publicadas.</p>
        </section>

        <section class="mb-4">
            <h4 class="fw-bold">3. Uso Correcto de la Plataforma</h4>
            <p class="text-muted">Queda prohibido el uso de la plataforma para fines ilícitos, spam, o la publicación de contenido ofensivo. El Administrador se reserva el derecho de dar de baja cualquier cuenta que infrinja estas normas.</p>
        </section>

        <section class="mb-4">
            <h4 class="fw-bold">4. Propiedad Intelectual</h4>
            <p class="text-muted">El diseño, logos y código fuente de <strong>Let's Job</strong> son propiedad exclusiva del equipo de desarrollo y están protegidos por leyes de propiedad intelectual.</p>
        </section>

        <div class="alert alert-light border-0 mt-4 small text-center" style="background-color: #f8f9fa;">
            Para dudas sobre estos términos, contacte a <a href="<?= FRONT_ROOT ?>Home/Support">Soporte Técnico</a>.
        </div>
    </div>
</div>
