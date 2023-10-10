<?php
$db = new mysqli('localhost', 'root', '', 'chatapp');


class Profile{
 function __construct(){
  

 }

 function SignUp($name, $email, $phone, $password){
  global $db;
  $pass = password_hash($password, PASSWORD_BCRYPT);
  $sql = $db->query("SELECT * FROM users WHERE email = '$email' OR phone ='$phone'  ");
  if(mysqli_num_rows($sql) > 0){
   echo "email or phone already exist";
  }else{
   $sql = $db->query("INSERT INTO users (name, email, phone, password) VALUES('$name', '$email', '$phone', '$pass')");
   if ($sql) {
    echo "operation successful";
   }
  };
  
 }

 function LoginUser($email, $password){
  global $db;
  $sql= $db->query("SELECT * FROM user WHERE email ='$email' ");
  if(mysqli_num_rows($sql) != 1){
   echo "invalid login";
   return;
  }
  $rows = mysqli_fetch_assoc($sql);
  if(password_verify($password, $rows['password'])){
   $_SESSION['id'] = $rows['id'];
   header('location:chat.html');
   echo 'login success';
   return;
  };
  echo 'invalid login';
  return;
 }
};

$pro = new Profile();
if(isset($_GET['type'])){extract($_GET);
 if($type=='signup'){$pro->SignUp($name, $email, $phone, $password);
 }
}


