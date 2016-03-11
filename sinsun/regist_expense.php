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
    <title>지출등록</title>
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
  <script>
        var d = new Date();
        var g_date = '';
        g_date += d.getFullYear();
        g_date += '-';
        g_date += d.getMonth();
        g_date += '-';
        g_date += d.getDate();

        var g_listCount = 1;

  </script>

    <div class="container-fluid">
      <div class="row-fluid"> 
        <div class="span12">
          <div class="form-signin" id="id_sattlement_list">

            <table class="table" id="id_regList">                
                <tr><td><h3>지출등록</h3></td></tr>
                <tr><td><p>날짜 : <input type="date" id="id_reg_date"></p></td></tr>
                <tr><td><input type="button" value="목록추가" id="id_addList"></td><td><input type="button" value="목록삭제" id="id_remove" ></td><td><input type="button" value="지출목록등록"  id="id_btn_trans"></td></tr>                
                <tr id="id_reg_expenseList_0"><td>목록:<input type="text"></td><td>금액:<input type="text"></td></tr>                
             </table>
            

            <table class="table" >
                <tr><td><h3>지출내역보기</h3></td></tr>
                <tr><td><p>날짜 : <input type="date" id="id_list_date"></p></td></tr>
            </table>

            <table class="table" id="id_expenseList">              
            </table>

            </div>
        </div>
      </div>
    </div> <!-- /container -->

    <script>
    // 목록추가
    document.getElementById('id_addList').addEventListener('click', function(event){
      AddList();
    });

    function AddList()
    {
      g_listCount++;

      var append = '';
      append += '<tr id="id_reg_expenseList_'+g_listCount+'"><td>목록:<input type="text" id="id_reg_text_'+g_listCount+'"></td><td>금액:<input type="text" id="id_reg_amount_'+g_listCount+'"></td></tr>';

      $('#id_regList').append(append);      
    }


    // 목록삭제
    document.getElementById('id_remove').addEventListener('click', function(event){
      RemoveList();
    });

    function RemoveList()
    {
      if(g_listCount>1)
      {
        var rm_str = '#id_reg_expenseList_' + g_listCount;
        $(rm_str).remove();

        g_listCount--;
      }
    }

    function SendData()
       {
         if(GetDate()!= '')   // 날짜가 제대로 입력되어 있어야 가능
         {
           if (confirm("전송 하시겠습니까?"))
           {

             var form = document.createElement("form");
             form.setAttribute("method", "POST");
             form.setAttribute("action", "./registExpense.php");

             var obj = new Object();

             obj["date"] = GetDate();

             obj["id"] = <?php echo get_session('ss_mb_id'); ?>;

             for(var key in obj)
             {
               var hiddenField = document.createElement("input");
               hiddenField.setAttribute("type", "hidden");
               hiddenField.setAttribute("name", key);
               hiddenField.setAttribute("value", obj[key]);

               form.appendChild(hiddenField);
             }

             document.body.appendChild(form);

             Send_Req_Data();
             form.submit();
           }else
           {

           }
         }
         else {
           alert("날짜를 제대로 입력해 주세요");
         }
       }

    function SerchData()
    {        
      if(g_date=='')
      {
        alert('날짜를 바르게 입력하세요');
      }
      else
      {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', './sattledata_db.php');

        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        var data = '';
        data += 'date='+ g_date;
        //data += '&month='+ g_month;


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

    function GetDate()  // 날짜구하는 함수
     {
        var _date='';
        _date = document.getElementById("id_reg_date").value;          

        if(_date=='')
        {
          return g_date;            
        }
        else
        {
          g_date = _date;
         
          return g_date;
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