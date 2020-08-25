<?php
require_once "pdo.php";
$input=$pdo->query("SELECT gross,basic,certif,medallow,employee_id FROM inputdata");
$rows=$input->fetchAll(PDO::FETCH_ASSOC);
$master=$pdo->query("SELECT employee_id,name,resignation FROM masterdata WHERE resignation IS NULL");
$namerows=$master->fetchAll(PDO::FETCH_ASSOC);
$fetch['input']=$rows;
$fetch['master']=$namerows;
echo(json_encode($fetch));
