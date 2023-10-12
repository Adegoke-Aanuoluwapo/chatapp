
<?php 
$db = new mysqli('localhost', 'root', '', 'chatapp');


class Profile{
 function __construct(){
  

 }

 function SignUp($name, $email, $picture, $phone, $password){
  global $db;
  $pass = password_hash($password, PASSWORD_BCRYPT);
  $sql = $db->query("SELECT * FROM user WHERE email = '$email' AND phone ='$phone'  ");
  if(mysqli_num_rows($sql) > 0){
   echo "email or phone already exist";
  }else{
   $sql = $db->query("INSERT INTO user (name, email, picture, phone, password) VALUES('$name', '$email', '$picture', '$phone', '$pass')");
   if ($sql) {
    echo "operation successful";
   }
  };
  
 }


 function LogIn($email, $password){
    global $db;
   // return;
    $sql = $db->query("SELECT * FROM user WHERE email = '$email'");
    if(mysqli_num_rows($sql) != 1){  echo "invalid login";
    return;}
   

    $rows = mysqli_fetch_assoc($sql);
    if(password_verify($password, $rows['password'])){
        $_SESSION['id'] = $rows['id'];
        if(is_null($rows['picture'])){
        echo 5; 
          }else{
            echo 6;
          }
        return;
    }
    echo 'invalid login';
    return;
 }

 function lastChat($id){
  global $db;
  $sql = $db->query("SELECT chat FROM chat WHERE id='$id' OR id2='$id' ORDER BY sn DESC LIMIT 1");
  $row = mysqli_fetch_assoc($sql);
  if(mysqli_num_rows($sql)==0){return 'Hi, I am available!';}
  return $row['chat'];
 }

function AddChat($chat){
  global $db;
  $time = time();
  $id = $_SESSION['id'];
  $id2 = $_SESSION['id2'];
  $db->query("INSERT INTO chat (id,id2,chat) VALUES ('$id','$id2','$chat')");
  $db->query("UPDATE user SET updated_at='$time' WHERE id='$id2' ");
  $db->query("SELECT * FROM chat WHERE id='$id' OR id2='$id2'");
  echo 1; 
}


};

$pro = new Profile();