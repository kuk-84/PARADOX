<?php
include('database.php');
header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");
    header("Content-type:application/json");
$encodedData = file_get_contents('php://input'); 
$decodedData = json_decode($encodedData, true);
$UserEmail = $decodedData['email'];
$SQL = "SELECT id FROM employee WHERE email = '$UserEmail'";
$exeSQL = mysqli_query($con, $SQL);
$checkid =  mysqli_num_rows($exeSQL);

if ($checkid != 0) 
{
    $arrayu = mysqli_fetch_array($exeSQL);
    $id=$arrayu['id'];
    $SQL = "SELECT pid FROM task WHERE eid = '$id'";
    $exeSQL = mysqli_query($con, $SQL);
    while($row = mysqli_fetch_array($exeSQL))
    {
        $ppid=$row['pid'];
        $SQL = "SELECT startTime,endTime FROM project WHERE pid = '$ppid'";
        $result = mysqli_query($con, $SQL);
        $f=mysqli_fetch_array($result);
        $response[]=array("starttime"=>$f['startime'],"endtime"=>$f['endtime']);
    }
    
} 
else {
    $Message = "No account yet";
    
}

$response[] = array("Message" => $Message);

echo json_encode($response);
?>