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
                            <input type="hidden" name="url" value="StudentCompany/showCompaniesViews">
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
                        <?php if (!empty($companiesWithEmail)): ?>
                            <?php foreach ($companiesWithEmail as $item):
                                $company = $item['company'];
                                $email   = $item['email'];
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($company->getName()) ?></td>
                                    <td><?= htmlspecialchars($company->getCity() ?? '-') ?></td>
                                    <td><?= htmlspecialchars($email) ?></td>
                                    <td>
                                        <a href="<?= FRONT_ROOT ?>StudentJobOffer/showOffersByCompany/<?= $company->getCompanyId(); ?>"
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
