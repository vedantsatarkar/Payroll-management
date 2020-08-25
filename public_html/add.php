<?php
require_once "pdo.php";
session_start();

if(!isset($_SESSION['user_id'])){
	die("ACCESS DENIED!");
}

if(isset($_POST['cancel'])){
	header('Location: main.php');
	return;
}

$error=false;
if(isset($_SESSION['error'])){
	$error=htmlentities($_SESSION['error']);
	unset($_SESSION['error']);
}

if(isset($_POST['newempadd'])){
	
	//masterdata insertion
$stmt=$pdo->prepare	('INSERT INTO masterdata( name, perm_addr, temp_addr, phone_no, pan_no, esi_no, pf_no, joining, birth) VALUES (:name,:perm_addr,:temp_addr,:phone_no,:pan_no,:esi_no,:pf_no,:joining,:birth)');
$joindate=date("Y-m-d", strtotime($_POST['newempjoindate']));
$empbirthdate=date("Y-m-d", strtotime($_POST['newempdob']));

$stmt->execute(array(
               ':name'=>$_POST['newempname'],
               ':perm_addr'=>$_POST['newempperaddress'],
               ':temp_addr'=>$_POST['newemptempaddress'],
               ':phone_no'=>$_POST['newempphone'],
               ':pan_no'=>$_POST['newemppan'],
               ':esi_no'=>$_POST['newempesi'],
               ':pf_no'=>$_POST['newemppf'],
               ':joining'=>$joindate,
               ':birth'=>$empbirthdate
                ));

    $empname=$_POST['newempname'];
			
	$temp=$pdo->prepare("SELECT employee_id FROM masterdata WHERE name=:empname");
	$temp->execute(array(":empname"=>$empname));
	$inputid=$temp->fetch(PDO::FETCH_ASSOC);
	$empid=$inputid['employee_id'];
	
	//inputdata insertion		
	$stmt2=$pdo->prepare('INSERT INTO inputdata(gross, basic, certif,medallow,employee_id) VALUES (:gross,:basic,:certif,:medallow,:empid)');
	$stmt2->execute(array(
	    ':gross'=>$_POST['newempgross'],
	    ':basic'=>$_POST['newempbas'],
	    ':certif'=>$_POST['newempcert'],
	    ':medallow'=>$_POST['newempmed'],
	    ':empid'=>$empid
	    ));
	header('Location: add.php');
	return;
}
//preview table display

$stmt3=$pdo->query("SELECT employee_id,name,resignation FROM masterdata" );
$pre=$stmt3->fetchALL(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html>
	<head>
		<title>Add Employee</title>
		 <meta charset="utf-8">
		 <link href='https://fonts.googleapis.com/css?family=Playfair Display' rel='stylesheet'>
         <meta name="viewport" content="width=device-width, initial-scale=1">
		 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		 <script src="https://code.jquery.com/jquery-3.5.1.slim.js" integrity="sha256-DrT5NfxfbHvMHux31Lkhxg42LY6of8TaYyK50jnxRnM=" crossorigin="anonymous"></script>
		 <link rel="stylesheet" type="text/css" href="css/add.css">
		 <link rel="stylesheet" type="text/css" href="css/navbar.css">

	</head>
	<body style="background-color:#e3f6f5">
	    
	<?php
	    require_once "navbar.php"
	    ?>
			<h2 id="heading">New employee starting <?= date('F')." ".date('Y'); ?></h2>
			<?php 
			echo('<p style="color:red">'.$error.'</p>');
			?>
			<div id="div1" class="container" >

			<form>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Email</label>
      <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Password</label>
      <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
    </div>
  </div>
  <div class="form-group">
    <label for="inputAddress">Address</label>
    <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
  </div>
  <div class="form-group">
    <label for="inputAddress2">Address 2</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">City</label>
      <input type="text" class="form-control" id="inputCity">
    </div>
    <div class="form-group col-md-4">
      <label for="inputState">State</label>
      <select id="inputState" class="form-control">
        <option selected>Choose...</option>
        <option>...</option>
      </select>
    </div>
    <div class="form-group col-md-2">
      <label for="inputZip">Zip</label>
      <input type="text" class="form-control" id="inputZip">
    </div>
  </div>
  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
        Check me out
      </label>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Sign in</button>
</form>	

			<form method="post" class="addform">
			    <ul style="list-style-type:none;">
				<li>Name: <input type="text" name="newempname" required></li>
				<li>Permanent Address: <textarea class="textarea" name="newempperaddress" required></textarea></li>
				<li>Temporary Address: <textarea class="textarea" name="newemptempaddress" required></textarea></li>
				<li>Pan Card Number:<input type="text" id="newemppan" name="newemppan" required>
				    ESI Number:<input type="text" id="newempesi" name="newempesi" required>
				</li>
				<li>PF Number:<input type="text" id="newemppf" name="newemppf" required>
				   Phone Number: <input type="tel" id="newempphone" name="newempphone" pattern="[789][0-9]{9}" required ></li>
				
				
				<li>Date of Joining:<input type="date" id="newempjoindate" name="newempjoindate" placeholder="dd-mm-yyyy" pattern="\d{1,2}-\d{1,2}-\d{4}" required>
				    Date of Birth:<input type="date" id="newempdob" name="newempdob" placeholder="dd-mm-yyyy" pattern="\d{1,2}-\d{1,2}-\d{4}" required >
				</li>
				<li>Gross Salary: <input type="number" id="newempgross" name="newempgross" required>
				    Basic: <input type="number" id="newempbas" name="newempbas" required>
				</li>
				<li>Certification Charges(If any): <input type="number" id="newempcert" name="newempcert" required> 
				    Medical Allowance:<input type="number" id="newempmed" name="newempmed" required>
			    </li>
				</ul>
				<p><button  type="submit" name="newempadd" class="button btn btn-primary btn-lg" value="Add"> Add</button> <button  type="submit" class="button btn btn-primary btn-lg"  name="cancel" value="Cancel">Cancel</button></p>
 			</form>
		</div>
		</br></br></br>
		
		    <!-- Preview table container-->
		    <table id="eddel" >
		        <?php
		        echo"<tr><th>Options</th>";
		        echo"<th>Name</th></tr>";
		        foreach($pre as $row)
		        { 
		            if($row['resignation'])
		        {
		            continue;
		        }
		          echo"<tr><td>";
		          echo('<a href="edit.php?user_id='.$row['employee_id'].'">Edit/</a>');
                  echo('<a href="delete.php?user_id='.$row['employee_id'].'">Delete</a></li>');
                  echo"</td><td>";
                  $pretabname=$row['name'];
                  echo"$pretabname";
                  echo"<input type='hidden' name='emp_name' value='$pretabname'/>";
                  echo"</td></tr>";
                }
		        ?>
		    </table>  
		    </br></br>
	</body>
</html>