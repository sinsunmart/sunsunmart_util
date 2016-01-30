
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>신선마트관리자</title>
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

      #id_cashSpendSum{
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
      var g_Date = '<?=$date?>';             // 날짜
      //화폐단위별 합계금액 변수
      var _50000_sum = '<?=$_50000_sum?>';
      var _10000_sum = '<?=$_10000_sum?>';
      var _5000_sum = '<?=$_5000_sum?>';
      var _1000_sum = '<?=$_1000_sum?>';
      var _500_sum = '<?=$_500_sum?>';
      var _100_sum = '<?=$_100_sum?>';
      var _50_sum = '<?=$_50_sum?>';
      var _10_sum = '<?=$_10_sum?>';

      var sum_CashCalc = '<?=$sum_CashCalc?>';   // 동전계수합계 현금소계

      var presentCash = '<?=$presentCash?>';  // 현금시제

      var spendListText;  // 지출내역 텍스트값
      var spendList_t_n = '<?=$spendList_t_n?>';  // 지출내역 텍스트+숫자 합친값
      var sum_SpendingCalc = '<?=$sum_SpendingCalc?>';// 지출내역 합계금액


      var saledCash = '<?=$saledCash?>';    // 현금판매
      var overAndShort = '<?=$overAndShort?>'; // 과부족
      var deposit = '<?=$deposit?>';      // 현금입금
      var g_Memo = '<?=$memo?>';            // 전달사항

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
              <table class="table" id="table_cashCalc">
                <h1>신선마트 Manager Page</h1>
                <h3>일일정산시스템</h3>
                <h5>© Sinsun Corp</h5>
                <h5><div id="id_CasherId">Casher ID</div></h5>

                <p>날짜 : <input type="date" id="id_date" onfocusout=""><br/></p>
                <input type="button" onclick="ExcuteData()" value="Excute"/></br>
                <p>선택된날짜 : <div  id="id_date_show"><div/></p>


                <tr id="id_50000_tr"></tr>
                <tr id="id_10000_tr"></tr>
                <tr id="id_5000_tr"></tr>
                <tr id="id_1000_tr"></tr>
                <tr id="id_500_tr"></tr>
                <tr id="id_100_tr"></tr>
                <tr id="id_50_tr"></tr>
                <tr id="id_10_tr"></tr>

                <script src="/srcFile/js/ShowCashCalc.js"></script>

                <tr><td>현금소계</td><td><div name="sum" id="id_cashSum">합계금액</div></td></tr>

              </table>

              <table class="table" id="table_presentCash">

                <tr><td>현금시제</td><td><div  id="id_presentCash" name="present_cash" >얼마</div></dt></tr>
              </table>

              <!-- 현금지출내역 리스트 테이블 -->
              <table class="table" id="spendingListTable">
                <thead><tr><th>현금지출내역</th><th>지출금액</th></tr></thead>
                <tbody>
                  <tr><td id="id_spendList">지출소계</td><td><div id="id_cashSpendSum" name="spendingMoneyValue">합계금액</div></td><td></td></tr>

                </tbody>

              </table>

              <table class="table" id="table_calc">
                <tr><td><div>현금판매(현금시제-지출소계) : </div></td><td><div id="id_cashSaled" name="saledAmount">현금판매금액</div></td></tr>
                <tr><td><div>과부족(현금판매-현금소계) : </div></td><td><div id="id_overandshort" name="n_overAndShort">과부족금액</div></td></tr>
                <tr><td><div>현금입금 : </div></td><td><div id="id_deposit" name="cashDeposit">현금입금액</div></td></tr>
                <tr><td>메모:</td><td id="id_memo">메모내용</td></tr>


              </table>
            </div>
          </form>
        </div>

      </div>


    </div> <!-- /container -->

    <script type="text/javascript">

      function ExcuteData()
      {
        //alert("date:"+ GetDate());
        var xhr = new XMLHttpRequest();
        xhr.open('POST', './getData_DB.php');

        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        var data = '';
        var data = 'date='+ GetDate();
        //var data = 'date='+ '2016-01-22';

        //data += 'timezone='+document.getElementById('timezone').value;
        //data += '&format='+document.getElementById('format').value;




        xhr.onreadystatechange = function(){
        if(xhr.readyState === 4 && xhr.status === 200)
          {
            //alert('message:' + xhr.responseText);
            var arr_str = xhr.responseText;
            var arr = arr_str.split('^');


            document.querySelector('#id_date_show').innerHTML = arr[0]; //  날짜


            even = 50000;
            odd = 10000;
            even = even*1;
            odd = odd*1;
            var each = 0;

            // 동전계수
            for(var i=1;i<9;i++)
            {
              if(i%2!==0)
              {
                document.getElementById('id_'+even+'_td_sum').innerHTML = arr[i];
                each = arr[i]/even;
                document.getElementById('id_'+even+'_td_amount').innerHTML = each;
                even = even/10;
                each = 0;
              }
              else
              {
                document.getElementById('id_'+odd+'_td_sum').innerHTML = arr[i];
                each = arr[i]/odd;
                document.getElementById('id_'+odd+'_td_amount').innerHTML = each;
                odd = odd/10;
                each = 0;
              }
            }

            document.getElementById('id_cashSum').innerHTML = arr[9];  // 현금소계
            document.getElementById('id_presentCash').innerHTML = arr[10];  // 현금시제

            var list_spend = '';
            var list = arr[11].split(',');

            for( var l=0;l<list.length;l++)
            {
              list_spend += list[l] + '</br>';
            }

            document.getElementById('id_spendList').innerHTML = list_spend;  // 현금지출내역리스트

            document.getElementById('id_cashSpendSum').innerHTML = arr[12];  // 현금지출합계금액

            document.getElementById('id_cashSaled').innerHTML = arr[13];  // 현금판매

            document.getElementById('id_overandshort').innerHTML = arr[14];  // 과부족

            document.getElementById('id_deposit').innerHTML = arr[15];  // 현금입금

            document.getElementById('id_memo').innerHTML = arr[16];  // 메모

            if(arr[17] == 2)
            {
              document.getElementById('id_CasherId').innerHTML = "Casher: "+ "임중민";  // 캐셔아이디
            }
            else {

            }





          }
          else
          {
            //document.querySelector('#id_date').innerHTML = 'Error';
          }
        }

        xhr.send(data);
      }

      function GetSpendingList(str)
      {

      }


       function GetDate()
       {
          var strDate = document.querySelector('#id_date').value;
          var arr = strDate.split('-');

          g_Date = strDate;    // 날짜
          return strDate;
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
