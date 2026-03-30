<main class="py-5">
    <div class="container">
        <h2 class="mb-4">Asignar Materia Aprobada</h2>
        <h4 class="text-muted">Alumno: <?= $student->getFirstName() . " " . $student->getLastName() ?></h4>

        <form action="<?php echo FRONT_ROOT ?>Admin/addSubjectToStudent" method="POST" class="bg-light-alpha p-5">
            <input type="hidden" name="studentId" value="<?= $student->getStudentId() ?>">
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="form-group">
                        <label for="">Seleccionar Materia</label>
                        <select name="subjectId" class="form-control" required>
                            <option value="">-- Elija una materia --</option>
                            <?php foreach($subjectList as $subject): ?>
                                <option value="<?= $subject->getSubjectId() ?>">
                                    <?= $subject->getName() ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary mt-4">Registrar Aprobación</button>
            <a href="<?= FRONT_ROOT ?>Admin/showStudentList" class="btn btn-secondary mt-4">Cancelar</a>
        </form>
    </div>
</main>