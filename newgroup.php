<?php
session_start();
ob_start();
include("control.php");
//unset($_SESSION['id']);
$id = $_SESSION['id'];
//echo $id;


if (isset($_POST['CreateGroup'])) {
 extract($_POST);

 if (count($member) > 1) {
  $id = $_SESSION['id'];
  $member[] = $id;
  $gid = rand();
  $x = json_encode($member);
  $db->query("INSERT INTO users (name,member,email,admin) VALUES ('$name','$x','$gid','$id') ");
  $cid = mysqli_insert_id($db);
  $i = 0;
  while ($i < count($member)) {
   $e = $i++;
   $id = $member[$e];
   $sql = $db->query("INSERT INTO contacts(id, cid) VALUES('$id', '$cid')");
  }
 }
}

//echo json_encode($pro->myContact());
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
  body {
   display: flex;
   justify-content: center;
   align-items: center;
   height: 100vh;
   margin: 0;

  }

  .card {
   width: 400px;
  }
 </style>
</head>

<body>
 <form method="POST" enctype="multipart/form-data">
  <div class="container">
   <div class="card">
    <div class="card-header">
     <h4>Create New Group</h4>
    </div>

    <div class="card-body">
     <label>Group Name</label>
     <div class="form-group mb-3">
      <input type="text" class="form-control mt-4" placeholder="Group Name" id="picture" name="name" required>
     </div>
     <label>Select Group Members</label>

     <?php $id = $_SESSION['id'];
     $sql = $db->query("SELECT * FROM contacts WHERE id='$id' ");
     foreach ($sql as $row) { ?>
      <div class="form-group">
       <label><input type="checkbox" value="<?= $row['cid'] ?>" name="member[]"> <?= $pro->userName($row['cid']) ?></label>
      </div>
     <?php } ?>
     <div class="form-group">
      <label><input type="checkbox" checked disabled> <?= $pro->userName($_SESSION['id']) ?></label>
     </div>
    </div>






    <div class="card-footer">
     <button class="btn btn-primary btn-block" type="submit" name="CreateGroup">Create Group</button>
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