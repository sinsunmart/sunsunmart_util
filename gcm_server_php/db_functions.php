
<?php
 
class DB_Functions 
{ 
    private $db;
 
    //put your code here
    // constructor
    function __construct() {
        include_once './db_connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }
 
    // destructor
    function __destruct() {
         
    }
 
    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $email, $gcm_regid) 
    {
        // 이전에 이미 가입된 회원인지 regid를 검색
        $is_already = mysql_query("SELECT * FROM gcm_users WHERE id = '$gcm_regid'") or die(mysql_error());
        if(mysql_num_rows($is_already)>0)
        {
            return false;
            exit;
        }
        // insert user into database
        $result = mysql_query("INSERT INTO gcm_users(name, email, gcm_regid, created_at) VALUES('$name', '$email', '$gcm_regid', NOW())");
        // check for successful store
        if ($result) 
        {
            // get user details
            $id = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM gcm_users WHERE id = $id") or die(mysql_error());
            // return user details
            if (mysql_num_rows($result) > 0) 
            {
                return mysql_fetch_array($result);
            } else 
            {
                return false;
            }
        } else 
        {
            return false;
        }
    }
 
    /**
     * Getting all users
     */
    public function getAllUsers() {
        $result = mysql_query("select * FROM gcm_users");
        return $result;
    }
 
}
 
?>