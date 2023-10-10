<?php
$db = new mysqli('localhost', 'root', '', 'chatapp');


class Profile{
 function __construct(){
  

 }

 function SignUp($name, $email, $phone, $password){
  global $db;
  $pass = password_hash($password, PASSWORD_BCRYPT);
  $sql = $db->query("SELECT * FROM users WHERE email = '$email' AND phone ='$phone'  ");
  if(mysqli_num_rows($sql) > 0){
   echo "email or phone already exist";
  }else{
   $sql = $db->query("INSERT INTO users (name, email, phone, password) VALUES('$name', '$email', '$phone', '$pass')");
   if ($sql) {
    echo "operation successful";
   }
  };
  
 }
};

$pro = new Profile();
if(isset($_GET['type'])){extract($_GET);
 if($type=='signup'){$pro->SignUp($name, $email, $phone, $pass);
 }
}


