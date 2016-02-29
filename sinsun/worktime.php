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
              <table class="table">
                
                <h3>신선마트 근무시간관리</h3>
                <h5>© Sinsun Corp</h5>
               

                <p>캐셔 : <div></div></p>
                <p>시작날짜 : <input type="date" name="n_date" onfocusout=""></p>
                <p>종료날짜 : <input type="date" name="n_date" onfocusout=""></p>    
                <p>시급 : <input type="text">원</p>
                급여 : <div>0,000</div>원

                
              </table>

            </div>

          </form>



        </div>

      </div>


    </div> <!-- /container -->

    



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