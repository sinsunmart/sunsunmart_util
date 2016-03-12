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

$casher_id = get_session('ss_mb_id');
?>

<script>
    var casherId = <?php echo $casher_id ?>;
    var g_worker = '';
</script>

<html lang="en"> <!--2016년1월30일 버전관리시작-->
  <head>
    <meta charset="utf-8">
    <title>근무시간관리</title>
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

        <div class="span12">
          <form class="form-signin" id="form_table" action="http://localhost/test.php" method="POST">
            <div class="bs-docs-example">

            <h3>신선마트 근무시간관리</h3>
            <h5>© Sinsun Corp</h5>  

            <table class="table">
                
                <tr><td>시작날짜 : <input type="date" id="id_date_start"></td></tr>
                <tr><td>종료날짜 : <input type="date" id="id_date_end"></td></tr>

                <tr><td>근무자 : <select id="id_worker" >
                    <option value="">누구?</option>
                    <option value="김윤희">김윤희</option>
                    <option value="0">캐셔1</option>
                </select></td></tr>
                <tr><td>시급 : <input type="number" id="id_payAmount">원</td></tr>
                <tr><td><input type="button" value="결과보기" id="id_excute" onclick="Send_Req_Data()"></td></tr>
                <tr><td><div id="id_worktime_m">근무시간(분): 000 분</div></td></tr>
                <tr><td><div id="id_worktime_h">근무시간(시간): 000 분</div></td></tr>
                <tr><td id="id_payperten">10분당 시급: </td></tr>
                <tr><td><div id="id_payment">급여: 000 원</div></td></tr>
            </table>


            </div>
          </form>

        </div>

      </div>


    </div> <!-- /container -->

    

    <script>
    document.getElementById('id_worker').addEventListener('change', function(event){
                  // 시작 minute
                    g_worker = this.value;
                });

    function CheckDate()
    {
        var d_start = document.getElementById('id_date_start').value;
        var d_end = document.getElementById('id_date_end').value;
        var d_start_arr = d_start.split("-");
        var d_end_arr = d_end.split("-");

        var year_s = d_start_arr[0]*1;
        var month_s = d_start_arr[1]*1;
        var day_s = d_start_arr[2]*1;
        var year_e = d_end_arr[0]*1;
        var month_e = d_end_arr[1]*1;
        var day_e = d_end_arr[2]*1;

        if(year_s>year_e)
            return false;
        else if(year_e == year_s)
        {
            if(month_s>month_e)
                return false;
            else if(month_e==month_s)
            {
                if(day_s>day_e)
                    return false;
                else
                    return true;
            }
            else
                return true;
        }
        else
            return true;
    }

    function GetPay()
    {

    }

    function Send_Req_Data()
    {
        var d_start = '';
        var d_end = '';
        d_start = document.getElementById('id_date_start').value;
        d_end = document.getElementById('id_date_end').value;

        if(d_start=='' || d_end=='' || !CheckDate())
        {
            alert('날짜를 제대로 입력하세요!');
            return 0;
        }

         var xhr = new XMLHttpRequest();

         xhr.open('POST', './get_worktime.php');

         xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");


         var data = '';
         data += 'date_start='+ d_start;
         data += '&date_end='+ d_end;
         if(g_worker=='캐셔')
         {
            data += '&casherId=' + 2;   
         }
         else if(g_worker=='김윤희')
         {
            data += '&casherId=' + 3;
         }
         


         xhr.onreadystatechange = function(){
             if(xhr.readyState === 4 && xhr.status === 200)
               {
                 var g_worktime = xhr.responseText;
                 g_worktime *=1;
                 var h = g_worktime/60;
                 h = Math.round(h);
                 var m_left = g_worktime%60;
                 var m_per = m_left/10;

                 var pay_rate = document.getElementById('id_payAmount').value;
                 pay_rate *=1;  // 시급

                 var rate = pay_rate/6;
                 rate = Math.round(rate);

                 var pay_h = pay_rate * h;
                 var pay_m = rate * m_per;

                 var sum = pay_m + pay_h;

                 document.getElementById('id_worktime_m').innerHTML = '근무시간(분): '+ g_worktime +'분';
                 document.getElementById('id_worktime_h').innerHTML = '근무시간(시간): ' + h + '시간' + m_left + ' 분';
                 document.getElementById('id_payperten').innerHTML = '10분당 시급: '+ rate;

                 var pay = Math.floor(sum/100);

                 document.getElementById('id_payment').innerHTML = '급여 : ' + pay*100 + ' 원';
                 
               }
               else
               {
                 //alert("데이터 전송 실패");
               }
         }


         xhr.send(data);
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