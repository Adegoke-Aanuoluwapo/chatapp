 <?php
 require("myclass.php");
 
 if(isset($_POST['input'])){
 // echo $pro->searchContact($name);
 $input = $_POST['input'];
 $query = "SELECT * FROM users WHERE name LIKE '{$input}%'";
 $result =mysqli_query($db, $query);
 if(mysqli_num_rows($result)>0) {?>
 <table>
  <thead>
   <tr>
    <th>Id</th>
    <th>Name</th>
    <th>Email</th>

   </tr>
  </thead>
  <?php
  while ($row = mysqli_fetch_assoc($result)) {
   $id = $row["id"];
   $name = $row['name'];
   $email = $row['email'];
  }
  ?>
  <tr>
   <td><?php $id ?></td>
   <td><?php $name ?></td>
   <td><?php $email ?></td>
  </tr>
  </tbody>
 </table>
 }
 }

 