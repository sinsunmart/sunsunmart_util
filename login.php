<?php
      session_start();

      $name = $_POST['name'];
      $pw_fromUser = $_POST['pw'];



      $conn = mysql_connect("localhost", "root", "95832983");
      mysql_query('SET NAMES utf8');
      if (!$conn)
      {
          echo "Unable to connect to DB: " . mysql_error();
          exit;
      }

      if (!mysql_select_db("sinsunmanager"))
      {
          echo "Unable to select mydbname: " . mysql_error();
          exit;
      }


      //$sql = "SELECT * FROM  closingdata WHERE date='2016-01-22'";
      $sql = "SELECT * FROM  userdata WHERE name='$name'";
      //$query = "select * from test where $o = '$user_search'"

      //echo $sql;


      $result = mysql_query($sql);

      if (!$result)
      {
          echo "Could not successfully run query ($sql) from DB: " . mysql_error();
          exit;
      }

      if (mysql_num_rows($result) == 0)  // user 를 못찾았을때
      {

          $_SESSION['is_2_login'] = false;
          header('Location: ./index.php');


          exit;
      }

      $row = mysql_fetch_assoc($result);

      $pw = $row['password'];

      $strCm = strcmp($pw_fromUser, $pw);

      if(strcmp($name, '0001')==0)  // 관리자 로그인
      {
        if($strCm == 0)  // 비밀번호가 맞으면
        {
          //echo "--1--";
          $_SESSION['is_1_login'] = true;
          header('Location: ./manager.php');
        }
        else {   // 비밀번호 틀림
          //echo "--2--";
          $_SESSION['is_1_login'] = false;
          header('Location: ./index.php');
        }
      }
      else if(strcmp($name, '0002')==0)   // 캐셔 로그인
      {
        if($strCm == 0)  // 비밀번호가 맞으면
        {
          //echo "--3--";
          // 로그인처리
          $_SESSION['is_2_login'] = true;
          header('Location: ./dayClose.php');
        }
        else
        {
          //echo "--4--";
          // 비밀번호 틀림
          $_SESSION['is_2_login'] = false;
          //header('Location: ./index.php');
        }
      }
      else
      {
        echo "<script>alert(\"elseID 나 비밀번호를 확인해 주세요!!\");</script>";
        header('Location: ./index.php');
      }

      mysql_free_result($result);
?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>

</body>
</html>
