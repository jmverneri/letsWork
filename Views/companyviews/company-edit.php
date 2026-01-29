<?php
use Utils\Utils;

Utils::checkNav();

if (!isset($company)) {
    echo "<p class='text-danger text-center'>Company not found</p>";
    exit;
}
?>

<main class="py-5">
    <section class="container">
        <h2 class="mb-4 text-center">Edit Company</h2>

        <form action="<?= FRONT_ROOT ?>Company/update" method="POST" class="bg-light-alpha p-4 rounded">

            <input type="hidden" name="companyId" value="<?= $company->getCompanyId() ?>">

            <div class="mb-3">
                <label class="form-label">Company Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       required
                       value="<?= htmlspecialchars($company->getName()) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">CUIT</label>
                <input type="text"
                       name="cuit"
                       class="form-control"
                       required
                       value="<?= htmlspecialchars($company->getCuit()) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Year of Foundation</label>
                <input type="number"
                       name="yearFoundation"
                       class="form-control"
                       min="1800"
                       max="<?= date('Y') ?>"
                       value="<?= htmlspecialchars($company->getYearFoundation()) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">City</label>
                <input type="text"
                       name="city"
                       class="form-control"
                       value="<?= htmlspecialchars($company->getCity() ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text"
                       name="phoneNumber"
                       class="form-control"
                       value="<?= htmlspecialchars($company->getPhoneNumber() ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description"
                          class="form-control"
                          rows="4"><?= htmlspecialchars($company->getDescription() ?? '') ?></textarea>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="<?= FRONT_ROOT ?>Company/showListView" class="btn btn-secondary">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    Save Changes
                </button>
            </div>

        </form>
    </section>
</main>
