<?
include "cammon.php";
checkSession($_SESSION);

$json = file_get_contents('php://input');
$obj = json_decode($json);

$conn = connectDB();
processError("", "");
    

if($obj->{'param'} != "" || $obj->{'id'} != "" || $obj->{'phone'} != "") {
  $ret = "";
  if($obj->{'id'} != "") {
    $sql = "Select id, firstName, lastName, phone1, phone2, phone3 From clients Where idUser = ".$_SESSION["idUser"]." And id = '".$obj->{'id'}."'";
  } else {
    $sql = "Select id, firstName, lastName, phone1, phone2, phone3 From clients Where idUser = ".$_SESSION["idUser"]." And (firstName like '".$obj->{'param'}."%' Or lastName like '".$obj->{'param'}."%') And (phone1 like '".$obj->{'phone'}."%' Or phone2 like '".$obj->{'phone'}."%' Or phone3 like '".$obj->{'phone'}."%')";
  }
  error_log($sql);
  $result = mysql_query($sql, $conn);
  processError("", $sql);
  $ret .= '[';
  $isFirstRow = true;
  while($row = mysql_fetch_array($result)) {
    if(!$isFirstRow) {
      $ret .= ",";
    } else {
      $isFirstRow = false;
    }
    $ret .= '{"id":"'.$row["id"].'", "firstName":"'.$row["firstName"].'", "lastName":"'.$row["lastName"].'", "phone1":"'.$row["phone1"].'", "phone2":"'.$row["phone2"].'", "phone3":"'.$row["phone3"].'"}';
  }
  $ret .= ']';
  error_log($ret);
  echo $ret;
} else {
    echo '{"error":"No serch paramneters"}';
}
?>