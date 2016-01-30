<?php
      //echo "dlkfjsdljflsdkfj";

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

      if(strcmp($name, '0001')==0)
      {
        // 주인장 로그인
        echo '0001';
      }
      else {
        if($strCm == 0)
        {
          // 로그인처리
          echo '1';
        }
        else
        {
          // 비밀번호 틀림
          echo '0';
        }
      }




      mysql_free_result($result);

?>
