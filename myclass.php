<?php
$db = new mysqli('localhost', 'root', '', 'chatapp');


class Profile{
 function __construct(){
  

 }

 function SignUp($name, $email, $phone, $password){
  global $db;
  $pass = password_hash($password, PASSWORD_BCRYPT);
  $sql = $db->query("INSERT INTO users(name, email, phone, password) VALUES('$name', '$email', '$phone', '$pass')");
  if($sql){"operation successful";}
 }
}

$pro = new Profile();
if(isset($_GET['type'])){extract($_GET);
 if($type=='signup'){$pro->SignUp($name,$email,$phone,$passwrd);
 }
}


