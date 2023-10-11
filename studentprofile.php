
<?php 
 session_start();ob_start();
 include ("myclass.php");
$sn = $_GET['sn'];
$target_dir = "upload/";
@$file_name =  basename($_FILES["fileToUpload"]["name"]);
@$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); 
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $report  =  "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $report = "File is not an image.";$count = 1;
        $uploadOk = 0;
    }

    // Check if file already exists
if (file_exists($target_file)) {
    $report = "Sorry, file already exists."; $count=1;
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000) {
    $report = "Sorry, your file is too large.";$count=1;
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $report = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";$count=1;
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $report = "Sorry, your file was not uploaded.";$count=1;
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {    
        
    $sql = $db->query("UPDATE students SET picture = '$file_name' WHERE sn = '$sn' ") or die($db->error);

    if($sql){
        $report = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    }else{
        die($db->error);
        unlink('upload/'.$file_name);
    }
    } else {
        $report = "Sorry, there was an error uploading your file.";$count=1;
    }
}
}

 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="09QOWY6OuEbeJXpy41UA0zWj2sESXiOeEPf2dHaU">
    <title>    Student Profile
</title>
     <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
  

    <style>
        .profile_pics {
            width: 50px;
            height: 50px;
        }

        .object-cover {
            object-fit: cover;
        }

        .profile-user-img {
            width: 100px;
            height: 100px;
        }

    </style>


</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        
<?php include("nav.php"); ?>
       

        
        <div class="content-wrapper">
            <div class="littleAlert"></div>
            
<style>
    .comp { position: relative; width: max-content}
    .comp img { display: block; }
    .comp i { position: absolute; bottom:10px; right:10px; }
</style>
    <link rel="stylesheet" href="https://portal.schoolpetal.com/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">


    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Student Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/control/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Student Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<?php

 $sql = $db->query("SELECT * FROM students WHERE sn='$sn' ") ;
