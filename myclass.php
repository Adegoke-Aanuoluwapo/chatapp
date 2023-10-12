<?php
session_start(); ob_start();
include('control.php');
if(isset($_GET['type'])){extract($_GET);


 if($type=='signup'){$pro->SignUp($name, $email, $picture, $phone, $password); }


 if($type=='login'){$pro->LogIn($email, $password); }

 if($type=='contact'){
    $id = $_SESSION['id'];
$user = [];
$sql = $db->query("SELECT * FROM user WHERE id != '$id' ORDER BY updated_at DESC ");
while($row = mysqli_fetch_assoc($sql)){
    $id = $row['id'];
    $lastchat = $pro->lastChat($id);
    $time = date('h:i A',$row['updated_at']);
$user[] = ['id'=>$id,'email'=>$lastchat,'picture'=>$row['picture'],'name'=>$row['name'],'time'=>$time];
}
echo json_encode($user);
 }


if($type=='chat'){
    $_SESSION['id2']=$id2;
    $id = $_SESSION['id'];
    $rows = array();
    $sql = $db->query("SELECT * FROM chat WHERE (id='$id' AND id2='$id2') OR (id='$id2' AND id2='$id') ");
    while($row = mysqli_fetch_assoc($sql)){ $rows[] = $row; }
echo json_encode($rows);

}


if($type=='newchat'){
    $pro->AddChat($chat);
}


if($type=='myid'){
    echo $_SESSION['id'];
}




}



