<body >
<br><br>
    <section class="text-center">
        <br><br>
        <img src="<?php echo IMG_PATH ?>Lets.png" width="400" height="141" alt="" />
<main class="d-flex align-items-center justify-content-center height-100">
     <div class="content">
          <section class="text-center">

          <br><br>

               <h2> STUDENT REGISTRATION </h2>
              
              
          </section>
          
          <form action='<?php echo FRONT_ROOT ?>student/studentValidation' method="post" class="login-form align-items-center justify-content-center  p-4 bg-none">
         

               <div class="form-group" align="center">
                    <label for="" align="center">E-mail</label>
                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Email required" required>
               </div>
               
               <center>
                    <button class="btn btn-warning btn-block btn-sm" type="submit">Check Mail</button>

               </center>
               <br>
               <h5>For security reasons, it will be confirmed that your email is loaded in the University Database</h5> 
               
          </form>
     </div>
</main>
<br><br><br>
</body>