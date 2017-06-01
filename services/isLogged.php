<?
include "cammon.php";

if (isset($_SESSION['idUser'])) {
  $sql = "Select id, name From users Where id = '".$_SESSION['idUser']."'";
  $conn = connectDB();
  processError("", $sql);
  $result = mysql_query($sql, $conn);
  processError("", $sql);
  if ($row = mysql_fetch_array($result)) {
    echo '{"id":"'.$_SESSION['idUser'].'", "name": "'.$row["name"].'"}';
  }
} else {
  echo "{\"error\":\"Not Logged in\"}";
}
?>