$rows = $sql->fetch_assoc();
?>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-secondary card-outline">
                    <div class="card-body box-profile p-card">
                       
                     <!-- <button class="btn btn-success btn-block"><b> <i class="fa fa-user-times"></i> De-activate</b></button> -->
                    
                        <div class="d-flex justify-content-center upload_new_img">
                            <div class="text-center comp">
                                <img class="profile-user-img img-fluid img-circle object-cover"
                                     alt="User profile picture"src="<?='upload/'.$rows['picture'] ?>">
                                <i class="fas fa-upload "></i>
                            </div>
                        </div>
                        <h3 class="profile-username text-center"  ><?= $rows['surname'] .' '. $rows['firstname'].' '. $rows['othername'] ?></h3>
                        <p class="text-muted text-center"><?= $rows['class'] ?><sup><?= $rows['arm'] ?></sup> <?=$rows['gender']?></p>
                         <button class="btn btn-success btn-block"><b> <i class="fa fa-user-check"></i> Activate</b></button>
                         <form method="post" enctype="multipart/form-data">
                                            Select image to upload:
                                           <input type="file" name="fileToUpload" id="fileToUpload" class="bg bg-primary" style="width:250px;"><br><br>
                                         <input type="submit" value="Upload Image" name="submit" class="bg bg-primary">
                                    </form><br>
                        <a class="btn btn-primary btn-block" href="#settings" data-toggle="tab"><b> <i class="fas fa-edit"></i> Edit Profile</b></a>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card card-secondary card-outline">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Profile</a></li>
                            <li class="nav-item"><a class="nav-link" href="#levies" data-toggle="tab">School Fees</a></li>
                            <li class="nav-item"><a class="nav-link" href="#result" data-toggle="tab">Result & Transcript</a></li>
                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                        </ul>

                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div><b>Registration No:</b><?= $rows['regno']?> </div>
                                <div><b>Admission Date:</b><?= $rows['reg_date']?> </div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <div><b>Date Of Birth:</b> 10, Jan 2022 </div>
                                <div><b>Admission Date:</b><?= $rows['reg_date']?></div>
                            </div>

                            <hr>
                            <div class="d-flex justify-content-between">
                                <div><b>Username:</b> <?= $rows['username'] ?></div>
                                <div><b>Password:</b><?= $rows['password'] ?></div>
                            </div>
                        </div>


                    </div>


                      <div class="card">
                        <div class="card-header">
                            <h4 class="card-title text-bold">Parent/ Guardian Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="box-profile">
                                        <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle object-cover"
                                     alt="User profile picture"src=" ">
                                        </div>

                                        <h3 class="profile-username text-center"><?=$Pro->sqL1('parent','sn', $rows['guardian'],'name' )?></h3>

                                        <p class="text-muted text-center">${guard.guardian_address}</p>

                                        <div class="text-center">
                                            <a href="">Go-to-profile <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="d-flex justify-content-between">
                                        <div><b>Father's Name:</b>null </div>
                                        <div><b>Father's Phone:</b>null</div>
                                    </div>

                                    <hr>

                                    <div class="d-flex justify-content-between">
                                        <div><b>Father's Occupation:</b> null </div>
                                        <div><b>Father's Address:</b> null</div>
                                    </div>

                                    <hr>

                                    <div class="d-flex justify-content-between">
                                        <div><b>Mother's Name:</b> null </div>
                                        <div><b>Mother's Phone:</b> null </div>
                                    </div>

                                    <hr>

                                    <div class="d-flex justify-content-between">
                                        <div><b>Mother's Occupation:</b>null</div>
                                        <div><b>Mother's Address:</b> null</div>
                                    </div>

                                    <hr>

                                    <div class="d-flex justify-content-between">
                                        <div><b>Guardian's Name:</b> null</div>
                                        <div><b>Guardian's Phone:</b> null</div>
                                    </div>

                                    <hr>

                                    <div class="d-flex justify-content-between">
                                        <div><b>Guardian's Email:</b> null</div>
                                        <div><b>Guardian's Address:</b>null </div>
                                    </div>



                                    <hr>

                                    <h5 class="text-muted">Send SMS To Gurdian</h5>

                                    <form action="">
                                        <div class="form-group">
                                            <textarea name="" id="" rows="2" class="form-control"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-primary" onclick="return confirm('Balance reminder will be sent to this gurdian')" > <i class="fa fa-paper-plane" aria-hidden="true"></i> Send Balance Reminder SMS</button>
                                            <button class="btn btn-secondary float-right"> <i class="fa fa-paper-plane" aria-hidden="true"></i> Send </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                      <div class="card">
                        <div class="card-header">
                            <h4 class="card-title text-bold"> Miscellanous Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div><b>Blood Group:</b> ${ot.blood_group ?? ''} </div>
                                <div><b>Geno Type:</b> ${ot.genotype ?? ''} </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">
                                <div><b>Ailment:</b> ${ot.ailment ?? 'None'} </div>
                                <div><b>Disablity:</b> ${ot.disability ?? 'None'} </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">
                                <div><b>Previosu School:</b> ${ot.previous_school ?? 'None'} </div>
                                <div><b>Reason For leaving:</b> ${ot.reason_for_leaving ?? 'None'} </div>
                            </div>

                        </div>
                    </div>
                            </div>

                            <div class="tab-pane" id="levies">
                                 <div><a href="javascript:;" data-toggle="modal" data-target="#makePayment" class="btn btn-secondary mb-3">Make Fee Payment  </a></div>
                <div class="card">
                        <div class="card-header">
                            <h4 class="card-title text-bold">School Fees</h4>
                        </div>
                        <div class="card-body p-1">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>Fee</th>
                                        <th>Amount</th>
                                        <th>Discount</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                     <tr>
                        <th></th>
                        <th>${moneyFormat(fee_amt)}</th>
                        <th>${moneyFormat(fee_dis)}</th>
                        <th>${moneyFormat(Math.abs(fee_total))}</th>
                    </tr>
                    <tr>
                    <th colspan="3">Balance Brought Foward</th>
                    <td>${moneyFormat(data.brought_fwd))}</td>
                </tr>
                <tr>
                    <th colspan="3">Total Owing</th>
                    <th>${ moneyFormat(total_owing) }</th>
                </tr>
                <tr>
                    <th colspan="3">Amount Paid</th>
                    <th>${moneyFormat(data.amt_paid)}</th>
                </tr>
                <tr>
                    <th colspan="3">Expected Payments</th>
                    <th>${moneyFormat(total_owing - data.amt_paid)}</th>
                </tr>
                `
                    </tbody>

                                   


                                </table>
                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title text-bold">Recent Payments</h4>
                        </div>
                        <div class="card-body p-1">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <th>Fee</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                    ${pay_string}
                                </table>
                            </div>
                        </div>
                    </div>


                    <div><a href="/control/student/fee/250" class="btn btn-block btn-secondary">View School Fee Details <i class="fa fa-arrow-circle-right" aria-hidden="true"></i> </a></div>
                            </div>


                            <div class="tab-pane" id="result">
                                 <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-bold">Results</h3>
                        </div>
                        <div class="card-body p-1">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <th>#</th>
                                        <th>Session</th>
                                        <th>Term</th>
                                        <th>Class</th>
                                        <th>Subjects</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
<tr>
                            <td>1</td>
                            <td>session.session</td>
                            <td>$(res.term.term)}</td>
                            <td>${res.class.class}</td>
                            <td>${res.subjects}</td>
                            <td>(res.created_at)}</td>
                            <td><a class="btn btn-xs btn-info" href="/control/view-result/${res.id}"><i class="fas fa-eye"></i> View</a></td>
                        </tr>
                    
                                </table>
                            </div>
                        </div>
                    </div>
                            </div>


                            <div class="tab-pane" id="settings">
                                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-bold">Edit Basic Info</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" id="basic_info" class="row">
                            <div class=" col-md-4 form-group">
                                <label>Surname </label>
                                <input type="text" name="surname" class="form-control" value="" placeholder="Surname">
                            </div>

                            <div class=" col-md-4 form-group">
                                <label>Firstname</label>
                                <input type="text" name="firstname" class="form-control" value="<?=$rows['firstname']?>" placeholder="Firstname">
                            </div>

                            <div class=" col-md-4 form-group">
                                <label>Othernames</label>
                                <input type="text" name="othername" class="form-control" value="<?=$rows['othername']?> " placeholder="Othernames">
                            </div>
                            
                            <div class=" col-md-6 form-group">
                                <label>Gurdian</label>
                                <select name="guardian" class="form-control select2bs4" id="select_guardian">
                                    <option selected>Guardian</option>
                                    <?php
                                                 
                                                     $i=1; $sql = $db->query("SELECT * FROM parent") ;
                                          while($row = $sql->fetch_assoc()) { 
                                                echo    '<option value="'.$row['sn'].'">'.$row['name'].'</option>'; 
                                                } ?>
                                </select>
                            </div>
                            <div class=" col-md-2 form-group">
                                <label>Gender</label>
                                <select name="gender" class="form-control select2bs4" id="">
                                    <option selected>Gender</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
                            <div class=" col-md-4 form-group">
                                <label>Registration Number</label>
                                <input type="text" name="reg" class="form-control" value="" placeholder="Registration Number">
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-secondary float-right basic_info" name="updateStudent" >Update</button>
                            </div>
                        </form>
                    </div>
                </div>
 <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-bold">Class & Arm</h4>
                    </div>
                    <div class="card-body">
                        <form action="" class="row">
                            <div class="col-md-4 form-group">
                                <label>Class</label>
                                <select name="" id="select_class" class="form-control  select2bs4">
                                    <option selected value="${(data.class) ? data.class.id : ''}">${(data.class) ? data.class.class : ''}</option>
                                </select>
                            </div>

                            <div class="col-md-4 form-group">
                                <label>Arm</label>
                                <select name="" id="select_arm" class="form-control select2bs4">
                                    <option selected value="${(data.arm) ? data.arm.id : ''}">${(data.arm) ? data.arm.arm : ''}</option>
                                </select>
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="text-white">.</label>
                                <button class="btn btn-secondary btn-block">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>

                         <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-bold">Change Authentication Details</h4>
                    </div>
                    <div class="card-body">
                        <form id="auth_det" class="row" method="POST">
                            <div class="col-md-4 form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" value="<?= $rows['username']?>" placeholder="Enter Username">
                            </div>

                            <div class="col-md-4 form-group">
                                <label>Password</label>
                                <input type="number" max="9999" min="4" class="form-control" name="password" value="<?= $rows['password']?>" placeholder="4-6 Digits">
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="text-white">.</label>
                                <button class="btn btn-secondary btn-block auth_det" name="updateStudentUsername">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>

                         <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-bold">Edit Other Info</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" class="row" id="miscellanous">
                            <div class="col-md-3 form-group">
                                <label>Blood Group</label>
                                <input type="text" class="form-control" name="blood_group" value="${ot.blood_group}" placeholder="Enter Blood Group ie O-">
                            </div>

                            <div class="col-md-3 form-group">
                                <label>Geno Type</label>
                                <input type="text" class="form-control" name="genotype" value="${ot.genotype}" placeholder="Enter Genetype i.e AA">
                            </div>

                            <div class="col-md-3 form-group">
                                <label>Ailment</label>
                                <input type="text" class="form-control" name="ailment" value="${ot.ailment}" placeholder="Enter if any">
                            </div>

                            <div class="col-md-3 form-group">
                                <label>Disability</label>
                                <input type="text" class="form-control" name="disability" value="${ot.disability}" placeholder="Enter if any">
                            </div>


                            <div class="col-md-6 form-group">
                                <label>Previous School Attended</label>
                                <input type="text" class="form-control" name="previous_school" value="${ot.previous_school}" placeholder="">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Reason For Leaving Previous School</label>
                                <textarea name="reason_for_leaving" rows="2" class="form-control" >${ot.reason_for_leaving}</textarea>
                            </div>

                            <div class="col-md-12 ">
                                <button type="button" class="btn btn-secondary float-right miscellanous">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    


    <div class="modal fade" id="makePayment">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title text-bold">Make Payments </p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="make_pay" class="row">
                        <div class="col-md-6 form-group">
                            <label>Fee Category</label>
                            <select name="fee_cat" id="fee_cat" class="form-control select2bs4">
                                <option selected disabled>Select Fee Category</option>
                                <option value="">Tution Fee</option>
                                <option value="">Sport Levy</option>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Amount</label>
                            <input type="number" name="amount" class="form-control" placeholder="Enter Amount i.e 15750">
                        </div>
                        <div class="col-12 form-group">
                            <button type="submit" class="btn btn-secondary float-right make_pay">Make Payment</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="updateRemark">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title text-bold">Update Remark (Thomas Onyemechi)</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="form-group">
                            <label>Principal Remark</label>
                            <input type="text" name="principal" class="form-control">
                            <input type="hidden" name="id">
                        </div>
                        <div class="form-group">
                            <label>Teacher Remark</label>
                            <input type="text" name="teacher" class="form-control">
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-secondary float-right updateRemark">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="changeImageModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title text-bold">Upload Image</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" class="changeImage" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="hidden" name="id">
                            <input type="file" name="image" class="form-control" accept="image/*"  onchange="loadFile(event)">
                        </div>
                        <p><img id="output" width="200" /></p>
                        <div class="form-group">
                            <button type="submit" class="btn btn-secondary float-right changeImageBtn ">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


   

    

    <script>
        var loadFile = function(event) {
            var image = document.getElementById('output');
            image.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>



        </div>

       <?php include("footer.php"); ?>

        
        <!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="../dist/js/demo.js"></script> -->
<!-- date-range-picker -->
<script src="../plugins/daterangepicker/daterangepicker.js"></script>
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="../plugins/toastr/toastr.min.js"></script>
<!-- Page specific script -->
        <script>
            $(function() {
                $('.select2').select2()
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })
            })
        </script>
        <script>
  <?php if(isset($report)){ echo $Pro->Alert(); } ?>
</script>
        <script>
            $(function() {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                function firstToast(icon="success", message='Done'){
                    Toast.fire({
                        icon: icon,
                        title: message
                    });
                }
            })
        </script>
</body>

</html>
