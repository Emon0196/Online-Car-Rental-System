<?php
  session_start();
  include('inc/config.php');
  include('inc/checklogin.php');
  check_login();
  //hold logged in user session.
  $a_id = $_SESSION['a_id'];
  //register staff
  
		if(isset($_POST['book_car']))
		{
            $a_id = $_SESSION['a_id'];
            $cc_id = $_GET['cc_id'];
            $car_id  = $_GET['car_id'];
            $car_name  = $_POST['car_name'];
            $car_type = $_POST['car_type'];
            $car_regno = $_GET['car_regno'];
            $b_duration = $_POST['b_duration'];
            $c_name = $_POST['c_name'];
            $c_natidno =$_POST['c_natidno'];
            $c_phone = $_POST['c_phone'];
            $b_number = $_POST['b_number'];
            $car_price = $_POST['car_price'];

            $query="INSERT INTO bookings (a_id, cc_id, car_id, car_name, car_type, car_regno, b_duration, c_name, c_natidno, c_phone, b_number, car_price) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $mysqli->prepare($query);
            $rc=$stmt->bind_param('ssssssssssss',$a_id, $cc_id, $car_id, $car_name, $car_type, $car_regno, $b_duration, $c_name, $c_natidno, $c_phone, $b_number, $car_price);
            $stmt->execute();

            if($stmt)
            {
                      $success = "Car Hiring Request Submitted";
                      
                      //echo "<script>toastr.success('Have Fun')</script>";
            }
            else {
              $err = "Please Try Again Or Try Later";
            }
			
			
		}
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
        <?php
                            
            $car_id = $_GET['car_id'];
            $ret="SELECT  * FROM  car_list  WHERE car_id=?";
            $stmt= $mysqli->prepare($ret) ;
            $stmt->bind_param('i',$car_id);
            $stmt->execute() ;//ok
            $res=$stmt->get_result();
            //$cnt=1;
            while($row=$res->fetch_object())
            {
        ?>
        <div class="row">
            <div class="card col-md-12">
                <h2 class="card-header">Hire  <?php echo $row->car_name;?></h2>
                <div class="card-body">
                    <!--Form-->
                    <form method="post" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Car Name</label>
                                <input type="text" required readonly name="car_name" value="<?php echo $row->car_name;?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Car Type</label>
                                <input type="text" required readonly name="car_type" value="<?php echo $row->car_type;?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Car Registration Number</label>
                                <input type="text" required readonly name="car_regno" value="<?php echo $row->car_regno;?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>

                            <div class="form-group col-md-6" style="display:none">
                                <label for="exampleInputEmail1">Booking Numbe</label>
                                    <?php 
                                        $length = 4;    
                                        $alph_num =  substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
                                        $num =  substr(str_shuffle('0123456789'),1,$length);

                                    ?>
                                <input type="text" required name="b_number" value="CRMS-B-<?php echo $alph_num;?>-<?php echo $num;?> " class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                            
                        </div>
                       
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Hiring  Duration (Maximum 7 Days)</label>
                                <select class="form-control" name="b_duration">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Car Price Per Day</label>
                                <input type="text" required readonly name="car_price" value="<?php echo $row->car_price;?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                            <?php }?>
                            <?php
                            
                                $a_id = $_SESSION['a_id'];
                                $ret="SELECT  * FROM  admins  WHERE a_id=?";
                                $stmt= $mysqli->prepare($ret) ;
                                $stmt->bind_param('i',$a_id);
                                $stmt->execute() ;//ok
                                $res=$stmt->get_result();
                                //$cnt=1;
                                while($row=$res->fetch_object())
                                {
                            ?>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Client Name</label>
                                <input type="text" value="<?php echo $row->a_name;?>" required name="c_name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>

                            
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Client Phone Number</label>
                                <input type="text" required name="c_phone" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Client ID Number</label>
                                <input type="text"  required name="c_natidno" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>

                        </div> 
                        <?php }?>
                        <button type="submit" name="book_car" class="btn btn-outline-success">Hire Car</button>
                    </form>
                    <!-- ./ Form -->
                </div>    
            </div>
        </div>
      <!-- Footer -->
        <?php include("inc/footer.php");?>      
    </div>
  </div>
 
  <script src="assets/js/canvasjs.min.js"></script>
  <script src="assets/js/plugins/jquery/dist/jquery.min.js"></script>
  <script src="assets/js/plugins/jquery/dist/jquery.min.js"></script>
  <script src="assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!--   Optional JS   -->
  <script src="assets/js/plugins/chart.js/dist/Chart.min.js"></script>
  <script src="assets/js/plugins/chart.js/dist/Chart.extension.js"></script>
  <!--   Argon JS   -->
  <script src="assets/js/argon-dashboard.min.js?v=1.1.2"></script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script>
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "argon-dashboard-free"
      });
  </script>
</body>

</html>