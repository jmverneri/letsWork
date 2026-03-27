<?php
    use Utils\Utils;
    Utils::checkNav();
?>

<main class="py-5">
    <div class="container">
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
                            <th>Email (API)</th>
                            <th>DNI</th>
                            <th class="text-center">System Status</th>
                        </tr>
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
                                    <span class="badge badge-light" style="border: 1px solid #ddd;">
                                        <?php echo $student['fileNumber']; ?>
                                    </span>
                                </td>
                                <td style="vertical-align: middle; color: #666;">
                                    <?php echo $student['email']; ?>
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
                            </tr>
                        <?php 
                            } 
                        } else { ?>
                            <tr>
                                <td colspan="5" class="text-center py-4">No students found in the API.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <a href="<?php echo FRONT_ROOT ?>Admin/ShowDashboard" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>
</main>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('.student-row');

        rows.forEach(row => {
            // Obtenemos el texto del apellido
            let fullName = row.querySelector('.last-name-cell').textContent.trim().toLowerCase();
            
            // Si el nombre completo EMPIEZA con el filtro, lo mostramos
            // (Usamos trim para limpiar espacios accidentales)
            if (fullName.startsWith(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>

<style>
    .table thead th { border: none; }
    .student-row:hover { background-color: #f8f9fa; }
    .badge { font-weight: 500; letter-spacing: 0.5px; }
</style>