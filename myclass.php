<?php
$db = new mysqli('localhost', 'root', '', 'chatapp');


class Profile{
 function __construct(){

 }

 function SignUp($name, $email, $phone, $password){
  global $db;
  $pass = password_hash($password, PASSWORD_BCRYPT);
  $sql = $db->query("INSERT INTO users(name, email, phone, password) VALUES('$name', '$email', '$phone', '$password')");
 }
}


