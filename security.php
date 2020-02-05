<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once("setup.php");
$conn_id = setup_connect()
or die ("cannot connect to server");
$Trader=$_SESSION['ID'];
$Pwd=$_SESSION['Pwd'];

$loginquery = "SELECT Pwd FROM tradeapp.Trader_Database WHERE TraderID = '$Trader'";
$result_id = mysqli_query ($conn_id, $loginquery)
or die ("Fail");
while ($row = mysqli_fetch_assoc ($result_id))
{
	echo $Pwd;
	$resultPwd=$row["Pwd"];
	echo $resultPwd;
	}
if($resultPwd!=$Pwd or $Pwd==""){

echo "<script type='text/javascript'>
window.location.href = 'login.php';
</script>";
}else{
}

?>