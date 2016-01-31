
<?php
      session_start();

      $date = $_POST['date'];
      $_50000_sum = $_POST['_50000_sum'];
      $_10000_sum = $_POST['_10000_sum'];
      $_5000_sum = $_POST['_5000_sum'];
      $_1000_sum = $_POST['_1000_sum'];
      $_500_sum = $_POST['_500_sum'];
      $_100_sum = $_POST['_100_sum'];
      $_50_sum = $_POST['_50_sum'];
      $_10_sum = $_POST['_10_sum'];

      $sum_CashCalc = $_POST['sum_CashCalc'];    // 현금소계
      $presentCash = $_POST['presentCash'];      // 현금시제
      $spendList_t_n = $_POST['spendList_t_n'];  // 지출내역 텍스트+금액
      $sum_SpendingCalc = $_POST['sum_SpendingCalc']; // 지출내역합계금액
      $saledCash = $_POST['saledCash'];          // 현금판매
      $overAndShort = $_POST['overAndShort'];    // 과부족
      $deposit = $_POST['deposit'];              // 현금입금
      $memo = $_POST['g_Memo'];                  // 전달사항

      $test = $_POST['test'];
      $id = $_POST['id'];
      //echo testphp;
      //echo $_50000_sum;



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


      $sql = "INSERT INTO `closingdata` VALUES ('{$date}', '{$_50000_sum}', '{$_10000_sum}', '{$_5000_sum}', '{$_1000_sum}', '{$_500_sum}', '{$_100_sum}', '{$_50_sum}', '{$_10_sum}', '{$sum_CashCalc}', '{$presentCash}', '{$spendList_t_n}', '{$sum_SpendingCalc}', '{$saledCash}', '{$overAndShort}', '{$deposit}', '{$memo}', '{$id}')";

      $result = mysql_query($sql);

      if (!$result)
      {
          echo "Could not successfully run query ($sql) from DB: " . mysql_error();
          exit;
      }

      if (mysql_num_rows($result) == 0)
      {
          echo "<script>alert(\"데이터 전송 완료!!\");</script>";
          $_SESSION['datasend_success'] = true;
          header('Location: ./dayClose.php');
          exit;
      }

      // While a row of data exists, put that row in $row as an associative array
      // Note: If you're expecting just one row, no need to use a loop
      // Note: If you put extract($row); inside the following loop, you'll
      //       then create $userid, $fullname, and $userstatus

      //while ($row = mysql_fetch_assoc($result))
      //{
      //    $_50000_sum = $row['spendList_text'];  // 가져오고 싶은 column ID
      //}

      mysql_free_result($result);

?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>

</body>
</html>
