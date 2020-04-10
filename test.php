<?php
include 'auto_load.php';
$auth = new Auth('tailors', 'phone');
//$auth->reset_password($_SESSION[$auth->__auth_column], 'kul', 'kulu');
// $log = $auth->login('0801234567', 'a', "this.this");
// if($log){
//     echo"Registered user <br />";
// }else{
//     echo"Invalid user </br />";
// }
$db = new Dbase('localhost', 'root', '', 'followup');
//$db->create_table('testt', [], [], []);
// $c = $db->create_db('followup');
// if($c){
//     echo "deleted";
// }
//$db->update('conducts', ['owner','session', 'current_term'], ['Adam', '15/09/2020', 'Lahira'], ['session'],['15/09/2020']);
//$sql = $auth->register(['name','phone','role', 'balance','password'],["'Hamza'", "'0801234567'", "'Na canza'", 2000, "'a'"]);
//$auth->register(["name","admin_id","password", "status", "gender", "contact", "img_src"], ["'Hauwa'", "'hauwa'","'123456789'", "'1'", "'Female'", "'09023456789'","'babu hoto'"]);
//$auth->reset_password($_SESSION[$auth->__auth_column], 'a', 'a');
//echo $_SESSION[$auth->__auth_column];
// if($sql){
//     echo"sxxx";
// }else{
//     echo"errr";
// }
$auth->logout('../login.php');
?>


<form action="">
</form>