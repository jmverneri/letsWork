<?php
use Utils\Utils;

Utils::checkNav();

$user = $_SESSION['loggedUser'];
?>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Perfil del Estudiante</h2>
            <?php if (isset($message) && !empty($message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($errorMessage) && !empty($errorMessage)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?php echo $errorMessage; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <table class="table bg-light-alpha">
                <thead>
                    <tr>
                        <th>Matrícula</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>DNI</th>
                        <th>Fecha de nacimiento</th>
                        <th>Email</th>
                        <th>Número de teléfono</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($student)) : ?>
                        <tr>
                            <td><?= htmlspecialchars($student->getFileNumber()?? '') ?></td>
                            <td><?= htmlspecialchars($student->getFirstName()) ?></td>
                            <td><?= htmlspecialchars($student->getLastName()) ?></td>
                            <td><?= htmlspecialchars($student->getDni()) ?></td>
                            <td><?= htmlspecialchars($student->getBirthDate()?? '') ?></td>
                            <td><?= htmlspecialchars($user->getEmail()) ?></td>
                            <td><?= htmlspecialchars($student->getPhoneNumber()?? '') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <h3 class="mb-4">Status Académico</h3>
            <table class="table bg-light-alpha">
                <thead>
                    <tr>
                        <th>Carrera</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?= $career ? htmlspecialchars($career->getDescription()) : 'No career assigned' ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <h3 class="mt-5 mb-4">Materias Aprobadas</h3>
            <div class="table-responsive">
                <table class="table bg-light-alpha table-hover">
                    <thead>
                        <tr>
                            <th>Materia</th>
                            <th>Descripción</th>
                            <th class="text-center">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($approvedSubjects) && !empty($approvedSubjects)) : ?>
                            <?php foreach ($approvedSubjects as $subject) : ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($subject->getAsignatura()) ?></strong></td>
                                    <td><?= htmlspecialchars($subject->getCursado() ?? 'Sin descripción disponible') ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-success text-white" style="padding: 0.5em 1em;">
                                            <i class="fas fa-check-circle me-1"></i> Aprobada
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    No se registran materias aprobadas para este perfil.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="card border-0 shadow-sm mt-4" style="border-radius: 15px;">

            <div class="mt-4">
                <a href="<?php echo FRONT_ROOT . "Home/menuStudent" ?>" class="btn btn-secondary" style="padding: 8px 15px; border-radius: 4px; text-decoration: none; color: white; background: #6c757d; display: inline-block;">
                    <i class="fas fa-arrow-left"></i> Volver al Dashboard
                </a>
            </div>
        </div>
    </section>
</main>
