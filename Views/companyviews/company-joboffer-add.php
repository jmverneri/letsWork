<?php
use Utils\Utils;

Utils::checkNav();
?>

<main class="py-5">
    <div class="container">
        <h2 class="mb-4">Agregar Nueva Oferta Laboral</h2>
        
        <form action="<?php echo FRONT_ROOT . "CompanyJobOffer/add" ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Título</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Posición Laboral</label>
                    <select name="jobPositionId" class="form-control" required>
                        <option value="">Elegir una posición...</option>
                        <?php 
                        if (!empty($jobPositions)) {
                            foreach($jobPositions as $position) { ?>
                                <option value="<?php echo $position->getJobPositionId(); ?>">
                                    <?php echo $position->getDescription(); ?>
                                </option>
                            <?php } 
                        } else { ?>
                            <option value="" disabled>Sin posiciones disponibles</option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Salario</label>
                    <input type="number" name="salary" class="form-control" step="0.01">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Flyer (Imágen)</label>
                    <input type="file" name="flyer" class="form-control" accept="image/*">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Comienzo</label>
                    <input type="date" name="startDate" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label>Deadline</label>
                    <input type="date" name="deadline" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Descripción</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Oferta</button>
            <a href="<?php echo FRONT_ROOT . "CompanyJobOffer/listMyOffers" ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</main>