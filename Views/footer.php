
<footer class="bg-white pt-5 pb-4 mt-auto border-top">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4 text-center text-md-start mb-3 mb-md-0">
                <span class="fw-bold" style="color: #37352f; letter-spacing: -0.5px;">
                    <img src="<?php echo IMG_PATH ?>Lets.png" width="30" height="30" class="me-2" alt="Logo">
                    Plataforma de Empleos
                </span>
            </div>

            <div class="col-md-4 text-center mb-3 mb-md-0">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><a href="#" class="text-muted small text-decoration-none mx-2">Privacidad</a></li>
                    <li class="list-inline-item"><a href="#" class="text-muted small text-decoration-none mx-2">Términos</a></li>
                    <li class="list-inline-item"><a href="#" class="text-muted small text-decoration-none mx-2">Soporte</a></li>
                </ul>
            </div>

            <div class="col-md-4 text-center text-md-end">
                <p class="text-muted small mb-0">
                    &copy; <?php echo date('Y'); ?> Universidad Tecnológica Nacional.
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        background-color: #fbfbfa; /* El mismo fondo que el login */
    }
    main {
        flex: 1; /* Esto empuja al footer hacia abajo */
    }
</style>