<?php 
session_start(); ob_start();
include ("control.php");
//unset($_SESSION['id']);
$id = $_SESSION['id'];
//echo $id;

 
if(isset($_POST['change'])){

$target = 'upload/';
	$targetfile = $target.$_FILES['picture']['name']; //upload/picturename.jpg
	
	move_uploaded_file($_FILES['picture']['tmp_name'],$targetfile);
    $db->query("UPDATE user SET  picture='$targetfile' WHERE id='$id' ");
echo 'Success '.$_SESSION['id'];

}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Document</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
 <style>
    body{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;

    }
    .card{
        width: 400px;
    }
 </style>
</head>
<body>
 <form action=""  method="POST" enctype="multipart/form-data">
  <div class="container">
   <div class="card">
    <div class="card-header">
     <h4>Upload Profile Picture <?= $pro->lastChat(3) ?></h4>
    </div>
     
<div class="card-body">
     <label >Select Picture</label>
     <div class="form-group">      
       <input type="file" class="custom-file-input mt-4" id="picture" name="picture">
     </div>
    </div>
    
    
     
     
    <div class="class-footer">
     <button class="btn btn-primary" type="submit" style="margin-left:150px;" name="change">Choose File</button>
    </div>
</div>
    </div>
   </div>
  </div>
 </form>

 


 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
 <script src="jquery.min.js"></script>


</body>
</html>