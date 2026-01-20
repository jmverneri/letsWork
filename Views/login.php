<br></br>
<main class="d-flex align-items-center justify-content-center height-90">
    <section>
        <div class="content">
            <section class="text-center">
                <br></br>
                <img src="<?php echo IMG_PATH ?>Lets.png" width="400" height="141" alt="" />
                <h2 class="text-center">Login</h2>
            </section>
            
            <!-- BLOQUE DE ERROR CON MARGEN -->
            <?php if (isset($error) && !empty($error)): ?>
                <div class="alert alert-danger text-center mt-3 mb-3" role="alert">
                    <strong><?php echo htmlspecialchars($error); ?></strong>
                </div>
            <?php endif; ?>
            
            <form action='index.php?url=Home/login' method="post" class="">
                
                <div class="form-group">
                    <label align="center">
                        <em>E-mail</em>
                        <input type="email" name="email" class="form-control form-control-sm text-center" placeholder="User required" required>
                    </label>
                </div>
                
                <div class="form-group">
                    <label for="password" align="center">Password</label>
                    <input type="password" name="password" id="password" autocomplete="on" class="form-control form-control-sm text-center" placeholder="Password required" required>
                </div>
                
                <center>
                    <button class="btn btn-warning btn-block" type="submit">Session Start</button>
                </center>
            </form>
            
            <!-- <script src="<?php echo JS_PATH ?>form-validation.js"></script> -->
            <br>
            
            <div>
                <section>
                    <table class="table bg-light-alpha">
                        <thead>
                            <form action="index.php?url=Student/ShowStudentRegistration" method="get" class="login-form p-1">
                                <center>
                                    <button class="btn btn-primary" type="submit">Registration for students</button>
                                </center>
                            </form>
                            <br>
                            <form action="index.php?url=UserCompany/ShowUserCompanyRegistrationView" method="get" class="login-form p-1">
                                <center>
                                    <button class="btn btn-info" type="submit">Registration For Companies</button>
                                </center>
                            </form>
                        </thead>
                    </table>
                </section>
            </div>
        </div>
    </section>
</main>
<br>
<br></br>