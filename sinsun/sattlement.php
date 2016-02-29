<?php
include_once('../print_log.php');   // Debug log  출력용
include_once('../common.php');

if(defined('DEBUG_MODE_PROCEDURE'))
{
    print_Log('proc_Log', 'dayclose_client.php_start');
    print_Log('member', get_session('ss_mb_id'));    
}

if($is_member || $is_admin)
{}
else
	alert('잘못된 접근입니다!');	

include_once(G5_MOBILE_PATH.'/head.php');
?>

<html lang="en"> <!--2016년1월30일 버전관리시작-->
  <head>
    <meta charset="utf-8">
    <title>결제내역관리</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="bootstrap/css/dayclose.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <!--자바스크립트소스외부파일    <script src="/static/lib/ckeditor/ckeditor.js"></script>  -->


  </head>

  <body>

    <div class="container-fluid">
      <div class="row-fluid">

        <!-- fluid 추가하고 싶으면 밑의 코드를 넣으면 됨
        <div class="span1">
        </div>
      -->
      <script>
      var d = new Date();
        var g_year=d.getFullYear();
        var g_month=d.getMonth();
        var g_id=0;
        var g_client = '';
        var g_sattle_amount=0;
        var g_is_sattled='';

      </script>

        <div class="span12">
          <div class="form-signin" id="id_sattlement_list">
              <table class="table">
                
                <h3>신선마트 결제관리</h3>
                <h5>© Sinsun Corp</h5>
               
                <select id="id_selectBox_year" >
                    <option value="">Year 선택</option>
                    <option value="2015">2015년</option>
                    <option value="2016">2016년</option>
                </select>

                <select id="id_selectBox_month" >
                    <option value="">Month 선택</option>
                    <?php for($i=1;$i<13;$i++) {?>
                    <option value="<?php echo $i ?>"> <?php echo $i.'월';?></option>
                    <?php } ?>
                </select>
                <input type="button" value="조회" id="id_btn_search" onclick="SerchData()">

                <script>
                var year = document.getElementById('id_selectBox_year');
                year.addEventListener('change', function(event){
                    g_year = this.value;
                });

                var month = document.getElementById('id_selectBox_month');
                month.addEventListener('change', function(event){
                    g_month = this.value;
                });
                </script>                

              </table class="table">

              <table class="table" >
              </table>
            </div>
        </div>
      </div>
    </div> <!-- /container -->

    <?php
    // $conn = mysql_connect("localhost", "root", "95832983");
    // //$conn = mysql_connect("52.79.108.63", "root", "95832983");
    // mysql_query('SET NAMES utf8');
    // if (!$conn)
    // {
    //     echo "Unable to connect to DB_!!!: " . mysql_error();
    //     exit;
    // }

    // if (!mysql_select_db("sinsunmanager"))
    // {
    //     echo "Unable to select mydbname: " . mysql_error();
    //     exit;
    // }

    // // $year_sql = $_POST['year'];
    // // $month_sql = $_POST['month'];

    // $year_sql = 2016;
    // $month_sql = 2;

    // $sql = "SELECT * FROM  sattlement WHERE year=$year_sql AND month=$month_sql";
    // //$query = "select * from test where $o = '$user_search'"

    
    // $result = mysql_query($sql);

    // if (!$result)
    // {
    //     echo "Could not successfully run query ($sql) from DB: " . mysql_error();
    //     exit;
    // }

    // if (mysql_num_rows($result) == 0)
    // {
    //     //echo "<script>alert(\"데이터 전송 완료!!\");</script>";
    //     exit;
    // }

    // $row = mysql_fetch_assoc($result);

    // var_dump($row);


    // while ($row = mysql_fetch_assoc($result)) 
    // {
    //     echo $row['id'].'^';                    // 0
    //     echo $row['year'].'^';                  // 1
    //     echo $row['month'].'^';                 // 2
    //     echo $row['client'].'^';                // 3
    //     echo $row['sattle_req_amount'].'^';     // 4
    //     echo $row['sattle_final_amount'].'^';   // 5
    //     echo $row['is_sattled'].'^';            // 6
    //     echo $row['urgent_level'].'^';          // 7
    //     echo $row['comment'].'-';                   // 8
        
    // }


    

    //mysql_free_result($result);
 ?>

    <script>

      function SerchData()
      {
        //alert('year: '+ g_year + 'month:' + g_month);
        if(g_year == '' || g_month=='')
        {
          alert('날짜를 바르게 입력하세요');
        }
        else
        {
          var xhr = new XMLHttpRequest();
          xhr.open('POST', './sattledata_db.php');

          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

          var data = '';
          data += 'year='+ g_year;
          data += '&month='+ g_month;


          xhr.onreadystatechange = function(){
          if(xhr.readyState === 4 && xhr.status === 200)
            {
              //alert('message:' + xhr.responseText);
              var arr_str = '';
              arr_str = xhr.responseText;

              var arr = arr_str.split('-');  // 업체별 데이터


              for(var i=0;i<arr.length;i++)
                {
                    var arr_row = arr[i].split('^');
                    var append = '';
                    append += '<table class="table"><tr><td>거래처거래처:: </td><td class="input-block-level" id="id_client">'+arr_row[3]+'</td></tr>';
                    append += '<tr><td>결제요청금액:: </td><td id="id_req_amount">'+arr_row[4]+'<td></tr>';
                    append += '<tr><td>최종결제금액:: </td><td id="id_is_sattled">'+arr_row[5]+'</td></tr>';
                    append += '<tr><td>결제상황:: </td><td id="id_req_amount">'+arr_row[6]+'<td></tr>';
                    append += '<tr><td>중요도:: </td><td id="id_urgent_level">'+arr_row[7]+'</td></tr>';
                    append += '<tr><td>comment:: </td><td id="id_comment">'+arr_row[8]+'</td></tr>';
                    append += '<tr><td>등록할 결제금액:: </td><td><input type="text" id="id_sattled_amount" placeholder="만원단위"></td></tr>';
                    append += '<tr><td><input type="button" value="결제등록" id="id_btn_submit"></td></tr>';
                    append += '</table>';

                    $('#id_sattlement_list').append(append);
                }

            }
            else
            {
              //document.querySelector('#id_date').innerHTML = 'Error';
            }
          }

          xhr.send(data);
        }

      }
    </script>

    



    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap-transition.js"></script>
    <script src="bootstrap/js/bootstrap-alert.js"></script>
    <script src="bootstrap/js/bootstrap-modal.js"></script>
    <script src="bootstrap/js/bootstrap-dropdown.js"></script>
    <script src="bootstrap/js/bootstrap-scrollspy.js"></script>
    <script src="bootstrap/js/bootstrap-tab.js"></script>
    <script src="bootstrap/js/bootstrap-tooltip.js"></script>
    <script src="bootstrap/js/bootstrap-popover.js"></script>
    <script src="bootstrap/js/bootstrap-button.js"></script>
    <script src="bootstrap/js/bootstrap-collapse.js"></script>
    <script src="bootstrap/js/bootstrap-carousel.js"></script>
    <script src="bootstrap/js/bootstrap-typeahead.js"></script>

  </body>
</html>

<?php
include_once(G5_PATH.'/tail.php');

if(defined('DEBUG_MODE_PROCEDURE'))
{
    print_Log('proc_Log', 'index.php_end');
}
?>