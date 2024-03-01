
<?php include 'head.php'?>


           
<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>PWD | Job & Fund Allocation</title>

    <!-- <link href="css3/bootstrap.min.css" rel="stylesheet"> -->
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Morris -->
    <link href="css3/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="js3/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="css3/animate.css" rel="stylesheet">
    <link href="css3/style.css" rel="stylesheet">
<!-- <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png"> -->

<style type="text/css">

.style1 {color: #000000}
.style2 {color: #FF0000}

body {
/*    margin: 30PX;*/
</style>
</head>


 <body>

    <?php include 'header.php'?>
    <?php include 'menu.php'?>
   
   <div class="container mt-5">
        
        <div class="row">
                <?php 


  
                  $sql = "SELECT * FROM mytasks WHERE user_id = " . $_SESSION['user_id'];
                  $cnt = 1;
                  $que = mysqli_query($conn,$sql);
                  
                  while ($result = mysqli_fetch_assoc($que)) {
                    
                  ?>            
        
                   
                        <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                              <h5><span class="label label-success pull-right">My Tasks</span>
</h5>
                            </div>
                            
                            <div class="ibox-content">
                               
                               <?php
                                $query = "SELECT * FROM mytasks WHERE user_id = " . $_SESSION['user_id']; 
                                $team = mysqli_query($conn, $query); 

                                if ($team) 
                                { 
                                 // it return number of rows in the table. 
                                 $row_teams = mysqli_num_rows($team); 
                                   
                                }

                                ?>
                                <?php  echo $row_teams;   ?>
                                <small> </small> 
                          </div>
                        </div>
                    </div>             
                    
                
<div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                              <h5><span class="label label-primary pull-right">Claimed Tasks</span>
</h5>
                            </div>
                            
                            <div class="ibox-content">
                                 <?php
                                $query = "SELECT * FROM mytasks WHERE application_status = 1"; 
                                $team = mysqli_query($conn, $query); 

                                if ($team) 
                                { 
                                 // it return number of rows in the table. 
                                 $row_teams = mysqli_num_rows($team); 
                                   
                                }

                                ?>
                                <?php  echo $row_teams;   ?>
                                <small> </small> 
                          </div>
                        </div>
                    </div>  

                                             <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                              <h5><span class="label label-secondary pull-right">Completed Tasks</span>
</h5>
                            </div>
                            
                                <div class="ibox-content">
                                   <?php
                                $query = "SELECT * FROM mytasks WHERE completion_status = 1"; 
                                $team = mysqli_query($conn, $query); 

                                if ($team) 
                                { 
                                 // it return number of rows in the table. 
                                 $row_teams = mysqli_num_rows($team); 
                                   
                                }

                                ?>
                                <?php  echo $row_teams;   ?>
                                    <small> </small> 
                              </div>
                        </div>
                    </div> 
                   
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                              <h5><span class="label label-info pull-right">Paid Tasks</span>
</h5>
                            </div>
                            
                          <div class="ibox-content">
                                <?php
                                $query = "SELECT * FROM mytasks WHERE payment_status = 1"; 
                                $team = mysqli_query($conn, $query); 

                                if ($team) 
                                { 
                                 // it return number of rows in the table. 
                                 $row_teams = mysqli_num_rows($team); 
                                   
                                }

                                ?>
                                <?php  echo $row_teams;   ?>

                              
                             </div>
                        </div>
                    </div>    

                   
                
 
        <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-hover no-margins">
                            <thead>
                                <tr>
                                    <th width="30%">
                                        <div align="center"><span class="style1">Pending Payments</span></div>
                                    </th>
                                    <th width="30%">
                                        <div align="center"><span class="style1">Pending Tasks</span></div>
                                    </th>
                                    <th width="63%">
                                        <div align="center"><span class="style1">To be Claimed</span></div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                        <tr>
                        
                       <td>
                         <?php
                                $query = "SELECT * FROM mytasks WHERE payment_status = 0"; 
                                $team = mysqli_query($conn, $query); 

                                if ($team) 
                                { 
                                 // it return number of rows in the table. 
                                 $row_teams = mysqli_num_rows($team); 
                                   
                                }

                                ?>
                                <?php  echo $row_teams;   ?>
                     </td>
                        
                      <td>
                         <?php
                                $query = "SELECT * FROM mytasks WHERE completion_status = 0"; 
                                $team = mysqli_query($conn, $query); 

                                if ($team) 
                                { 
                                 // it return number of rows in the table. 
                                 $row_teams = mysqli_num_rows($team); 
                                   
                                }

                                ?>
                                <?php  echo $row_teams;   ?>
                     </td>
                        
                        
                         <td>
                         <?php
                                $query = "SELECT * FROM mytasks WHERE application_status = 0"; 
                                $team = mysqli_query($conn, $query); 

                                if ($team) 
                                { 
                                 // it return number of rows in the table. 
                                 $row_teams = mysqli_num_rows($team); 
                                   
                                }

                                ?>
                                <?php  echo $row_teams;   ?>
                        </td>
                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

             <?php 
                }

              ?>
            <!-- <p align="center"></p>
            <div class="row">&nbsp; </p>
          </div>
          </div> -->
            <?php include('footer_bar.php'); ?>

          </div>

</body>
</html>
