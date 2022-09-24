<?php

use Utils\Utils;

Utils::checkNav();


?>
<script type="text/javascript">
    function confirmDelete() {
        var answer = confirm("Are you sure of the elimination?");
    }
    if (answer == true) {

        return true;
    } else {

        return false;
    }
  
</script>
<?php 
if (isset($controlScript)) {

?>
          <script>
               alert('<?php echo $message ?>')
          </script>
<?php
     
}
?>
<main class="py-5">
    <section id="listado" class="mb-5">

        <div class="container">
            <h2 class="mb-4">Companies List</h2>
            <div class="container" style="width: 5500; height: 400px; overflow-y: scroll;">
                <div class="container" position="fixed">
                    <form action="<?php echo FRONT_ROOT ?>Company/ShowCompaniesViews" method="GET" enctype="multipart/form-data">

                        <input type="text" name="search" class="form-control form-control-ml" required value="">

                        <button type="submit" class="btn btn-dark ml-auto d-block">Search</button>
                    </form>
                </div>
                <table class="table bg-light-alpha">
                    <div class="container" position="fixed">
                    <thead>
                
                        <th class="header" scope="col" position="sticky">Name</th>
                        <th class="header" scope="col" position="sticky">City</th>
                        <!-- <th>yearFoundation</th> -->
                        <!-- <th>Description</th>   -->
                        <th class="header" scope="col" position="sticky">Email</th>
                        <th class="header" scope="col" position="sticky"></th>
                        <th class="header" scope="col" position="sticky"></th>
                        <th class="header" scope="col" position="sticky"></th>
                        <th class="header" scope="col" position="sticky"></th>
                        <th class="header" scope="col" position="sticky"></th>

                        
                    </thead>
                    </div>
                    <tbody>
                   
                        <?php
                                                      
                        if ($this->companiesList !=NULL) {
                            foreach ($this->companiesList as $company) {
                                //var_dump($company->getCompanyId());
                                
                                echo "<tr>";
           
                                echo  "<td>" . $company->getName() . "</td>";
                                echo  "<td>" . $company->getCity() . "</td>";
                                echo  "<td>" . $company->getEmail() . "</td>";
           
                            

                                //echo "<td> <img height='50px' width='50px' src=".base64_encode( $company->getLogo())."> </td>";  
                                // echo '<td><img src="'.$company->getLogo().'" alt="Logo sera" style="width:128px;height:128px"></td>'; 
                        
                                if (isset($_SESSION["admin"])) {
                                    
                                    $companyId = $company->getCompanyId();
                                    echo "<div class='row'>";
                                    echo "<div class='button-conteiner'>";
                                    echo "<td><a href=" . FRONT_ROOT . "Company/deleteCompany/" . $company->getCompanyId() . ">
                                <button type='button' class= 'btn btn-danger' >Delete</button></a></td>";
                                    echo "</div>";
                                    echo "</div>";

                                    echo "<div class='row'>";
                                    echo  "<div class='button-conteiner'>";
                                    echo "<td><a href=" . FRONT_ROOT . "Company/ShowModifyCompanyView/" . $company->getCompanyId() . ">
                                 <button type='button' class= 'btn btn-success' >Modify</button></a></td>";
                                    echo "</div>";
                                    echo "</div>";

                                    echo "<div class='row'>";
                                    echo  "<div class='button-conteiner'>";
                                    echo "<td><a href=" . FRONT_ROOT . "jobOffer/showAddjobOfferForCompany/" . $company->getCompanyId() . ">
                                 <button type='button' class= 'btn btn-info' >Add Job Offer</button></a></td>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                                
                                echo "<div class='row'>";
                                echo  "<div class='button-conteiner'>";
                                echo "<td><a href=" . FRONT_ROOT . "JobOffer/showJobsOffersViewByCompany/" . $company->getCompanyId() . ">
                                  <button type='button' class= 'btn btn-info' > Job Offers</button></a></td>";
                                echo "</div>";
                                echo "</div>";
                            }
                        }else{
                            echo "The companies list is empty";
                        }
                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
        </form>
    </section>
    
</main>
<br>
