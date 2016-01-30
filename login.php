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

      if (mysql_num_rows($result) == 0)
      {
          //echo "<script>alert(\"데이터 전송 완료!!\");</script>";
          exit;
      }

      $row = mysql_fetch_assoc($result);

      $pw = $row['password'];

      $strCm = strcmp($pw_fromUser, $pw);

      if(strcmp($name, '0001')==0)  // 관리자 로그인
      {
        if($strCm == 0)
        {
          $_SESSION['is_mgr_login'] = true;
          header('Location: ./manager.php');

        }
        else {
          $_SESSION['is_mgr_login'] = false;
          header('Location: ./index.html');
        }

        //echo '0001';
      }
      else
      {    // 관리자 이외의 사람 로그인
        if($strCm == 0)
        {
          // 로그인처리
          $_SESSION['is_casher_login'] = true;
          header('Location: ./dayClose.php');
          //echo '1';
        }
        else
        {
          // 비밀번호 틀림
          $_SESSION['is_casher_login'] = false;
          header('Location: ./index.html');
          //echo '0';
        }
      }




      mysql_free_result($result);

?>
