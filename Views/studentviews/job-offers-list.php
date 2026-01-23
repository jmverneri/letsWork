<?php
$user = $_SESSION['loggedUser'] ?? null;

if (!$user || !$user->isStudent()) {
    header("Location: " . FRONT_ROOT . "Home/index");
    exit();
}

require_once(STUDENT_VIEWS . 'nav.php');
?>

<main class="py-5">
    <section class="mb-5">
        <div class="container">
            <h2 class="mb-4">Available Job Offers</h2>

            <div class="container" style="max-height: 400px; overflow-y: auto;">

                <table class="table bg-light-alpha">
                    <thead>
                        <tr>
                            <th>Start Date</th>
                            <th>Deadline</th>
                            <th>Salary</th>
                            <th>Description</th>
                            <th>Career</th>
                            <th>Company</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php if (!empty($jobOffers)): ?>
                        <?php foreach ($jobOffers as $jobOffer): ?>
                            <tr>
                                <td><?= $jobOffer->getStartDate(); ?></td>
                                <td><?= $jobOffer->getDeadline(); ?></td>
                                <td><?= $jobOffer->getSalary(); ?></td>
                                <td><?= $jobOffer->getDescription(); ?></td>

                                <td>
                                    <?php
                                    foreach ($careerList as $career) {
                                        if ($career->getCareerId() == $jobOffer->getCareerId()) {
                                            echo $career->getDescription();
                                            break;
                                        }
                                    }
                                    ?>
                                </td>

                                <td>
                                    <?php
                                    foreach ($companiesList as $company) {
                                        if ($company->getCompanyId() == $jobOffer->getCompanyId()) {
                                            echo $company->getName();
                                            break;
                                        }
                                    }
                                    ?>
                                </td>

                                <td>
                                    <a href="<?= FRONT_ROOT ?>StudentJobOffer/addStudentToAJobOffer/<?= $jobOffer->getJobOfferId(); ?>/<?= $user->getUserId(); ?>">
                                        <button class="btn btn-success btn-sm">
                                            Apply
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No active job offers available.</td>
                        </tr>
                    <?php endif; ?>

                    </tbody>
                </table>

            </div>
        </div>
    </section>
</main>
