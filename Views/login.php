<br></br>

<main class="d-flex align-items-center justify-content-center height-90">
     <section>
          <div class=" content">
               <section class="text-center">
                    <br></br>
                    <img src="<?php echo IMG_PATH ?>Lets.png" width="400" height="141" alt="" />

                    <h2 class="text-center"> Login </h2>
               </section>
              
               <form action='<?php echo FRONT_ROOT ?>Home/login' method="post" class="">
                    <p><?php if (isset($message)) {
                              echo $message;
                         } ?></p>

                    <div class="form-group">
                         <label for="" align="center" class=>E-mail</label>
                         <input type="email" name="email" class="form-control form-control-sm text-center" placeholder="User required" required>
                    </div>

                    <div class="form-group">
                         <label for="" align="center">Password</label>
                         <input type="password" name="password" class="form-control form-control-sm text-center" placeholder="Password required" required>
                    </div>

                    <center>
                         <button class="btn btn-warning btn-block " type="submit">Session Start</button>
                    </center>

               </form>
               <br>
               <div>
                    <section>

                         <table class="table bg-light-alpha">
                              <thead>
                                   <form action="<?php echo FRONT_ROOT ?>Student/ShowStudentRegistration" method="get" class="login-form  p-1 ">
                                        <center>
                                             <button class="btn btn-primary" type="submit">Registration for students</button>
                                        </center>

                                   </form>
                                   <br>
                                   <form action="<?php echo FRONT_ROOT ?>UserCompany/ShowUserCompanyRegistrationView" method="get" class="login-form  p-1 ">
                                        <center>
                                             <button class="btn btn-info" type="submit">Registration For Companies</button>
                                        </center>

                                   </form>
                              </thead>

                    </section>
               </div>
          </div>
     </section>
</main>
<br>
<br></br>