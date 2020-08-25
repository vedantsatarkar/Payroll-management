<?php
require_once "pdo.php";
session_start();

if(!isset($_SESSION['user_id'])){
    die("ACCESS DENIED!");
}

$stmt=$pdo->query("SELECT name,basic,spcallow,certif,leaves FROM salary_sample");
$rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
    <head>
	    <title>Main.php</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/navbar.css">
    </head>
    <body>
        <div class="navbar">
    	    <a href="main.php">Home</a>	
            <a href="add.php">Add</a>
      	    <a href="modify.php">Modify</a>
      	    <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">View Records
                <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="#">April 2020</a></li>
                    <li><a href="#">March 2020</a></li>
                    <li><a href="#">February 2020</a></li>
                </ul>
            </div>
            <a href="newrec.php">New Record</a>
            <a href="constants.php">Constants</a>
  	        <a href="logout.php">Logout</a>
        </div>

        <div class="container">
	       <h1>Payroll Management Portal</h1>
	    </div>
	    <div class="container">
	        <table class="table table-bordered table-striped table-hover table-responsive">
            <?php
            echo "<tr><td> Name</td>";
            echo "<td> Basic</td>";
            echo "<td> Conveyance</td>";
            echo "<td> HRA</td>";
            echo "<td> Medical Allowance</td>";
            echo "<td> Special Allowance</td>";
            echo "<td> Certification</td>";
            echo "<td> No of Leaves</td>";
            echo "<td> PT</td>";
            echo "<td> PF</td>";
            echo "<td> ESIC</td></tr>";
            foreach($rows as $row){
                echo "<tr><td>";
                $name = $row['name'];
                    echo"<input type='text' name='emp_name' value='$name'/>";
                    echo("</td><td>");
                    $basic=$row['basic'];
                    echo"<input type='number' name='basic' value='$basic'/>";
                    echo("</td><td>");
                    $conveyance=$row['conveyance'];
                    echo"<input type='number' name='conveyance' value='$conveyance'/>";
                    echo("</td><td>");
                    $hra=$row['hra'];
                    echo"<input type='number' name='hra' value='$hra'/>";
                    echo("</td><td>");
                    $medallow=$row['medallow'];
                    echo"<input type='number' name='medallow' value='$medallow'/>";
                    echo("</td><td>");
                    $spcallow=$row['spcallow'];
                    echo"<input type='number' name='spcallow' value='$spcallow'/>";
                    echo("</td><td>");
                    $certif=$row['certif'];
                    echo"<input type='number' name='certif' value='$certif'/>";
                    echo("</td><td>");
                    $leaves=$row['leaves'];
                    echo"<input type='number' name='leaves' value='$leaves'/>";
                    echo("</td><td>");
                    $pt=$row['pt'];
                    echo"<input type='number' name='pt' value='$pt'/>";
                    echo("</td><td>");
                    $pf=$row['pf'];
                    echo"<input type='number' name='pf' value='$pf'/>";
                    echo("</td><td>");
                    $esic=$row['esic'];
                    echo"<input type='number' name='esic' value='$esic'/>";
                    echo("</td><td>");
                    echo("</td></tr>\n");
            }
            ?>
            </table>
        </div>
        <footer>
	    </footer>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.js" integrity="
        sha256-DrT5NfxfbHvMHux31Lkhxg42LY6of8TaYyK50jnxRnM=" crossorigin="anonymous"></script>
    </body>
</html>