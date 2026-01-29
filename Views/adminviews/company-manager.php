<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Companies List</h2>

            <div class="container" style="width: 100%; height: 400px; overflow-y: scroll;">
                <div class="container">
                    <form action="index.php" method="GET" class="mb-3">
                        <input type="hidden" name="url" value="AdminCompany/showCompaniesViews">
                        <input type="text" name="search" class="form-control mb-2">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>

                <table class="table bg-light-alpha">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>City</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php if (!empty($companiesWithUser)): ?>
                        <?php foreach ($companiesWithUser as $item): 
                            $company = $item['company'];
                            $email   = $item['email'];
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($company->getName()) ?></td>
                                <td><?= htmlspecialchars($company->getCity() ?? '-') ?></td>
                                <td><?= htmlspecialchars($email) ?></td>
                                <td>
                                    <a href="<?= FRONT_ROOT ?>Company/deleteCompany/<?= $company->getCompanyId(); ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Are you sure?')">
                                        Delete
                                    </a>

                                    <a href="<?= FRONT_ROOT ?>Company/showModifyCompanyView/<?= $company->getCompanyId(); ?>"
                                       class="btn btn-success btn-sm">
                                        Modify
                                    </a>

                                    <a href="<?= FRONT_ROOT ?>JobOffer/showAddJobOfferForCompany/<?= $company->getCompanyId(); ?>"
                                       class="btn btn-info btn-sm">
                                        Add Job Offer
                                    </a>

                                    <a href="<?= FRONT_ROOT ?>JobOffer/showJobsOffersViewByCompany/<?= $company->getCompanyId(); ?>"
                                       class="btn btn-secondary btn-sm">
                                        Job Offers
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No companies found</td>
                        </tr>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>
