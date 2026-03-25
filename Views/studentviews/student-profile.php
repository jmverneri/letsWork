<?php
use Utils\Utils;

Utils::checkNav($notifications, $cantNotif);

$user = $_SESSION['loggedUser'];
?>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Student Profile</h2>
            <?php if (isset($message) && !empty($message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($errorMessage) && !empty($errorMessage)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?php echo $errorMessage; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <table class="table bg-light-alpha">
                <thead>
                    <tr>
                        <th>File Number</th>
                        <th>Name</th>
                        <th>Last Name</th>
                        <th>DNI</th>
                        <th>Birthday</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($student)) : ?>
                        <tr>
                            <td><?= htmlspecialchars($student->getFileNumber()?? '') ?></td>
                            <td><?= htmlspecialchars($student->getFirstName()) ?></td>
                            <td><?= htmlspecialchars($student->getLastName()) ?></td>
                            <td><?= htmlspecialchars($student->getDni()) ?></td>
                            <td><?= htmlspecialchars($student->getBirthDate()?? '') ?></td>
                            <td><?= htmlspecialchars($user->getEmail()) ?></td>
                            <td><?= htmlspecialchars($student->getPhoneNumber()?? '') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <h3 class="mb-4">Academic Status</h3>
            <table class="table bg-light-alpha">
                <thead>
                    <tr>
                        <th>Career</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?= $career ? htmlspecialchars($career->getDescription()) : 'No career assigned' ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-4">
                <a href="<?php echo FRONT_ROOT . "Home/menuStudent" ?>" class="btn btn-secondary" style="padding: 8px 15px; border-radius: 4px; text-decoration: none; color: white; background: #6c757d; display: inline-block;">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </section>
</main>
