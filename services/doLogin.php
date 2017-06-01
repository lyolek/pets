<?
include "cammon.php";

$json = file_get_contents('php://input');
$obj = json_decode($json);

if($obj->{'login'} != "") {
  $sql = "Select id From users Where login = '".$obj->{'login'}."' And pass = '".$obj->{'pass'}."'";
  $conn = connectDB();
  processError("", $sql);
  $result = mysql_query($sql, $conn);
  processError("", $sql);
  if ($row = mysql_fetch_array($result)) {
    $_SESSION['idUser'] = $row["id"];
    echo '{"id": "'.$row["id"].'"}';
  } else {
    echo '{"error": "Not Logged in"}';
  }
} else {
  echo '{"error": "Not Logged in"}';
}
?>