<?php
require_once 'pdo.php';

session_start();

if(!isset($_SESSION['user_id'])){
	die("ACCESS DENIED!");
}

if(isset($_POST['cancel'])){
	header('Location: main.php');
	return;
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['user_id']) ) {
	$_SESSION['error'] = "Missing User id";
	header('Location: index.php');
  	return;
}

if(isset($_POST['emp_name']) || isset($_POST['employee_id'])){
    if(strlen($_POST['emp_name'])<1 ){
        $_SESSION['error'] = 'Bad Data';
        header("Location: edit.php?user_id=".$_POST['employee_id']);
        return;
        }
        $sql = "UPDATE masterdata SET name = :name,perm_addr=:perm_addr,temp_addr=:temp_addr,phone_no=:phone_no WHERE employee_id = :employee_id";
             
    $stmt=$pdo->prepare($sql);
    $stmt->execute(array(
      ':name'=>$_POST['emp_name'],
      ':perm_addr'=>$_POST['empperaddress'],
      ':temp_addr'=>$_POST['emptempaddress'],
      ':phone_no'=>$_POST['empphone'],
      ':employee_id'=>$_POST['employee_id']));
      $_SESSION['success']="Record Updated";
      header('Location:add.php');
      return;
    }

    $stmt = $pdo->prepare("SELECT name,employee_id,perm_addr,temp_addr,phone_no FROM masterdata where employee_id = :xyz");
    $stmt->execute(array(":xyz" => $_GET['user_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ( $row === false ) {
        $_SESSION['error'] = 'Bad value for employee id';
        header( 'Location: edit.php' ) ;
        return;
    }

    // Flash pattern
    if ( isset($_SESSION['error']) ) {
        echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }

    $n=htmlentities($row['name']);
    $permanent_add=htmlentities($row['perm_addr']);
    $temp_add=htmlentities($row['temp_addr']);
    $telno=htmlentities($row['phone_no']);
    $employee_id = $row['employee_id'];
 ?>

<!DOCTYPE html>
    <html>
       <?php
       require_once"navbar.php";
       ?>
        <head>
             <meta charset="utf-8">
             <meta name="viewport" content="width=device-width, initial-scale=1">
		     <link href='https://fonts.googleapis.com/css?family=Playfair Display' rel='stylesheet'>
		     <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
             <link rel="stylesheet" type="text/css" href="css/navbar.css">
		     <link rel="stylesheet" href="css/edit.css">
		     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		    <script src="https://code.jquery.com/jquery-3.5.1.slim.js" integrity="sha256-DrT5NfxfbHvMHux31Lkhxg42LY6of8TaYyK50jnxRnM=" crossorigin="anonymous"></script>
        </head>
    <body style="background-color:#e3f6f5">
        
         <h1 class="heading"> Change Employee Records</h1>
         </br>
        <div id="div1" class="container">
        <form method="post" class="addform">
            Name: <input type="text" name="emp_name" value="<?=$n ?>"/>
            <br/>
            <p>Permanent Address: <textarea class="textarea" name="empperaddress" required value=<?=$permanent_add?>></textarea></p>
				<p>Temporary Address: <textarea class="textarea" name="emptempaddress" required value="<?=$temp_add ?>"></textarea></p>
				<p>Phone Number: <input type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required name="empphone" value="<?=$telno ?>" ></p>
				<!--<p>Pan Card Number:<input type="text" name="emppan"></p>
				<p> ESI Number:<input type="text" name="empesi"></p>
				<p>PF Number:<input type="text" name="emppf"></p>
				<p>Date of Joining:<input type="date" name="empjoindate" placeholder="dd-mm-yyyy" pattern="\d{1,2}-\d{1,2}-\d{4}"></p>
				<p>Date of Birth:<input type="date" name="empdob" placeholder="dd-mm-yyyy" pattern="\d{1,2}-\d{1,2}-\d{4}"></p>-->
            <input type="hidden" name="employee_id" value="<?=$employee_id?>"/>
            <br/>
            <button type="submit" class="btn btn-lg btn-primary" name="emp_edit">Submit</button> 
            <button type="submit" name="cancel" class="btn btn-lg btn-primary"formaction="modify.php">Cancel</button>
        </div>
        </form>
        </br>
        
       <!-- <footer class="site-footer">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-md-6">
            <h6>About</h6>
            <p class="text-justify">Scanfcode.com <i>CODE WANTS TO BE SIMPLE </i> is an initiative  to help the upcoming programmers with the code. Scanfcode focuses on providing the most efficient code or snippets as the code wants to be simple. We will help programmers build up concepts in different programming languages that include C, C++, Java, HTML, CSS, Bootstrap, JavaScript, PHP, Android, SQL and Algorithm.</p>
          </div>

          <div class="col-xs-6 col-md-3">
            <h6>Categories</h6>
            <ul class="footer-links">
              <li><a href="http://scanfcode.com/category/c-language/">C</a></li>
              <li><a href="http://scanfcode.com/category/front-end-development/">UI Design</a></li>
              <li><a href="http://scanfcode.com/category/back-end-development/">PHP</a></li>
              <li><a href="http://scanfcode.com/category/java-programming-language/">Java</a></li>
              <li><a href="http://scanfcode.com/category/android/">Android</a></li>
              <li><a href="http://scanfcode.com/category/templates/">Templates</a></li>
            </ul>
          </div>

          <div class="col-xs-6 col-md-3">
            <h6>Quick Links</h6>
            <ul class="footer-links">
              <li><a href="http://scanfcode.com/about/">About Us</a></li>
              <li><a href="http://scanfcode.com/contact/">Contact Us</a></li>
              <li><a href="http://scanfcode.com/contribute-at-scanfcode/">Contribute</a></li>
              <li><a href="http://scanfcode.com/privacy-policy/">Privacy Policy</a></li>
              <li><a href="http://scanfcode.com/sitemap/">Sitemap</a></li>
            </ul>
          </div>
        </div>
        <hr>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-sm-6 col-xs-12">
            <p class="copyright-text">Copyright &copy; 2017 All Rights Reserved by
         <a href="#">Scanfcode</a>.
            </p>
          </div>

          <div class="col-md-4 col-sm-6 col-xs-12">
            <ul class="social-icons">
              <li><a class="facebook" href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
              <li><a class="twitter" href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
              <li><a class="dribbble" href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
              <li><a class="linkedin" href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
</footer>-->
    </body>

</html>
