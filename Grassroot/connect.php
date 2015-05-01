<?php
// Create connection to Oracle
$MYDB = "(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = oraserv.cs.siena.edu)(PORT = 1521)))(CONNECT_DATA = (SID = csdb)(SERVER = DEDICATED)))";
print "attempting connection";
$conn = oci_connect("perm_maroon", "perm_maroon", $MYDB);
if (!$conn) {
   $m = oci_error();
   echo $m['message'], "\n";
   exit;
}
else {
   print "Connected to Oracle Database!";
}
// Close the Oracle connection 
oci_close($conn);
?>