
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>신선마트일일정산</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {

        max-width: 600px;
        padding: 19px 29px 29px;

        background-color: #C3C1C1;
        border: 2px solid #686161;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        max-width: 100px;
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

      #won_unit{
        margin-top: 10px;
        background:#A39A9A;
        line-height: 200%;

        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }

      .span1{
        background-color: #F16C6C;
      }

      .span3{
        text-align: right;
        background-color: #F16C6C;
        padding-top: 10px;
        margin-right: 0px;
        font-size: 26px;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }

      .span8{
        background-color: #F16C6C;
      }

      .table{
        border-top:  2px solid #686161;
        border-bottom: :  2px solid #686161;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }

      .textarea{
        width:500px;

      }


    </style>
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <!--자바스크립트소스외부파일    <script src="/static/lib/ckeditor/ckeditor.js"></script>  -->


  </head>

  <body>
    <script>

      var g_CasherId;
      var g_Date;             // 날짜
      //화폐단위별 합계금액 변수
      var _50000_sum = 23;
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

      var addingVal = 1;

    </script>

    <div class="container-fluid">
      <div class="row-fluid">

        <!-- fluid 추가하고 싶으면 밑의 코드를 넣으면 됨
        <div class="span1">
        </div>
      -->

        <div class="span12">
          <form class="form-signin" id="form_table" action="http://localhost/test.php" method="POST">
            <div class="bs-docs-example">
              <table class="table">
                <h1>신선마트</h1>
                <h3>일일정산시스템</h3>
                <h5>© Sinsun Corp</h5>
                <h5><div name="put_id">casher ID</div></h5>
                <p>날짜 : <input type="date" name="n_date" onfocusout="GetDate()"><br/></p>

                <script>
                var temp=location.href.split("?");
                var data=temp[1].split(":");
                var g_CasherId=data[1];
                g_CasherId = g_CasherId*1;
                if(g_CasherId===2)
                {
                  document.getElementsByName('put_id')[0].innerHTML = "캐셔: " + "임중민";
                }
                else {
                  alert("Wrong");
                }
                // thead
                document.write('<thead><tr><th>현금계수</th><th>수량</th><th>금액</th></tr></thead>');
                document.write('<tbody>');

                // 동전계수
                document.write('<tr><td>5만원권</td><td><input type="text" class="input-block-level" name="_50000_input" placeholder="입력" onfocusout="CalcFocusOut(50000)"></td><td><div name="_50000_sum">금액</div></td></tr>');
                document.write('<tr><td>만원권</td><td><input type="text" class="input-block-level" name="_10000_input" placeholder="입력" onfocusout="CalcFocusOut(10000)"></td><td><div name="_10000_sum">금액</div></td></tr>');
                document.write('<tr><td>5천원권</td><td><input type="text" class="input-block-level" name="_5000_input" placeholder="입력" onfocusout="CalcFocusOut(5000)"></td><td><div name="_5000_sum">금액</div></td></tr>');
                document.write('<tr><td>천원권</td><td><input type="text" class="input-block-level" name="_1000_input" placeholder="입력" onfocusout="CalcFocusOut(1000)"></td><td><div name="_1000_sum">금액</div></td></tr>');
                document.write('<tr><td>5백원권</td><td><input type="text" class="input-block-level" name="_500_input" placeholder="입력" onfocusout="CalcFocusOut(500)"></td><td><div name="_500_sum">금액</div></td></tr>');
                document.write('<tr><td>백원권</td><td><input type="text" class="input-block-level" name="_100_input" placeholder="입력" onfocusout="CalcFocusOut(100)"></td><td><div name="_100_sum">금액</div></td></tr>');
                document.write('<tr><td>5십원권</td><td><input type="text" class="input-block-level" name="_50_input" placeholder="입력" onfocusout="CalcFocusOut(50)"></td><td><div name="_50_sum">금액</div></td></tr>');
                document.write('<tr><td>십원권</td><td><input type="text" class="input-block-level" name="_10_input" placeholder="입력" onfocusout="CalcFocusOut(10)"></td><td><div name="_10_sum">금액</div></td></tr>');

                document.write('<tr><td>현금소계</td><td><div name="sum" id="won_unit">합계금액</div></td><td></td></tr></br></br></br></br>');



                document.write('</tbody>');
                </script>
              </table>

              <table class="table" id="table_presentCash">
                <script>
                // 현금시제
                document.write('<tr><td>현금시제</td><td><input type="text" name="present_cash" placeholder="입력"></td></tr>');
                </script>
              </table>

              <!-- 현금지출내역 리스트 테이블 -->
              <table class="table" id="spendingListTable">
                <script>
                // thead
                document.write('<thead><tr><th>현금지출내역</th><th>지출금액</th></tr></thead>');
                document.write('<tbody>');

                //지출소계
                document.write('<tr><td>지출소계</td><td><div id="won_unit" name="spendingMoneyValue">합계금액</div></td><td></td></tr>');
                document.write('</tbody>');

                // 현금지출내역 리스트시작
                //document.write('<tr id="spendingListTable'+addingVal+'"><td><input type="text" name="spendingListTag_text'+addingVal+'"></td><td><input type="text" name="spendingListTag_money'+addingVal+'"></td><td><div name="spendingMoneyValue'+addingVal+'">금액</div></td></tr>');
                document.write('<tr id="spendingListTable'+addingVal+'"><td><input type="text" name="spendingListTag_text'+addingVal+'"></td><td><input type="text" name="spendingListTag_money'+addingVal+'" onfocusout="SpendListFocusOut(addingVal)"></td></tr>');

                // 목록추가, 목록삭제버튼
                // onclick 함수 인자로 1을주면 목록추가, 2을 주면 목록삭제
                document.write('<tr><td><input type="button" name="add_btn" value="목록추가" onclick="AddSpendingList(1)"></td><td><input type="button" name="del_btn"  value="목록삭제" onclick="AddSpendingList(2)"></td></tr>');  // onclick 함수 인자로 1을 주면 목록추가


                </script>

              </table>

              <table class="table" id="table_calc">
                <tr><td><div>현금판매(현금시제-지출소계) : <input type="button" onclick="GetSaledAmount()" value="Get"></div></td><td><div name="saledAmount">현금판매</div></td></tr>
                <tr><td><div>과부족(현금판매-현금소계) : <input type="button" onclick="GetOverandShort()" value="Get"></div></td><td><div name="n_overAndShort">과부족</div></td></tr>
                <tr><td><div>현금입금 : <input type="button" onclick="GetCashDeposit()" value="Get"></div></td><td><div name="cashDeposit">현금입금</div></td></tr>
                <tr><td>메모:<input type"textarea" name="textarea" onkeyup="resize(this)" onfocusout="GetMemo()"></td></tr>
                <tr><td><input type="button" name="" onclick="PageReload()" value="전체초기화"></td><td><input type="button" onclick="SendData_DB()" name="" value="전송"></td></tr>

              </table>

            </div>

          </form>



        </div>

      </div>


    </div> <!-- /container -->

    <script type="text/javascript">

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

       function AddSpendingList(v)  // 인자로 1이 들어오면 목록추가, 2가 들어오면 목록삭제
       {
         //spendingListTag_money


         if(v==1) // 목록추가
         {
           //alert(GetSpendListText()); 테스트용
           // 테이블 추가
           addingVal += 1;

           var insert_str_Id = "#spendingListTable";

           var inser_str_tag='<tr id="spendingListTable'+addingVal+'"><td><input type="text" name="spendingListTag_text'+addingVal+'"></td><td><input type="text" name="spendingListTag_money'+addingVal+'" onfocusout="SpendListFocusOut(addingVal)"></td></tr>';
           //var inser_str_tag='<tr id="spendingListTable'+addingVal+'"><td><input type="text" name="spendingListTag_text'+addingVal+'"></td><td><input type="text" name="spendingListTag_money'+addingVal+'"></td><td><div name="spendingMoneyValue'+addingVal+'">금액</div></td></tr>';

           $(insert_str_Id).append(inser_str_tag);
         }
         else if(v==2) // 목록삭제
         {
           if(addingVal>1)
           {
             var str_addedList = "#spendingListTable" + addingVal;
             //var str_addedList_money = "#spendingListTag_money" + addingVal;
             $(str_addedList).remove();
             //$(str_addedList_money).remove();
             addingVal -=1;

             // 합계금액 초기화
             sum_SpendingCalc = 0;
             var val_calc=0;

             for(var i=1; i<addingVal+1; i++)
             {
               val_calc = document.getElementsByName('spendingListTag_money'+i)[0].value;

               val_calc = val_calc*1; // 숫자로 만들어주기

               // 지출금액 입력란 값 가져오기
               sum_SpendingCalc += val_calc;
             }

             // 지출금액 합계 표시하기
             document.getElementsByName('spendingMoneyValue')[0].innerHTML = sum_SpendingCalc;
           }
         }


       }

       function SpendListFocusOut(value_adding)
       {
         if(addingVal>0)
         {
           var val_input=0;

           sum_SpendingCalc = 0;

           if(!isNaN(document.getElementsByName('spendingListTag_money'+addingVal)[0].value))  // 숫자만 입력가능합니다
            {
              for(var i=1; i<addingVal+1; i++)
              {
                val_input = document.getElementsByName('spendingListTag_money'+i)[0].value;

                val_input = val_input*1; // 숫자로 만들어주기

                // 지출금액 입력란 값 가져오기
                sum_SpendingCalc += val_input;
              }

              // 지출금액 합계 표시하기
              document.getElementsByName('spendingMoneyValue')[0].innerHTML = sum_SpendingCalc;
            }
            else
            {

              alert('숫자만 입력 가능합니다');
              event.returnValue = false;
              return;
            }

         }
       }

       // 데이터 전송시 지출내역 텍스트값과 지출금액을 합해서 리턴해주는 함수
       function GetSpendListText()
       {
          // name: spendingListTag_text + addingVal
          spendListText = " ";
          spendList_t_n = " ";

          var val_input;

          sum_SpendingCalc = 0;

          for(var i=1; i<addingVal+1; i++)
          {
            var str_spendList = " ";

            str_spendList = document.getElementsByName('spendingListTag_text'+i)[0].value;

            // 지출금액 입력란 텍스트값 가져오기
            spendListText += str_spendList;
            spendListText += ",";

            // 지출금액 입력란 숫자값 가져오기
            val_input = document.getElementsByName('spendingListTag_money'+i)[0].value;
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

       function GetSaledAmount()
       {
         /*
         var sum_SpendingCalc = 0; // 지출내역 합계금액
         var presentCash = 0;  // 현금시제
         var saledCash = 0;    // 현금판매
         var overAndShort = 0; // 과부족
         var deposit = 0;      // 현금입금
         */
         // 현금시제present_cash
         presentCash = (document.getElementsByName('present_cash')[0].value)*1;

         //alert("val:"+val_present_cash);
         //alert("spend:"+spend);

         // 현금판매
         saledCash = presentCash-sum_SpendingCalc; // 현금시제-지출소계

         document.getElementsByName('saledAmount')[0].innerHTML = saledCash*1;
       }

       function GetOverandShort()
       {
         overAndShort = sum_CashCalc - saledCash; //현금판매-현금소계
         document.getElementsByName('n_overAndShort')[0].innerHTML = overAndShort*1;
       }

       function GetCashDeposit()
       {
         var bigCash = _50000_sum + _10000_sum;
         var deposit = (bigCash*1) - 100000;    // 10만원을 차감한 나머지 만원권 입금

         document.getElementsByName('cashDeposit')[0].innerHTML = deposit*1;
         return deposit;
       }

       function GetDate()
       {
          var strDate = document.getElementsByName("n_date")[0].value;
          var arr = strDate.split('-');

          g_Date = strDate;    // 날짜

       }

       function SendData_DB()
       {
         if (confirm("전송 하시겠습니까?"))
         {
           var form = document.createElement("form");
           form.setAttribute("method", "POST");
           form.setAttribute("action", "/sendData.php");

           var obj = new Object();

           obj["date"] = g_Date;
           obj["_50000_sum"] = _50000_sum;
           obj["_10000_sum"] = _10000_sum;
           obj["_5000_sum"] = _5000_sum;
           obj["_1000_sum"] = _1000_sum;
           obj["_500_sum"] = _500_sum;
           obj["_100_sum"] = _100_sum;
           obj["_50_sum"] = _50_sum;
           obj["_10_sum"] = _10_sum;

           obj["sum_CashCalc"] = sum_CashCalc;
           obj["presentCash"] = presentCash;
           obj["spendList_t_n"] = GetSpendListText();
           obj["sum_SpendingCalc"] = sum_SpendingCalc;
           obj["saledCash"] = saledCash;
           obj["overAndShort"] = overAndShort;
           obj["deposit"] = GetCashDeposit();
           obj["g_Memo"] = g_Memo;
           obj["id"] = g_CasherId;

           for(var key in obj)
           {
             var hiddenField = document.createElement("input");
             hiddenField.setAttribute("type", "hidden");
             hiddenField.setAttribute("name", key);
             hiddenField.setAttribute("value", obj[key]);

             form.appendChild(hiddenField);
           }

           document.body.appendChild(form);

           form.submit();
         }else
         {

         }


       }

       function GetMemo()
       {
         //alert("memo:"+ document.getElementsByName('textarea')[0].value);
         g_Memo = document.getElementsByName('textarea')[0].value;
       }

       function Reset()
       {

         g_Date  = "2016-04-21";             // 날짜
         document.getElementsByName("n_date")[0].value = g_Date;
         //화폐단위별 합계금액 변수
         _50000_sum = 100000;
         _10000_sum = 250000;
         _5000_sum = 120000;
         _1000_sum = 45000;
         _500_sum = 34000;
         _100_sum = 3400;
         _50_sum = 4300;
         _10_sum = 450;

         // 화폐단위별 합계금액
         document.getElementsByName('_50000_sum')[0].innerHTML = _50000_sum +' 원';
         document.getElementsByName('_10000_sum')[0].innerHTML = _10000_sum + ' 원';
         document.getElementsByName('_5000_sum')[0].innerHTML = _5000_sum + ' 원';
         document.getElementsByName('_1000_sum')[0].innerHTML = _1000_sum + ' 원';
         document.getElementsByName('_500_sum')[0].innerHTML = _500_sum + ' 원';
         document.getElementsByName('_100_sum')[0].innerHTML = _100_sum + ' 원';
         document.getElementsByName('_50_sum')[0].innerHTML = _50_sum + ' 원';
         document.getElementsByName('_10_sum')[0].innerHTML = _10_sum + ' 원';

         // 합계
         sum_CashCalc = 0;
         sum_CashCalc = _50000_sum + _10000_sum + _5000_sum + _1000_sum + _500_sum + _100_sum + _50_sum + _10_sum;

         document.getElementsByName('sum')[0].innerHTML = '합계금액 : ' + sum_CashCalc + ' 원';

         // 현금시제
         presentCash = 525800;  // 현금시제
         document.getElementsByName('present_cash')[0].value = presentCash;


         spendListText;  // 지출내역 텍스트값
         spendList_t_n;  // 지출내역 텍스트+숫자 합친값
         sum_SpendingCalc = 0;// 지출내역 합계금액


         saledCash = 0;    // 현금판매
         overAndShort = 0; // 과부족
         deposit = 0;      // 현금입금

         sum_CashCalc = 0;   // 동전계수합계 현금소계

         presentCash = 0;  // 현금시제
         sum_SpendingCalc = 0;// 지출내역 합계금액

         saledCash = 0;    // 현금판매
         overAndShort = 0; // 과부족

         addingVal = 1;
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
