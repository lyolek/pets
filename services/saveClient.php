<?
include "cammon.php";
checkSession($_SESSION);

$json = file_get_contents('php://input');
$obj = json_decode($json);

$conn = connectDB();
processError("", "");

if($obj->{'firstName'} != "") {
  if($obj->{'id'} == "") {
    $sql = "Select max(id) + 1 From clients";
    $result = mysql_query($sql, $conn);
    processError("", $sql);
    $row = mysql_fetch_array($result);
    $newID = $row[0];
    $sql = "Insert Into clients (id, firstName, lastName, phone1, phone2, phone3, idUser) Values(".$newID.", '".$obj->{'firstName'}."', '".$obj->{'lastName'}."', '".$obj->{'phone1'}."', '".$obj->{'phone2'}."', '".$obj->{'phone3'}."', ".$_SESSION["idUser"].")";
    error_log($sql);
    $result = mysql_query($sql, $conn);
    processError("", $sql);
    echo '{"id":"'.$newID.'"}';
  } else {
    $sql = "Update clients Set firstName = '".$obj->{'firstName'}."', lastName = '".$obj->{'lastName'}."', phone1 = '".$obj->{'phone1'}."', phone2 = '".$obj->{'phone2'}."', phone3 = '".$obj->{'phone3'}."' Where idUser = ".$_SESSION["idUser"]." And id = ".$obj->{'id'};
    error_log($sql);
    $result = mysql_query($sql, $conn);
    processError("", $sql);
    echo '{"id":"'.$obj->{'id'}.'"}';
  }
}
?>