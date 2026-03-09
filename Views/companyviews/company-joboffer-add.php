<main class="py-5">
    <div class="container">
        <h2 class="mb-4">Add New Job Offer</h2>
        
        <form action="<?php echo FRONT_ROOT . "CompanyJobOffer/add" ?>" method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Job Position</label>
                    <select name="jobPositionId" class="form-control" required>
                        <option value="">Select a position...</option>
                        <?php 
                        if (!empty($jobPositions)) {
                            foreach($jobPositions as $position) { ?>
                                <option value="<?php echo $position->getJobPositionId(); ?>">
                                    <?php echo $position->getDescription(); ?>
                                </option>
                            <?php } 
                        } else { ?>
                            <option value="" disabled>No positions available</option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Salary</label>
                    <input type="number" name="salary" class="form-control" step="0.01">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Start Date</label>
                    <input type="date" name="startDate" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Deadline</label>
                    <input type="date" name="deadline" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save Offer</button>
            <a href="<?php echo FRONT_ROOT . "CompanyJobOffer/listMyOffers" ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</main>