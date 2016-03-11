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
    <title>신선마트일일정산</title>
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
      var g_CasherId;
      var g_Date;             // 날짜
      //화폐단위별 합계금액 변수
      var _50000_sum = 0;
      var _10000_sum = 0;
      var _5000_sum = 0;
      var _1000_sum = 0;
      var _500_sum = 0;
      var _100_sum = 0;
      var _50_sum = 0;
      var _10_sum = 0;

      var sum_CashCalc = 0;   // 동전계수합계 현금소계

      var presentCash = 0;  // 현금시제

      var spendListText;  // 지출내역 텍스트값
      var spendList_t_n;  // 지출내역 텍스트+숫자 합친값
      var sum_SpendingCalc = 0;// 지출내역 합계금액


      var saledCash = 0;    // 현금판매
      var overAndShort = 0; // 과부족
      var deposit = 0;      // 현금입금
      var g_Memo;            // 전달사항

      var addingVal = 0;

      var g_Time = new Date().toLocaleTimeString().substr(3, 5);
      //var g_Time = new Date().toLocaleTimeString();

      var g_Time_Start = '';
      var g_Time_end = '';

      var g_strArr_start  = g_Time_Start.split(':');
      var g_strArr_end  = g_Time_end.split(':');             
    </script>

    <div class="container-fluid">
      <div class="row-fluid">

        <!-- fluid 추가하고 싶으면 밑의 코드를 넣으면 됨
        <div class="span1">
        </div>
      -->

        <div class="span12">
          <form class="form-signin" id="form_table" action="" method="POST">
            <div class="bs-docs-example">
              <table class="table">
                
                <h3>신선마트 일일정산시스템</h3>
                <h5>© Sinsun Corp</h5>
               

                <p>날짜 : <input type="date" name="n_date" onfocusout="GetDate()"></p>

                <!--  근무시간 선택 -->
                <p>근무시작시간</p>
                <select id="id_hour_start" >
                    <option value="">몇시</option>
                    <?php for($i=8;$i<25;$i++) {?>
                    <option value="<?php echo $i ?>"> <?php echo $i.'시';?></option>
                    <?php } ?>
                </select>

                <select id="id_minute_start" >
                    <option value="">몇분</option>
                    <option value="00">00분</option>
                    <option value="10">10분</option>
                    <option value="20">20분</option>
                    <option value="30">30분</option>
                    <option value="40">40분</option>
                    <option value="50">50분</option>

                </select>

                <p>근무종료시간</p>
                <select id="id_hour_end" >
                    <option value="">몇시</option>
                    <?php for($i=8;$i<25;$i++) {?>
                    <option value="<?php echo $i ?>"> <?php echo $i.'시';?></option>
                    <?php } ?>
                </select>

                <select id="id_minute_end" >
                    <option value="">몇분</option>
                    <option value="00">00분</option>
                    <option value="10">10분</option>
                    <option value="20">20분</option>
                    <option value="30">30분</option>
                    <option value="40">40분</option>
                    <option value="50">50분</option>

                </select>

                <script>
                // 시작시간
                document.getElementById('id_hour_start').addEventListener('change', function(event){
                  // 시작 hour                  
                    g_strArr_start[0] = this.value;
                });

                document.getElementById('id_minute_start').addEventListener('change', function(event){
                  // 시작 minute
                    g_strArr_start[1] = this.value;
                });

                // 종료시간
                document.getElementById('id_hour_end').addEventListener('change', function(event){
                  // 시작 hour                  
                    g_strArr_end[0] = this.value;
                });

                document.getElementById('id_minute_end').addEventListener('change', function(event){
                  // 시작 minute
                    g_strArr_end[1] = this.value;
                });


                </script> 
                <!--  근무시간 선택 끝 -->

                <thead><tr><th>현금계수</th><th>수량</th><th>금액</th></tr></thead>
                <tbody>

                  <tr><td>5만원권</td><td><input type="text" class="input-block-level" name="_50000_input" placeholder="입력" onfocusout="CalcFocusOut(50000)"></td><td><div name="_50000_sum">금액</div></td></tr>
                  <tr><td>만원권</td><td><input type="text" class="input-block-level" name="_10000_input" placeholder="입력" onfocusout="CalcFocusOut(10000)"></td><td><div name="_10000_sum">금액</div></td></tr>
                  <tr><td>5천원권</td><td><input type="text" class="input-block-level" name="_5000_input" placeholder="입력" onfocusout="CalcFocusOut(5000)"></td><td><div name="_5000_sum">금액</div></td></tr>
                  <tr><td>천원권</td><td><input type="text" class="input-block-level" name="_1000_input" placeholder="입력" onfocusout="CalcFocusOut(1000)"></td><td><div name="_1000_sum">금액</div></td></tr>
                  <tr><td>5백원권</td><td><input type="text" class="input-block-level" name="_500_input" placeholder="입력" onfocusout="CalcFocusOut(500)"></td><td><div name="_500_sum">금액</div></td></tr>
                  <tr><td>백원권</td><td><input type="text" class="input-block-level" name="_100_input" placeholder="입력" onfocusout="CalcFocusOut(100)"></td><td><div name="_100_sum">금액</div></td></tr>
                  <tr><td>5십원권</td><td><input type="text" class="input-block-level" name="_50_input" placeholder="입력" onfocusout="CalcFocusOut(50)"></td><td><div name="_50_sum">금액</div></td></tr>
                  <tr><td>십원권</td><td><input type="text" class="input-block-level" name="_10_input" placeholder="입력" onfocusout="CalcFocusOut(10)"></td><td><div name="_10_sum">금액</div></td></tr>


                <tr><td>현금소계</td><td><div name="sum" id="won_unit">합계금액</div></td><td></td></tr></br></br></br></br>
                </tbody>
              </table>

              <table class="table" id="table_presentCash">

                <tr><td>현금시제</td><td><input class="input-block-level" type="text" name="present_cash" placeholder="입력"></td></tr>

              </table>

              <!-- 현금지출내역 리스트 테이블 -->
              <table class="table" id="spendingListTable">

                <thead><tr><th>현금지출내역</th><th>지출금액</th></tr></thead>

                <tr><td>지출소계</td><td><div id="id_spend_sum" name="spendingMoneyValue">합계금액</div></td><td></td></tr>
                
                <tr><td><input type="button" id="id_addList" value="목록추가"></td><td><input type="button" id="id_remove" value="목록삭제"></td></tr>
                <tr id="spendingListTable_0"><td>목록:<input type="text" id="id_spend_text_0"></td><td>금액:<input type="text" id="id_spend_money_0" onfocusout="GetSpendListMoney()"></td></tr>
                <script>

                // 목록추가
                document.getElementById('id_addList').addEventListener('click', function(event){
                  AddList();
                });

                function AddList()
                {
                  addingVal++;

                  var append = '';
                  append += '<tr id="spendingListTable_'+addingVal+'"><td>목록:<input type="text" id="id_spend_text_'+addingVal+'"></td><td>금액:<input type="text" id="id_spend_money_'+addingVal+'" onfocusout="GetSpendListMoney()"></td></tr>';

                  $('#spendingListTable').append(append);                     
                }


                // 목록삭제
                document.getElementById('id_remove').addEventListener('click', function(event){
                  RemoveList();
                });

                function RemoveList()
                {
                  if(addingVal>0)
                  {
                    var rm_str = '#spendingListTable_' + addingVal;
                    $(rm_str).remove();

                    addingVal--;                    
                  }
                }

                </script>

              </table>

              <table class="table" id="table_calc">
                <tr><td><div>현금판매(현금시제-지출소계) : <input class="input-block-level" type="button" onclick="GetSaledAmount()" value="Get"></div></td><td><div name="saledAmount">현금판매</div></td></tr>
                <tr><td><div>과부족(현금판매-현금소계) : <input class="input-block-level" type="button" onclick="GetOverandShort()" value="Get"></div></td><td><div name="n_overAndShort">과부족</div></td></tr>
                <tr><td><div>현금입금 : <input class="input-block-level" type="button" onclick="GetCashDeposit()" value="Get"></div></td><td><div name="cashDeposit">현금입금</div></td></tr>
                <tr><td>메모:<input class="input-block-level" type"textarea" name="textarea" onkeyup="resize(this)" onfocusout="GetMemo()"></td></tr>
                <tr><td><input class="input-block-level" type="button" name="" onclick="PageReload()" value="전체초기화"></td><td><input class="input-block-level" type="button" onclick="SendData_DB()" name="" value="전송"></td></tr>

              </table>

            </div>

          </form>



        </div>

      </div>


    </div> <!-- /container -->

    <script type="text/javascript">
      function GetSpendListMoney()
       {
        var val_input=0;

        sum_SpendingCalc = 0;
        

        for(var i=0; i<addingVal+1; i++)
        { 

          val_input = document.getElementById('id_spend_money_'+i).value;

          if(isNaN(val_input))  // 숫자가 아니면
          {
            alert('숫자만 입력 가능합니다');
            
            return sum_SpendingCalc;
          }

          val_input = val_input*1; // 숫자로 만들어주기

          // 지출금액 입력란 값 가져오기
          sum_SpendingCalc += val_input;
        }

        // 지출금액 합계 표시하기
        document.getElementById('id_spend_sum').innerHTML = sum_SpendingCalc;

        return sum_SpendingCalc;

       }

       function GetSpendListText()   // 데이터 전송시 지출내역 텍스트값과 지출금액을 합해서 리턴해주는 함수
       {
          
          spendListText = " ";
          spendList_t_n = " ";

          var val_input;

          sum_SpendingCalc = 0;

          for(var i=0; i<addingVal+1; i++)
          {
            var str_spendList = " ";

            str_spendList = document.getElementById('id_spend_text_'+i).value;

            // 지출금액 입력란 텍스트값 가져오기
            spendListText += str_spendList;
            spendListText += ",";

            // 지출금액 입력란 숫자값 가져오기
            val_input = document.getElementById('id_spend_money_'+i).value;
            val_input = val_input*1; // 숫자로 만들어주기
            sum_SpendingCalc += val_input;

            // 지출내역 텍스트+숫자 합친값 구하기
            spendList_t_n += str_spendList;
            spendList_t_n += val_input;
            spendList_t_n += ",";
          }

          //return spendListText;
          return spendList_t_n;

       }

      function CalcFocusOut(val)
       {
         var amount = document.getElementsByName('_'+val+'_input');
         var changeValue = amount[0].value * val;

         switch(val)
         {
            case 50000:
                _50000_sum = changeValue;
                break;
            case 10000:
                _10000_sum = changeValue;
                break;
            case 5000:
                _5000_sum = changeValue;
                break;
            case 1000:
                _1000_sum = changeValue;
                break;
            case 500:
                _500_sum = changeValue;
                break;
            case 100:
                _100_sum = changeValue;
                break;
            case 50:
                _50_sum = changeValue;
                break;
            case 10:
                _10_sum = changeValue;
                break;
        }

         // 화폐단위별 합계금액
         document.getElementsByName('_'+val+'_sum')[0].innerHTML = changeValue+' 원';

         // 합계
         sum_CashCalc = 0;
         sum_CashCalc = _50000_sum + _10000_sum + _5000_sum + _1000_sum + _500_sum + _100_sum + _50_sum + _10_sum;

         document.getElementsByName('sum')[0].innerHTML = '합계금액 : ' + sum_CashCalc + ' 원';

       }

       function GetCashSum()
       {
         sum_CashCalc = 0;
         sum_CashCalc = _50000_sum + _10000_sum + _5000_sum + _1000_sum + _500_sum + _100_sum + _50_sum + _10_sum;

         document.getElementsByName('sum')[0].innerHTML = '합계금액 : ' + sum_CashCalc + ' 원';
         return sum_CashCalc;
       }

       function GetSaledAmount()    // 현금판매 구하는 함수
       {
         // 현금시제present_cash
         presentCash = (document.getElementsByName('present_cash')[0].value)*1;

         // 현금판매
         saledCash = presentCash-sum_SpendingCalc; // 현금시제-지출소계

         document.getElementsByName('saledAmount')[0].innerHTML = saledCash*1;

         return saledCash;
       }

       function GetOverandShort()   // 과부족 구하는 함수
       {
         overAndShort = sum_CashCalc - saledCash; //현금판매-현금소계
         document.getElementsByName('n_overAndShort')[0].innerHTML = overAndShort*1;
         return overAndShort;
       }

       function GetCashDeposit()   // 현금입금 구하는 함수
       {
         var bigCash = _50000_sum + _10000_sum;
         var deposit = (bigCash*1) - 100000;    // 10만원을 차감한 나머지 만원권 입금

         document.getElementsByName('cashDeposit')[0].innerHTML = deposit*1;
         return deposit;
       }

       function GetDate()  // 날짜구하는 함수
       {
          var strDate = document.getElementsByName("n_date")[0].value;

          g_Date = strDate;    // 날짜

          return g_Date;
       }

       function GetMemo()
       {
         //alert("memo:"+ document.getElementsByName('textarea')[0].value);
         g_Memo = document.getElementsByName('textarea')[0].value;
         return g_Memo;
       }

       function GetPresentCash()
       {
         var p_cash = document.getElementsByName('present_cash')[0].value;
         return p_cash;
       }

       function SendData_DB()
       {

         if(GetDate()!= '')   // 날짜가 제대로 입력되어 있어야 가능
         {
           if (confirm("전송 하시겠습니까?"))
           {

             var form = document.createElement("form");
             form.setAttribute("method", "POST");
             form.setAttribute("action", "./sendData.php");

             var obj = new Object();

             obj["date"] = GetDate();

             // 마감하는 시간
             var d = new Date();
             var time = '';
             time += d.getHours();
             time += ':';
             time += d.getMinutes();
             time += ':';
             time += d.getSeconds();

             obj['closing_time'] = time;

             //근무시간구하기
             g_Time_Start='';
             g_Time_end='';
             g_Time_Start +=g_strArr_start[0];
             g_Time_Start +=':';
             g_Time_Start +=g_strArr_start[1];
             g_Time_Start +=':00';
             g_Time_end += g_strArr_end[0];
             g_Time_end +=':';
             g_Time_end += g_strArr_end[1];
             g_Time_end += ':00';

                

             obj["time_start"] = g_Time_Start;

             obj["time_end"] = g_Time_end;

             obj["sum_CashCalc"] = GetCashSum();

             obj["presentCash"] = GetPresentCash();

             obj["spendList_t_n"] = GetSpendListText();

             obj["sum_SpendingCalc"] = GetSpendListMoney();

             obj["saledCash"] = GetSaledAmount();

             obj["overAndShort"] = GetOverandShort();

             obj["deposit"] = GetCashDeposit();

             obj["g_Memo"] = GetMemo();

             obj["_50000_sum"] = _50000_sum;
             obj["_10000_sum"] = _10000_sum;
             obj["_5000_sum"] = _5000_sum;
             obj["_1000_sum"] = _1000_sum;
             obj["_500_sum"] = _500_sum;
             obj["_100_sum"] = _100_sum;
             obj["_50_sum"] = _50_sum;
             obj["_10_sum"] = _10_sum;

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

       function Send_Req_Data()
       {

         var xhr = new XMLHttpRequest();

         xhr.open('POST', './login.php');

         xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");


         var data = '1';
         //data += 'name='+ id;

         //alert('data:'+data);


         xhr.onreadystatechange = function(){
         if(xhr.readyState === 4 && xhr.status === 200)
           {
             var arr_str = xhr.responseText;

             if(arr_str = 'ok')
             {
               alert("데이터 전송 완료");               
             }
           }
           else
           {
             //alert("데이터 전송 실패");
           }

         }

         xhr.send(data);
       }

       function Reset()
       {
       }

       function resize(obj)
       {
        obj.style.height = "1px";
        obj.style.height = (20+obj.scrollHeight)+"px";
       }

       function PageReload()
       {
         location.reload(true);
       }

       function chkTime(obj)   // 시간입력이 올바른가 검사하는 함수
       { 
          var input = obj.value.replace(/:/g,""); 
          var inputHours = input.substr(0,2); 
          var inputMinutes = input.substr(2,2); 
          var inputSeconds = input.substr(4,2); 
          var resultTime = new Date(0,0,0, inputHours, inputMinutes, inputSeconds); 
          if ( resultTime.getHours() != inputHours || 
          resultTime.getMinutes() != inputMinutes || 
          resultTime.getSeconds() != inputSeconds) { 
          obj.value = ""; 
          } else { 
          obj.value = inputHours + ":" + inputMinutes + ":" + inputSeconds; 
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