<?php
  //header('Location: ./dayClose.php');
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>신선마트로그인</title>
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
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
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
        max-width: 145px;
        font-size: 16px;
        height: auto;
        margin-top: 5px;
        margin-bottom: 5px;
        padding: 7px 9px;


      }

      .input_wrap
      {
        position:relative;top:0 auto;
      }

      .btn_login
      {
        float: right;
        margin-top: 0px;
        padding-top: 0px;
        position:absolute;top:7px;left:155px;
      }


    </style>
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

  </head>

  <body>


    <div class="container">
      <div id="login_form_header">
        <div class="form-signin">
          <h2 class="form-signin-heading">SinSunMart Closing System</h2>
          <h5>© Sinsun Corp</h5>
          <img src="/img/img_login_header.png" alt="로그인 아이디와 비밀번호를 입력하세요." /></br>
          <div class='input_wrap'>
            <input type="text" class="input-block-level" id="id_text" placeholder="ID"></br>
            <input type="password" class="input-block-level" id="id_pwd" placeholder="PW" />
            <input type="image" class="btn_login" src="img/btn_login.png" alt="로그인" onclick="Log_In()"/>
          </div>

        </div>
      </div>


    </div> <!-- /container -->


    <script type="text/javascript">

      function Log_In()
      {
        var id = '';
        var pwd = '';
        id = document.querySelector('#id_text').value;
        pwd = document.querySelector('#id_pwd').value;

        var form = document.createElement("form");
        form.setAttribute("method", "POST");
        form.setAttribute("action", "/login.php");


        var name_id = document.createElement("input");
        name_id.setAttribute("type", "hidden");
        name_id.setAttribute("name", 'name');
        name_id.setAttribute("value", id);

        form.appendChild(name_id);

        var password = document.createElement("input");
        password.setAttribute("type", "hidden");
        password.setAttribute("name", 'pw');
        password.setAttribute("value", pwd);

        form.appendChild(password);

        document.body.appendChild(form);

        form.submit();

      }

      function LogIn()
      {
        var id = '';
        var pwd = '';
        id = document.querySelector('#id_text').value;
        pwd = document.querySelector('#id_pwd').value;

        //alert('id:'+document.getElementById('#id_id').value + 'pw:' + document.getElementById("#id_pw").value);

        var xhr = new XMLHttpRequest();

        xhr.open('POST', './login.php');

        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");


        var data = '';
        data += 'name='+ id;
        data += '&pw='+ pwd;

        //alert('data:'+data);


        xhr.onreadystatechange = function(){
        if(xhr.readyState === 4 && xhr.status === 200)
          {

            var arr_str = xhr.responseText;
            //alert('DATA :'+arr_str);

            if(arr_str == '0001')
            {
              // 주인장 로그인처리
              location.href="./manager.php";
            }
            else if(arr_str == '1')
            {
               // 일반회원 로그인
               //location.href="./dayClose.php";
              var name = "name";
              var id=2;
              location.href="dayClose.php?"+name+":"+id;
            }
            else
            {
              alert('아이디나 비밀번호가 맞지 않습니다. 확인하고 다시 시도해 주십시오');
            }
          }
          else
          {
            //alert("FAIL");
            //document.querySelector('#id_date').innerHTML = 'Error';
          }

        }

        xhr.send(data);
        //alert('data:'+ data);
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
