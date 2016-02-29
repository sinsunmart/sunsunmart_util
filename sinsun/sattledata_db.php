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

    $year_sql = $_POST['year'];
    $month_sql = $_POST['month'];

    $sql = "SELECT * FROM  sattlement WHERE year=$year_sql AND month=$month_sql";
    //$query = "select * from test where $o = '$user_search'"

    
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

    while ($row = mysql_fetch_assoc($result)) 
    {
        echo $row['id'].'^';                    // 0
        echo $row['year'].'^';                  // 1
        echo $row['month'].'^';                 // 2
        echo $row['client'].'^';                // 3
        echo $row['sattle_req_amount'].'^';     // 4
        echo $row['sattle_final_amount'].'^';   // 5
        echo $row['is_sattled'].'^';            // 6
        echo $row['urgent_level'].'^';          // 7
        echo $row['comment'].'-';                   // 8
        
    }    

    mysql_free_result($result);
 ?>
