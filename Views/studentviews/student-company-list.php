<?php
use Utils\Utils;

Utils::checkNav();

?>

<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Companies List</h2>

            <div class="container" style="width: 100%; height: 400px; overflow-y: scroll;">
                <div class="container" position="fixed">
                        <form action="index.php" method="GET">
                            <input type="hidden" name="url" value="StudentCompany/showListView">
                            <input type="text" name="search" class="form-control">
                            <button type="submit">Search</button>
                        </form>
                    </div>    
                <table class="table bg-light-alpha">
                    <thead>
                        <th>Name</th>
                        <th>City</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php if (!empty($companiesList)): ?>
                            <?php foreach ($companiesList as $company): ?>
                                <tr>
                                    <td><?= $company->getName(); ?></td>
                                    <td><?= $company->getCity(); ?></td>
                                    <td><?= $company->getEmail(); ?></td>
                                    <td>
                                        <a href="<?= FRONT_ROOT ?>JobOffer/showOffersByCareer/<?= $company->getCompanyId(); ?>"
                                           class="btn btn-secondary">
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
