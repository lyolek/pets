<?
header('Content-Type: application/json; charset=utf-8');
include "connect.php";
session_start();

function useGET($v) {
	return array_key_exists($v, $_GET) ? $_GET[$v] : "";
}
function usePOST($v) {
	return array_key_exists($v, $_POST) ? $_POST[$v] : "";
}

function connectDB() {
   $conn = mysql_connect(DB_HOST, DB_USER, DB_PASS);
   mysql_select_db(DB_NAME, $conn);
   mysql_set_charset('utf8',$conn);
   return $conn;
}
function connectDBi() {
   $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   mysqli_set_charset($conn, 'utf8');
   return $conn;
}


function processError($addErr, $sql) {
  global $conn;
  if(mysql_errno() != 0) {
//  error_log(mysql_errno(), 0);
//  error_log(mysql_error(), 0);
    echo '{"error":"'.mysql_error().'"}';
    break;
  }
}

function checkSession($sess) {
  if (!isset($sess["idUser"])) {
    echo '{"error":"Not Logged in"}';
    break;
  }
}
?>