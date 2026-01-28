<?php
    use Utils\Utils;

    Utils::checkNav();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Menu</title>
    </head>

<body>

<main class="container text-center my-5">

    <div class="mb-4">
        <img src="<?= IMG_PATH ?>Lets.png" width="400" height="141" alt="Lets Work" class="img-fluid">
    </div>

    <section class="welcome-header mb-5">
        <h1 class="text-warning mb-2">
            You are Welcome, <?= htmlspecialchars($student->getFirstName()) ?>!
        </h1>
        <p class="lead text-muted">
            <em>Please choose one of the next actions</em>
        </p>
    </section>

    <hr class="my-4">

    <nav class="d-flex flex-wrap justify-content-center gap-3">

        <a class="btn btn-info btn-lg px-4 shadow-sm"
           href="<?= FRONT_ROOT ?>Student/showStudentProfile">
            <i class="fas fa-user mr-2"></i> Profile
        </a>

        <a class="btn btn-warning btn-lg px-4 shadow-sm"
           href="<?= FRONT_ROOT ?>StudentCompany/showListView">
            <i class="fas fa-building mr-2"></i> See Companies
        </a>

        <a class="btn btn-warning btn-lg px-4 shadow-sm"
           href="<?= FRONT_ROOT ?>StudentJobOffer/listJobOffers">
            <i class="fas fa-briefcase mr-2"></i> Job Offers List
        </a>

    </nav>

</main>

</body>
</html>