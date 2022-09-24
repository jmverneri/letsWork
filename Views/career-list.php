<?php

use Utils\Utils;

Utils::checkNav();
?>

<main class="py-5">
    <section id="listado" class="mb-5">

        <div class="container">
            <h2 class="mb-4">Careers List</h2>
            <div class="container" style="width: 2000px; height: 400px; overflow-y: scroll;">
                <div class="container" position="fixed">  
                    <form action="<?php echo FRONT_ROOT ?>Career/ShowCareerList" method="POST" enctype="multipart/form-data">

                        <input type="text" name="search" class="form-control form-control-ml" required value="">

                        <button type="submit" class="btn btn-dark ml-auto d-block">Search</button>
                    </form>
                </div>
                <table class="table bg-light-alpha">
                    <thead>
                        
                        <th class="header" scope="col" position="sticky">Description</th>
                     
                    </thead>
                    <tbody>
                   
                        <?php
                         
                            
                        if ($this->careerList !=NULL) {
                            foreach ($this->careerList as $career) {
                                echo "<tr>";
                                echo  "<td>" . $career->getDescription() . "</td>";
                                                          
                               
                                echo "<div class='row'>";
                                echo  "<div class='button-conteiner'>";
                                echo "<td><a href=" . FRONT_ROOT . "JobOffer/showJobsOffersViewByCareer/" . $career->getCareerId() . ">
                                  <button type='button' class= 'btn btn-info' > Job Offers</button></a></td>";
                                echo "</div>";
                                echo "</div>";
                            }
                        }else{
                            echo "The career list is empty";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        </form>
    </section>
    <br>
</main>