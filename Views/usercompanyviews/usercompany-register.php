<?php
require_once(VIEWS_PATH."nav.php");
?>

<main class="py-5">

    <section id="listado" class="mb-5">
        <div class="container">

            <h2 class="mb-4">Company Registration</h2>
            <form action='<?php echo FRONT_ROOT ?>UserCompany/userCompanyRegistration' method="POST" class="bg-light-alpha p-5">

                <div class="row">
                    <div class="col-lg-4">

                        <label for="firstname"><b>First Name</b></label>
                        <input type="text" name="firstName" class="form-control " id="firstname" required value="">

                    </div>
                    <div class="col-lg-4">

                        <label for="lastname"><b>Last Name</b></label>
                        <input type="text" name="lastName" class="form-control" id="lastname" required value="">

                    </div>
                    <div class="col-lg-4">

                        <label for="dni"><b>DNI</b></label>
                        <br>
                        <input type="number" name="dni" id="dni" class="form-control" required value="">
                    </div>

                    <div class="col-lg-4">

                        <label for="email"><b>Email</b></label>
                        <input type="mail" name="email" class="form-control" id="email" required value="">

                    </div>
                    <div class="col-lg-4">

                        <label for="phonenumber"><b>Phone Number</b></label>
                        <input type="number" name="phoneNumber" class="form-control" id="phonenumber" required value="">

                    </div>
                    <div class="col-lg-4">

                        <label for="password"><b>Password</b></label>
                        <input type="password" name="password" class="form-control" required value="">

                    </div>
                    <div class="col-lg-4">

                        <label for=""><b>Confirm Password</b></label>
                        <input type="password" name="confirmPassword" value="" id="password" class="form-control" required value="">

                    </div>

                </div>


                <button type="submit" name="" class="btn btn-warning ml-auto d-block">Registration</button>



            </form>
        </div>
    </section>
</main>
<br><br><br>