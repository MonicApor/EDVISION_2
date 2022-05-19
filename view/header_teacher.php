<?php error_reporting (E_ALL ^ E_NOTICE); ?>

<body class="hold-transition skin-green sidebar-mini" >
<div class="wrapper">
  <header class="main-header" >
    <!-- Logo -->
    <a href="" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><strong>EDV</strong></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><strong>EDVISION </strong></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
       		<span class="sr-only">Toggle navigation</span>
       	</a>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
            
              <!-- Notifications: style can be found in dropdown.less -->
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
<?php
include_once('../controller/config.php');
$my_type=$_SESSION["type"];
$my_index=$_SESSION["index_number"];

if($my_type == 'Teacher'){
	
	$sql1="SELECT COUNT(id) FROM notification_history WHERE user_type='Teacher' AND index_number='$my_index' AND _isread='0'";
	$result1=mysqli_query($conn,$sql1);
	$row1=mysqli_fetch_assoc($result1);
	$notfi_count=$row1['COUNT(id)'];
	
?>
                  <span class="label label-warning"><?php echo $notfi_count; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have <?php echo $notfi_count; ?> notifications</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
<?php
include_once('../controller/config.php');

$sql="SELECT * FROM notification_history WHERE user_type='Teacher' AND index_number='$my_index' ORDER BY id DESC";
$result=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($result)){
	
	$notification_id=$row['notification_id'];
	
	$sql1="SELECT * FROM events WHERE id='$notification_id'";
	$result1=mysqli_query($conn,$sql1);
	$row1=mysqli_fetch_assoc($result1);
	$title1=$row1['title'];
		
		
	echo '<li>
            <a href="#" onClick="showNotifyEvent('.$notification_id.')">
               <i class="fa fa-users text-aqua"></i> You have new event - '.$title1.'
            </a>
         </li>
                      
          ';

}

?>
					</ul>
                  </li>
                  <li class="footer"><a href="#" onClick="viewAllNotifi()">View all</a></li>
                </ul>
              </li>
<?php }  ?>           
           
<script>
var count = 0;

function viewAllNotifi(){
	
	var xhttp = new XMLHttpRequest();//MSK-00149-Start Ajax  
  		xhttp.onreadystatechange = function() {
    		if (this.readyState == 4 && this.status == 200) {
				
				document.getElementById('viewAllNotification').innerHTML = this.responseText;
				$('#modalviewAllNotifications').modal('show');
				count++;
				
    		}
			
  		};	
		
    	xhttp.open("GET", "all_notifications.php", true);												
  		xhttp.send();
}

function viewNotifications(std_index,due_month,due_year,notifications_id){
	
	$("#modalviewAllNotifications").modal('hide');
	
	var xhttp = new XMLHttpRequest();//MSK-00149-Start Ajax  
  		xhttp.onreadystatechange = function() {
    		if (this.readyState == 4 && this.status == 200) {
				
				document.getElementById('viewDuePayment').innerHTML = this.responseText;
				$('#modalviewDuePayment').modal('show');
				
				notifiRead(notifications_id);
    		}
			
  		};	
		
    	xhttp.open("GET", "student_due_payment.php?std_index=" + std_index +"&due_month="+due_month +"&due_year="+due_year, true);												
  		xhttp.send();
	
}

function showNotifyEvent(event_id){
	
	$("#modalviewAllNotifications").modal('hide');
	var xhttp = new XMLHttpRequest();//MSK-00105-Ajax Start  
		xhttp.onreadystatechange = function() {
				
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById('showEvent2').innerHTML = this.responseText;//MSK-000132
				$('#modalviewEvent5').modal('show');
				notifiRead(event_id);
			}
				
		};	
		
		xhttp.open("GET", "show_events2.php?event_id="+event_id , true);												
		xhttp.send();//MSK-00105-Ajax End
};

function showAllNotfi1(){
	
	if(count > 0){
		viewAllNotifi();
	}
	
}

function countEquel0(){
	
	count = count-count;
	
}
 
</script>           
                   
<!-- Notifications -->              

<?php 

$my_index=$_SESSION["index_number"];
$my_type=$_SESSION["type"];

?>

<?php
include_once('../controller/config.php');

if($my_type=="Student"){
	$sql="SELECT * FROM student where index_number='$my_index'";
	$result=mysqli_query($conn,$sql);
	$row=mysqli_fetch_assoc($result);
}

if($my_type=="Teacher"){
	$sql="SELECT * FROM teacher where index_number='$my_index'";
	$result=mysqli_query($conn,$sql);
	$row=mysqli_fetch_assoc($result);	
}

if($my_type=="Admin"){
	$sql="SELECT * FROM admin where index_number='$my_index'";
	$result=mysqli_query($conn,$sql);
	$row=mysqli_fetch_assoc($result);	
}

?> 

                <!-- User Account: style can be found in dropdown.less -->
            	<li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <img src="../<?php echo $row['image_name']; ?>" class="user-image" alt="User Image">
                      <span class="hidden-xs"><?php echo $row['i_name']; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                      <!-- User image -->
                      <li class="user-header">
                        <img src="../<?php echo $row['image_name']; ?>" class="img-circle" alt="User Image">
        
                        <p>
                          <?php echo $row['i_name']; ?> - <?php echo $my_type; ?>
                          <?php
                          		$date = strtotime($row['reg_date']);
                                echo '<small>'."Member since ".date('M'.'.'.' Y', $date).'</small>';
                           ?>
                        </p>
                      </li>
                      <!-- Menu Body -->
                      
                      <!-- Menu Footer-->
                      <li class="user-footer">
                        <div class="pull-left">
                          <a href="#" class="btn btn-default btn-flat">Profile</a>
                        </div>
                        <div class="pull-right">
                          <a href="login.php" class="btn btn-default btn-flat">Sign out</a>
                        </div>
                      </li>
                    </ul>
              </li>
            </ul> 
        </div>
	</nav>
  </header>
  
    
<style>
.msk-fade {  
      
    -webkit-animation-name: animatetop;
    -webkit-animation-duration: 0.4s;
    animation-name: animatetop;
    animation-duration: 0.4s

}  
  /* Add Animation */
@-webkit-keyframes animatetop {
    from {top:-300px; opacity:0} 
    to {top:0; opacity:1}
}

@keyframes animatetop {
    from {top:-300px; opacity:0}
    to {top:0; opacity:1}
}

</style>