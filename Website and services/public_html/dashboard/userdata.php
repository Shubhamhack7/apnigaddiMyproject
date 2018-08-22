<?php
session_start();
if(empty($_SESSION['id']) && empty($_SESSION['user']))
{
			header('Location: ../index.html');
			die();
}
else
{
    
	include 'connection.php';
    $uid = $_GET['uid'];
    $sql = "SELECT * FROM user_data WHERE UID = '$uid'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if(isset($_POST['verify']))
    {
        $iid = $_POST['id'];
        $sql1 = "UPDATE user_data SET USER_VERIFY='1' WHERE UID='$iid'";
        $conn->query($sql1);
        header('Location: ./data.php');
    }
    if(isset($_POST['block']))
    {
        $iid = $_POST['id'];
        $sql1 = "UPDATE user_data SET USER_VERIFY='0' WHERE UID='$iid'";
        $conn->query($sql1);
        header('Location: ./data.php');
    }
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Admin Panel</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="assets/css/paper-dashboard.css" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />

    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/themify-icons.css" rel="stylesheet">

</head>
<body>

<div class="wrapper">
	<div class="sidebar" data-background-color="white" data-active-color="danger">

    <!--
		Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
		Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
	-->

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="dashboard.php" class="simple-text">
                    Admin Panel
                </a>
            </div>

            <ul class="nav">
                <li>
                    <a href="dashboard.php">
                        <i class="ti-panel"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
              <!--  <li>
                    <a href="user.html">
                        <i class="ti-user"></i>
                        <p>User Profile</p>
                    </a>
                </li>-->
                <li class="active">
                    <a href="data.php">
                        <i class="ti-view-list-alt"></i>
                        <p>Table List</p>
                    </a>
                </li>
 <!--               <li>
                    <a href="typography.html">
                        <i class="ti-text"></i>
                        <p>Typography</p>
                    </a>
                </li>-->
 <!--               <li>
                    <a href="icons.html">
                        <i class="ti-pencil-alt2"></i>
                        <p>Icons</p>
                    </a>
                </li>-->
                <li>
                    <a href="maps.php">
                        <i class="ti-map"></i>
                        <p>Maps</p>
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <i class="ti-user"></i>
                        <p>Logout</p>
                    </a>
                </li>
 <!--               <li>
                    <a href="notifications.html">
                        <i class="ti-bell"></i>
                        <p>Notifications</p>
                    </a>
                </li>-->
            </ul>
    	</div>
    </div>

    <div class="main-panel">
		<nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <a class="navbar-brand" href="data.php">User List</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                              <a href="https://resident.uidai.gov.in/aadhaarverification" target="_blank">
                                    <i class="ti-check"></i>
									<p>For Verify</p>
                              </a>
                              
                        </li>
                    </ul>

                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Users profile </h4>
                                <p class="category"></p>
                            </div>
                            
                            <div class="content table-responsive table-full-width">
                                <table class="table table-striped">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
   
   
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo $row['FULLNAME'];?></h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> </div>
            
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>UID:</td>
                        <td><?php echo $row['UID'];?></td>
                      </tr>
                      <tr>
                        <td>User Name:</td>
                        <td><?php echo $row['USERNAME'];?></td>
                      </tr>
                      <tr>
                        <td>Gender:</td>
                        <td><?php echo $row['GENDER'];?></td>
                      </tr>
                      <tr>
                        <td>Email:</td>
                        <td><?php echo $row['EMAIL'];?>
                        
                                            <?php
                                            if($row['EMAIL_VERIFY'] == 1)
                                            {
                                                ?>
                                            <img src="./assets/icons/check.png" width="18" height="18">
                                            <?php
                                                }
                                            else
                                                {
                                                ?>
                                            <img src="./assets/icons/cross.png" width="18" height="18">
                                            <?php
                                            }
                                            ?>
                                            </td>
                      </tr>
                     <tr>
                        <td>Phone Number:</td>
                        <td><?php echo $row['PHONENO'];?>
                        
                        <?php
                        if($row['PHONE_VERIFY'] == 1)
                        {
                            ?>
                        <img src="./assets/icons/check.png" width="18" height="18">
                        <?php
                            }
                        else
                            {
                            ?>
                        <img src="./assets/icons/cross.png" width="18" height="18">
                        <?php
                        }
                        ?>
                        </td>
                      </tr>
                      <tr>
                        <td>IP Address:</td>
                        <td><?php echo $row['IPADDRESS'];?></td>
                      </tr>
                      <tr>
                        <td>Adhar Number</td>
                        <td><?php echo $row['ADHAR_NO'];?></td>
                      </tr>
                      <tr>
                        <td>User Staus</td>
                        <td>
                        <?php
                        if($row['USER_VERIFY'] == 1)
                        {
                            ?>
                        Verified <img src="./assets/icons/check.png" width="18" height="18">
                        <?php
                            }
                        else
                            {
                            ?>
                        Not Verified <img src="./assets/icons/cross.png" width="18" height="18">
                        <?php
                        }
                        ?>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <form method="POST" action="userdata.php">
                <input type="hidden" name="id" value="<?php echo $row['UID']; ?>" >
                  <input type="submit"  name="verify" value="Verified" class="btn btn-primary">
                  <input type="submit"  name="block" value="Block" class="btn btn-primary">
                </div>
              </div>
            </div>
            
          </div>
        </div>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid">
				<div class="copyright pull-right">
                    &copy; Admin panel, made with Myidea</a>
                </div>
            </div>
        </footer>


    </div>
</div>


</body>

    <!--   Core JS Files   -->
    <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="assets/js/bootstrap-checkbox-radio.js"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
	<script src="assets/js/paper-dashboard.js"></script>

	<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>


</html>
