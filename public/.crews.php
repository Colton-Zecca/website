<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once ".db_config.php";

$connection = new mysqli($dsn, $duser, $dpassword);
//$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Selecting Database
//$db = mysql_select_db("$db_name", $connection);
$connection->query("USE `$db_name`");

$result = $connection->query("SELECT date, cc, driver, attendant, observer FROM crews");

$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "") {$outp .= ",";}
    $outp .= '{"date":"'  . $rs["date"] . '",';
    $outp .= '"cc":"'   . $rs["cc"]        . '",';
    $outp .= '"driver":"'   . $rs["driver"]        . '",';
    $outp .= '"attendant":"'   . $rs["attendant"]        . '",';
    $outp .= '"observer":"'. $rs["observer"]     . '"}';
}
$outp ='{"records":['.$outp.']}';
$connection->close();

echo($outp);
?>