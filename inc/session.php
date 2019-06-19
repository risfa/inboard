<?php 
@session_start();
include ('Db/connect.php');
if($_SESSION['username'] == true){   
echo "<script>document.location.href='http://xeniel.5dapps.com/IntraApp/index.php'</script>";
 
}else{
  echo "<script>document.location.href='http://xeniel.5dapps.com/IntraApp/login.php'</script>";
}
?>