<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4 text-white">Job Offers List</h2>           
        
            <div class="table-responsive" style="height: 600px; overflow-y: auto;">
                <table class="table bg-light-alpha">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">Limit Date</th>
                            <th scope="col">Salary</th>
                            <th scope="col">Description</th>
                            <th scope="col">Position (Career)</th>
                            <th scope="col">Company</th>
                            <th scope="col" colspan="2" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($jobOfferList)) {
                            foreach ($jobOfferList as $jobOffer) {
                                ?>
                                <tr>
                                    <td><?php echo $jobOffer->getTitle(); ?></td>
                                    <td><?php echo $jobOffer->getStartDate(); ?></td>
                                    <td><?php echo $jobOffer->getDeadline(); ?></td>
                                    <td>$<?php echo number_format($jobOffer->getSalary(), 2); ?></td>
                                    <td><?php echo $jobOffer->getDescription(); ?></td>

                                    <td>
                                        <?php 
                                            $jobPosition = $this->jobPositionDAO->getById($jobOffer->getJobPositionId());
                                            echo ($jobPosition) ? $jobPosition->getDescription() : "N/A";
                                        ?>
                                    </td>

                                    <td>
                                        <?php 
                                            foreach ($companiesList as $company) {
                                                if ($company->getCompanyId() == $jobOffer->getCompanyId()) {
                                                    echo $company->getName();
                                                }
                                            }
                                        ?>
                                    </td>

                                    <td>
                                        <a href="<?php echo FRONT_ROOT . "AdminJobOffer/showModifyJobOfferView/" . $jobOffer->getjobOfferId(); ?>" class="btn btn-success btn-sm">
                                            Modify
                                        </a>
                                    </td>

                                    <td>
                                        <a href="<?php echo FRONT_ROOT . "AdminJobOffer/deleteJobOffer/" . $jobOffer->getjobOfferId(); ?>" class="btn btn-danger btn-sm">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='9' class='text-center'>The job Offers list is empty</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <a href="<?php echo FRONT_ROOT . "AdminCompany/showCompaniesViews" ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Companies
                </a>
            </div>
        </div>
    </section>
</main>