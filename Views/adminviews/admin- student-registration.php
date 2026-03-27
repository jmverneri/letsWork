
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <br><br><br>
            <h2 class="mb-4">Student Profile</h2>
            <table class="table bg-light-alpha">
                <thead>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>DNI</th>
                    <th>Género</th>
                    <th>Fecha de nacimiento</th>
                    <th>Id</th>
                    <th>Carrera</th>
                    <th>Email</th>
                    <th>Número de teléfono</th>
                </thead>
                <tbody>

                    <?php
                    if (isset($student)) {
                        echo  "<td>" . $student->getFirstName() . "</td>";
                        echo  "<td>" . $student->getLastName() . "</td>";
                        echo  "<td>" . $student->getDni() . "</td>";
                        echo  "<td>" . $student->getGender() . "</td>";
                        echo  "<td>" . $student->getBirthDate() . "</td>";
                        echo  "<td>" . $student->getFileNumber() . "</td>";
                        echo  "<td>" . $student->getCareerId() . "</td>";
                        echo  "<td>" . $student->getEmail() . "</td>";
                        echo  "<td>" . $student->getPhoneNumber() . "</tdv>";
                    }
                    ?>
                </tbody>
                </table>
        </div>
    </section>
   
    <div class="d-flex align-items-center justify-content-center height-200">
    
        <form action='<?php echo FRONT_ROOT ?>Student/studentRegistration' method="post" class=" justify-content-center p-1">
            <div class="form-group-lg-center">
                <div>
                    
                    <input type="email" name="email" class="form-control form-control-sm" value="<?php echo $student->getEmail()?>" required>
                                
                    <label for="" align="center">Password</label>
                    <input type="password" alt="strongPass" name="password" class="form-control " placeholder="User required" required>
                  

                    <label for="" align="center">Confirmar Password</label>
                    <input type="password" alt="strongPass" name="confirmPass" class="form-control form-control-sm" placeholder="Password required" required>

                 
                        <button class="btn btn-warning btn-block btn-sm " type="submit">Registración</button>
                    
                </div>

            </div>
        </form>
        </div>
   <br><br>
</main>