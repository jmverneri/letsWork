<?php
use Utils\Utils;

Utils::checkNav();

$user = $_SESSION['loggedUser'];
?>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Student Profile</h2>

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

        </div>
    </section>
</main>
