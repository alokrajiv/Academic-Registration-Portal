<?php

class auth_manager {

    public function __construct() {
        
    }

    public function get_user_data($user_email) {
        require_once $_SERVER["DOCUMENT_ROOT"] . '/../configs/auto_config.php';
        $sql1 = "SELECT *  FROM `student_list` WHERE `institute_email` = '$user_email'";
        try {
            $stmt = $dbConn->prepare($sql1);
            $stmt->execute();
            if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result['type'] = "student";
                return $result;
            }
        } catch (Exception $ex) {
            
        }
        require_once $_SERVER["DOCUMENT_ROOT"] . '/../configs/auto_config.php';
        $sql1 = "SELECT *  FROM `faculty_list` WHERE `institute_email` = '$user_email'";
        try {
            $stmt = $dbConn->prepare($sql1);
            $stmt->execute();
            if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result['type'] = "faculty";
                return $result;
            }
        } catch (Exception $ex) {
            
        }
    }

    public function before_set_session() {
        
    }

    public function set_session($user_email) {
        $this->before_set_session();
        $data = $this->get_user_data($user_email);
        //remeber session is not reset here. Only user_data is set 
        $_SESSION['user_data'] = $data;
        return TRUE;
    }

}
