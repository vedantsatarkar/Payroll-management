<?php
require_once "pdo.php";
session_start();

if (!isset($_SESSION['user_id'])){
   die("ACCESS DENIED!");
}

$input=$pdo->query("SELECT m.employee_id,m.name,m.resignation,
                   (SELECT gross FROM inputdata WHERE employee_id=m.employee_id ORDER BY 
                    updated_on DESC limit 1) gross,
                   (SELECT basic FROM inputdata WHERE employee_id=m.employee_id ORDER BY 
                    updated_on DESC limit 1) basic,
                   (SELECT medallow FROM inputdata WHERE employee_id=m.employee_id ORDER BY 
                    updated_on DESC limit 1) medallow,
                   (SELECT certif FROM inputdata WHERE employee_id=m.employee_id ORDER BY 
                    updated_on DESC limit 1) certif FROM masterdata m");
$rows=$input->fetchAll(PDO::FETCH_ASSOC);


if(isset($_POST['updateall'])){
    $updateall=[];
    for($i=0;$i<sizeof($rows);$i++){
        $updateall[$i]=Array('gross'=>$_POST['gross'][$i],
                          'basic'=>$_POST['basic'][$i],
                          'medallow'=>$_POST['medallow'][$i],
                          'certif'=>$_POST['certif'][$i],
                          'empid'=>$_POST['empid'][$i]
                         );   
    }
    $sql="INSERT INTO inputdata (gross,basic,medallow,certif,employee_id) VALUES (:gr,:bas,:med,:cert,:empid)";
    foreach($updateall as $all){
        $stmt=$pdo->prepare($sql);
        $stmt->execute(Array(':gr'=>$all['gross'],
                             ':bas'=>$all['basic'],
                             ':med'=>$all['medallow'],
                             ':cert'=>$all['certif'],
                             ':empid'=>$all['empid']
                            ));
    }
    $stmt=null;
    header('Location: modify.php');
    return;
}

if(isset($_POST['updatesingle'])){
  $stmtdata=$pdo->prepare('INSERT INTO inputdata(gross, basic, certif, medallow, employee_id) VALUES (:gr,:bas,:cert,:medallow,:empid)');
    $stmtdata->execute(array(':gr'=>$_POST['empgross'],
                             ':bas'=>$_POST['empbas'],
                             ':cert'=>$_POST['empcert'],
                             ':medallow'=>$_POST['empmed'],
                             ':empid'=>$_POST['empname']       
                            ));
    header('Location: modify.php');
    return;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Manage Increments</title>
    <script type="text/javascript">
      function validateSingle(){
        if( document.single.empgross.value == "" ) {
          alert( "All fields are required." );
          document.single.empgross.focus() ;
          return false;
        }
        if( document.single.empbas.value == "" ) {
          alert( "All fields are required." );
          document.single.empbas.focus() ;
          return false;
        }
        if( document.single.empcert.value == "" ) {
          alert( "All fields are required." );
          document.single.empcert.focus() ;
          return false;
        }
        if( document.single.empmed.value == "" ) {
          alert( "All fields are required." );
          document.single.empmed.focus() ;
          return false;
        }  
        if( document.single.empname.value == "" ) {
          alert( "All fields are required." );
          document.single.empname.focus() ;
          return false;
        }
        return( true );
      }
    </script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <link rel="stylesheet" type="text/css" href="css/modify.css">
  </head>
  <body style="background-color: #d6e6f2;">
    <?php require_once "navbar.php"?>

    <div class="container">
      <h1 style="padding:10px 0px" id="heading">Manage Increments</h1>
    </div>
    
    
    <div class="container">
      <ul class="nav nav-tabs">
        <li style="padding-right: 10px; padding-bottom: 20px" class="nav-item"><button type="button" style="background-color: #343A40; color: white;" class="btn" id="ind-button">Individual</button></li>
        <li style="padding-right: 10px; padding-bottom: 20px" class="nav-item"><button type="button" style="background-color: #343A40; color: white;" class="btn" id="all-button">All</button></li>
      </ul>
        <div id="ind-form">
          <form name="single" onsubmit="return(validateSingle());" method="post">  
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" id="name">Name:</label>
              <div class="col-sm-3">
                <select class="form-control" id="name-dropdown" name="empname"></select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" id="gross">Gross Salary:</label>
              <div class="col-sm-3">
              <input type="number" class="form-control" name="empgross" id="gross">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label" id="basic">Basic:</label>
              <div class="col-sm-3">
              <input type="number" class="form-control" name="empbas" id="basic">
              </div>
            </div>
            <div class="form-group row">
             <label class="col-sm-2 col-form-label" id="med">Medical Allowance:</label>
             <div class="col-sm-3">
              <input type="number" class="form-control" name="empmed" id="med">
              </div>
            </div>
            <div class="form-group row">
             <label class="col-sm-2 col-form-label" id="cert">Certification Charges:</label>
             <div class="col-sm-3">
              <input type="number" class="form-control" name="empcert" id="cert">
              </div>
            </div>
              <div class="form-group row" style="position:relative;left:15px;">
                <button type="submit" name="updatesingle" class="btn btn-primary">Update</button>
              </div> 
          </form>
        </div>
        <div id="all-form" style="display: none">
          <p>*Already filled are old values for each employee</p>
          <form name="all" onsubmit="return(validateAll());" method="post">
              <table class="table table-hover table-bordered table-sm">
                <?php
                echo "<thead class=\"thead-dark\"><tr><th>Name</th>";
                echo "<th>GrossSalary</th>";
                echo "<th>Basic</th>";
                echo "<th>MedicalAllowance</th>";
                echo "<th>Certification</th></tr>";
                foreach ($rows as $row){
                if ($row['resignation'] == null) {
                echo("<tr><td>");
                echo(" ".$row['name']);
                echo("</td><td>");
                echo"<input type='number' name='gross[]' value='".$row['gross']."' required/>";
                echo("</td><td>");
                echo"<input type='number' name='basic[]' value='".$row['basic']."' required/>";
                echo("</td><td>");
                echo"<input type='number' name='medallow[]' value='".$row['medallow']."' required/>";
                echo("</td><td>");
                echo"<input type='number' name='certif[]' value='".$row['certif']."' required/>";
                echo("</td><input type='hidden' name='empid[]' value='".$row['employee_id']."'></tr>");
                }
                }
                ?>
              </table>
              <div style="display:flex;justify-content:center;width:100%;margin-left:auto; margin-right:auto">
              <button class="btn btn-primary btn-lg" style="position:relative;left:-10px;margin-bottom:40px" name="updateall">Update All</button>
              <button class="btn btn-secondary btn-lg" style="position:relative;left:10px;margin-bottom:40px" name="cancel">Cancel</button>
              </div>
            </form>  
        </div>
    </div>
    <script type="text/javascript">
      $(document).ready(function(){
        let dropdown = $('#name-dropdown');
        dropdown.empty();
        dropdown.append('<option selected="true" value="" disabled>Choose Employee Name</option>');
        dropdown.prop('selectedIndex', 0);
        $.getJSON('json.php',function(data){
          $.each(data.master, function(key,entry){
            dropdown.append($('<option></option>').attr('value', this.employee_id).text(this.name));
          })
        })

        $('#ind-button').click(function(event){
          event.preventDefault();
          $('#ind-form').show();
          $('#all-form').hide();
        })
        $('#all-button').click(function(event){
          event.preventDefault();
          $('#all-form').show();
          $('#ind-form').hide();
        })
      })

    </script>
  </body>
</html>

