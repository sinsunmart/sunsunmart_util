<?php
    
    $conn = mysql_connect("localhost", "root", "95832983");
    
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

    $date_start_sql = $_POST['date_start'];
    $date_end_sql = $_POST['date_end'];
    $casher_id = $_POST['casherId'];
    
    //$sql = "SELECT time_start, time_end FROM closingdata WHERE date(date) >= '$date_start_sql' AND date(date) <= '$date_end_sql' AND id='$casher_id'";
    $sql = "SELECT time_start, time_end FROM closingdata WHERE date(date) >= '$date_start_sql' AND date(date) <= '$date_end_sql'";
    //$sql = "SELECT time_start, time_end FROM closingdata WHERE date(date) >= '2016-03-01' AND date(date) <= '2016-03-03'";


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

    //$row = mysql_fetch_assoc($result);

    $worktime = 0;

    while($row = mysql_fetch_assoc($result)) 
    {        
        $h = 0;
        $h_start = (int)substr($row['time_start'], 0, 2);  //  hour-start
        $m_start = (int)substr($row['time_start'], 3, 2);  //  minute-start

        $h_end = (int)substr($row['time_end'], 0, 2);  //  hour-end
        $m_end = (int)substr($row['time_end'], 3, 2);  //  minute-end        

        $h = $h_end - $h_start;
        $h = $h * 60;  // 시간을 분으로

        $gap = 0;

        if($m_end >= $m_start)
        {
            $gap = $m_end - $m_start;
            $h += $gap;
        }
        else
        {
            $gap = $m_start - $m_end;
            $h -= $gap;
        }
        
        $worktime += $h;
    }    
    
    echo $worktime;

    mysql_free_result($result);

    //echo('<script>console.log("get_worktime");</script>');
    //echo('<script>console.log("'.$kind_log.' : '.$val.'");</script>');
    
 ?>