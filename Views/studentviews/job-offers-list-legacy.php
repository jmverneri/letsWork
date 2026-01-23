<?php
$user = $_SESSION['loggedUser'] ?? null;

if ($user && $user->isAdmin()) {
    require_once(ADMIN_VIEWS . 'navcompany.php');
} elseif ($user && $user->isStudent()) {
    require_once(STUDENT_VIEWS . 'nav.php');
}
?>

<main class="py-5">
    <section id="listado" class="mb-5">

        <div class="container">
            <h2 class="mb-4">Job Offers</h2>

            <div class="container" style="width: 2000px; height: 400px; overflow-y: scroll;">


                <div class="container" position="fixed">


                    <form action="<?php echo BASE_FOLDER ?>/JobOffer/ShowJobsViews" method="POST" enctype="multipart/form-data">

                        <input type="text" name="search" class="form-control form-control-ml" required value="">

                        <button type="submit" class="btn btn-dark ml-auto d-block">Search</button>
                    </form>
                </div>
                <table class="table bg-light-alpha">
                    <thead>
                        <th class="header" scope="col" position="sticky">Name</th>
                        <th class="header" scope="col" position="sticky">Start Date</th>
                        <th class="header" scope="col" position="sticky">Limit Date</th>
                        <th class="header" scope="col" position="sticky">Salary</th>
                        <th class="header" scope="col" position="sticky">Description</th>
                        <th class="header" scope="col" position="sticky">Career</th>
                        <th class="header" scope="col" position="sticky">Company</th>
                        <th class="header" scope="col" position="sticky"></th>


                    </thead>
                    <tbody>
                        <?php
                        if ($jobOffers != null) {
                            foreach ($jobOffers as $jobOffer) {
                                    echo "<tr>";
                                    //echo  "<td>" . $jobOffer->getName() . "</td>";
                                    echo  "<td>" . $jobOffer->getStartDate() . "</td>";
                                    echo  "<td>" . $jobOffer->getDeadline() . "</td>";
                                    echo  "<td>" . $jobOffer->getSalary() . "</td>";
                                    echo  "<td>" . $jobOffer->getDescription() . "</td>";

                                    foreach ($careerList as $career) {
                                        if ($career->getCareerId() == $jobOffer->getCareerId()) {
                                            echo  "<td>" . $career->getDescription() . "</td>";
                                        }
                                    }
                                    foreach ($companiesList as $company) {
                                        if ($company->getCompanyId() == $jobOffer->getCompanyId()) {
                                            echo  "<td>" . $company->getName() . "</td>";
                                        }
                                    }
                                    if (isset($_SESSION["student"])) {
                                        $student = $_SESSION["student"];
                                        echo "<div class='row'>";
                                        echo "<div class='button-conteiner'>";
                                        echo "<td><a href=" . FRONT_ROOT . "JobOffer/addStudentToAJobOffer/" . $jobOffer->getJobOfferId() . "/" . $student->getStudentId() . ">
                                <button type='button' class= 'btn btn-success' > Add me </button></a></td>";
                                        echo "</div>";
                                        echo "</div>";
                                    }
                                }
                            }
                        else {
                            echo "The job Offers list is empty";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        </form>
    </section>
</main>