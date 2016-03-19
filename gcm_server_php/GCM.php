
<?php

class GCM {
 
    //put your code here
    // constructor
    function __construct() {
         
    }
 
    /**
     * Sending Push Notification
     */
    public function send_notification($registatoin_ids, $message) 
    {
        //echo('<script>console.log("message : '.$message.'");</script>');
        // include config
        include_once './config.php';
 
        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';
 
        // $fields = array(
        //     'registration_ids' => $registatoin_ids,
        //     //'data' => $message,
        //     'title' => $title,
        //     'message' => $message,
        // );

        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => array('title' => APP_TITLE, 'message' => $message)
        );
 
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        // Close connection
        curl_close($ch);
        echo $result;
    }

    public function dosomething()
    {
        return true;
    }
 
}
 
?>