<?php

	//define('DEBUG_MODE_PROCEDURE', true);

	//echo("<script>console.log('proc_Log : print_lo_included.php');</script>");

	function print_Log($kind_log ='log', $val)
	{
	    echo('<script>console.log("'.$kind_log.' : '.$val.'");</script>');    
	}

?>

