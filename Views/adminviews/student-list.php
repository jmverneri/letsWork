<?php

use Utils\Utils;

Utils::checkNav();

?>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">

            <h2 class="mb-4">Students List</h2>

            <div class="container" style="width: 2000px; height: 400px; overflow-y: scroll;">
                <table class="table bg-light-alpha">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">FILE NUMBER</th>
                            <th scope="col">Name</th>
                            <th scope="col">Surname</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Email</th>
                            <th scope="col">Career</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($studentsView)) : ?>
                            <?php foreach ($studentsView as $student) : ?>
                                <tr>
                                   <td><?= $student['fileNumber'] ?? '—'; ?></td>
                                    <td><?= $student['firstName']; ?></td>
                                    <td><?= $student['lastName']; ?></td>
                                    <td><?= ucfirst($student['gender'] ?? 'Not specified'); ?></td>
                                    <td><?= $student['email'] ?? '—'; ?></td>
                                    <td><?= $student['career'] ?? 'No career assigned'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6">No students found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </section>
</main>
