<?php
  $source = $_FILES['profile']['tmp_name'];
  $destination = "./img_uploaded/".basename($_FILES['profile']['name']);
  move_uploaded_file($source, $destination);
 ?>

 <!DOCTYPE html>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title></title>
   </head>
   <body>
     <img src="<?=$_FILES['profile']['name']?>" alt="" width=300px/>

   </body>
 </html>
