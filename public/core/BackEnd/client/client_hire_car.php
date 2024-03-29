<?php
  session_start();
  include('inc/config.php');
  include('inc/checklogin.php');
  check_login();
  //hold logged in user session.
  $c_id = $_SESSION['c_id'];
  
?>

<!DOCTYPE html>
<html lang="en">

<?php include("inc/head.php");?>

<body class="">
 <!--Sidebar-->
 <?php include("inc/sidebar.php");?>
  
  <div class="main-content">
    <!-- Navbar -->
   <?php include("inc/nav.php");?>
    <!-- End Navbar -->
    <!-- Header -->
    <div class="header  pb-8 pt-5 pt-md-8" style="min-height: 300px; background-image: url(../../img/header-bg.jpg); background-size: cover; background-position: center top;">
        <span class="mask bg-gradient-default opacity-5"></span>
    </div>

    <div class="container-fluid mt--7">
        <!--Pie chart to show number of car categories-->
        <div class="row">
            <div class="card col-md-12">
                <h2 class="card-header">Select Any Car Of Your Intrest To Book It</h2>
                <div class="card-body">
                    <div class="table-responsive">
                    <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">RegNo.</th>
                                <th scope="col">Category</th>
                                <th scope="col">Availability</th>
                                <th scope="col">Action<th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            //get details of all cars
                                    $ret="SELECT * FROM car_list  ORDER BY RAND() "; 
                                    $stmt= $mysqli->prepare($ret) ;
                                    $stmt->execute() ;//ok
                                    $res=$stmt->get_result();
                                    $cnt=1;
                                    while($row=$res->fetch_object())
                                    {
                            ?>
                                <tr>
                                <th scope="row">
                                    <?php echo $cnt;?>
                                </th>
                                <td>
                                    <?php echo $row->car_name;?>
                                </td>
                                <td>
                                    <?php echo $row->car_regno;?>
                                </td>
                                
                                <td>
                                    <?php echo $row->car_type;?>
                                </td>
                                
                                <td>
                                    <?php 
                                        if($row->car_status == 'Available')
                                        {
                                            echo '<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            echo '<span class="badge badge-danger">Hired</span>';
                                        }
                                    ?>
                                </td>

                                <td>
                                    <?php 
                                        if($row->car_status == 'Available')
                                        {
                                            echo 
                                                "
                                                    <a href  ='client_book_car.php?car_id=$row->car_id&car_regno=$row->car_regno&cc_id=$row->car_cat_id' class='badge badge-success'>
                                                        <i class='fas fa-business-time'></i> <i class='fa fa-car'></i>
                                                            Hire
                                                    </a>

                                                 ";
                                        }
                                        else
                                        {
                                            echo '<span class="badge badge-danger">Already Hired!</span>';
                                        }
                                    ?>
                                </td>
                                </tr>
                            <?php $cnt = 1+$cnt; }?>
                            </tbody>
                        </table>
                    </div>
                </div>    
            </div>
        </div>
      <!-- Footer -->
        <?php include("inc/footer.php");?>      
    </div>
  </div>
 

</body>

</html>