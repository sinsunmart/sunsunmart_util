<?php

    $conn = mysql_connect("localhost", "root", "95832983");
    //$conn = mysql_connect("52.79.108.63", "root", "95832983");
    mysql_query('SET NAMES utf8');
    if (!$conn)
    {
        echo "Unable to connect to DB_!!!: " . mysql_error();
        exit;
    }

    if (!mysql_select_db("sinsunmanager"))
    {
        echo "Unable to select mydbname: " . mysql_error();
        exit;
    }

    $date_sql = $_POST['date'];
    //echo $_POST['date'];

    //$sql = "SELECT * FROM  closingdata WHERE date='2016-01-22'";
    $sql = "SELECT * FROM  closingdata WHERE date='$date_sql'";
    //$query = "select * from test where $o = '$user_search'"

    //echo $sql;


    $result = mysql_query($sql);
    //$result = sql_fetch($sql);

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

    $date = $row['date'];

    $_50000_sum = $row['fiveMan'];  // 가져오고 싶은 column ID
    $_10000_sum = $row['man'];
    $_5000_sum = $row['fiveChun'];
    $_1000_sum = $row['chun'];
    $_500_sum = $row['fiveBaek'];
    $_100_sum = $row['baek'];
    $_50_sum = $row['fiveSip'];
    $_10_sum = $row['sip'];

    $sum_CashCalc = $row['sum_cash'];    // 현금소계
    $presentCash = $row['present_cash'];      // 현금시제
    $spendList_t_n = $row['spendList_text'];  // 지출내역 텍스트+금액
    $sum_SpendingCalc = $row['spendList_sum']; // 지출내역합계금액
    $saledCash = $row['saled_cash'];          // 현금판매
    $overAndShort = $row['overandshort'];    // 과부족
    $deposit = $row['deposit_cash'];              // 현금입금
    $memo = $row['memo'];                  // 전달사항

    $test = $row['test'];
    $id = $row['id'];

    echo $date.'^';
    echo $_50000_sum.'^';
    echo $_10000_sum.'^';
    echo $_5000_sum.'^';
    echo $_1000_sum.'^';
    echo $_500_sum.'^';
    echo $_100_sum.'^';
    echo $_50_sum.'^';
    echo $_10_sum.'^';

    echo $sum_CashCalc.'^';
    echo $presentCash.'^';
    echo $spendList_t_n.'^';
    echo $sum_SpendingCalc.'^';
    echo $saledCash.'^';
    echo $overAndShort.'^';
    echo $deposit.'^';
    echo $memo.'^';
    echo $id;

    mysql_free_result($result);

 ?>
