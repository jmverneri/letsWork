<?php
    use Utils\Utils;
    Utils::checkNav();
?>

<main class="py-5">
    <div class="container">
        <?php if (isset($message) && !empty($message)): ?>
            <?php 
                // Si el mensaje contiene "correctamente" o "éxito", usamos verde, sino rojo.
                $alertType = (strpos(strtolower($message), 'correctamente') !== false || strpos(strtolower($message), 'éxito') !== false) 
                            ? 'alert-success' 
                            : 'alert-danger';
            ?>
            <div class="alert <?= $alertType ?> alert-dismissible fade show shadow-sm border-0" role="alert" style="border-radius: 15px;">
                <i class="fas <?= ($alertType == 'alert-success') ? 'fa-check-circle' : 'fa-exclamation-circle' ?> me-2"></i>
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <h2 class="mb-4" style="color: #333;">
            <i class="fas fa-user-graduate"></i> Directorio de Estudiantes
        </h2>

        <div class="mb-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar por apellido..." style="max-width: 300px; border-radius: 20px;">
        </div>

        <div class="shadow-sm card">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th style="padding: 15px;">Nombre completo</th>
                            <th>Matrícula</th>
                            <th>DNI</th>
                            <th class="text-center">System Status</th>
                            <th class="text-center">Acciones</th> </tr>
                    </thead>
                    <tbody id="studentTableBody">
                        <?php 
                        if(!empty($studentList)) {
                            foreach($studentList as $student) { 
                        ?>
                            <tr class="student-row">
                                <td class="last-name-cell" style="vertical-align: middle; padding: 12px;">
                                    <strong><?php echo $student['lastName'] . ", " . $student['firstName']; ?></strong>
                                </td>
                                <td style="vertical-align: middle;">
                                    <span class="badge rounded-pill bg-light text-dark border shadow-sm px-3 py-2" style="font-weight: 600; font-family: monospace;">
                                        <?php echo $student['fileNumber']; ?>
                                    </span>
                                </td>
                                <td style="vertical-align: middle;">
                                    <?php echo $student['dni']; ?>
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <?php if($student['isRegistered']) { ?>
                                        <span class="badge" style="background-color: #28a745; color: white; padding: 6px 12px;">
                                            <i class="fas fa-check-circle"></i> REGISTRADO
                                        </span>
                                    <?php } else { ?>
                                        <span class="badge" style="background-color: #6c757d; color: white; padding: 6px 12px;">
                                            <i class="fas fa-clock"></i> PENDIENTE
                                        </span>
                                    <?php } ?>
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <a href="<?= FRONT_ROOT ?>Admin/showStudentAcademicView/<?= $student['dni']; ?>" 
                                        class="btn btn-primary btn-sm shadow-sm text-white fw-bold">
                                            <i class="fas fa-book-open me-1"></i> Académico
                                        </a>
                                </td>
                            </tr>
                        <?php 
                            } 
                        } else { ?>
                            <tr>
                                <td colspan="5" class="text-center py-4">No se encontraron estudiantes.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <a href="<?php echo FRONT_ROOT ?>Admin/ShowDashboard" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Volver al Dashboard
            </a>
        </div>
    </div>
</main>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('.student-row');

        rows.forEach(row => {
            let fullName = row.querySelector('.last-name-cell').textContent.trim().toLowerCase();
            if (fullName.includes(filter)) { // Cambiado a includes para búsqueda más flexible
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>