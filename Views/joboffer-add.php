<?php
    use Utils\Utils;
    Utils::loadNav();
?>

<main class="py-5">
    <div class="container">
        <h2 class="mb-4">Create Job Offer</h2>

        <form action="<?= FRONT_ROOT ?>JobOffer/add" method="post" class="bg-light p-4 rounded">

            <!-- Title -->
            <div class="mb-3">
                <label class="form-label">Job Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>

            <!-- Vacancies -->
            <div class="mb-3">
                <label class="form-label">Vacancies</label>
                <input type="number" name="vacancies" min="1" class="form-control" required>
            </div>

            <!-- Career -->
            <div class="mb-3">
                <label class="form-label">Career</label>
                <select name="careerId" class="form-select" required>
                    <option value="">Select career</option>
                    <?php foreach ($careers as $career): ?>
                        <option value="<?= $career->getCareerId() ?>">
                            <?= htmlspecialchars($career->getDescription()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Company (solo Admin) -->
            <?php if ($isAdmin): ?>
                <div class="mb-3">
                    <label class="form-label">Company</label>
                    <select name="companyId" class="form-select" required>
                        <option value="">Select company</option>
                        <?php foreach ($companies as $company): ?>
                            <option value="<?= $company->getCompanyId() ?>">
                                <?= htmlspecialchars($company->getName()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>

            <!-- Submit -->
            <button type="submit" class="btn btn-success">
                Create Job Offer
            </button>

        </form>
    </div>
</main>
