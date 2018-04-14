<?php

$s = 'clas';

//Should probably put this in a function after site is migrated.
$host = "enterprise1";
$port = "2500";
$hostname= 'enterprise1.asu.edu';
$dbname='SPONSORED';
$username='ovprea_app';
$password='993920477';

$dsn_strings = [
  "Driver=MSSQL",
  "Server=$hostname",
  "Port=$port",
  "Database=$dbname",
  "Trusted_Connection=No",
  "DumpFlags=0xffff"
];

try{
  $db_conn = new PDO( "odbc:" . implode(";", $dsn_strings ), $username, $password );
} catch (PDOException $e) {
  echo "FAILED: " . $e->getMessage();
}
$rs = "SELECT * FROM SPONSORED.dbo.RA_CWH_UNIT_DESC where unit_name like('%$s%') and Active_Dept_Code != NULL AND unit_name NOT LIKE('*%')";
$matches = array();

foreach($db_conn->query($rs) as $row){
  if ($row['Active_Dept_Code']) array_push($matches, $row['Unit_Name']);
}

$type = "text/plain";
$response = json_encode($matches);
header("X-JSON: $response");
header("Content-Type: $type");
$page_content = $response;
echo $response;
exit;

?>