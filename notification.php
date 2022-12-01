<?php

class Notification {

    private $con;

    function __construct(){

        require_once dirname(__FILE__).'/admin/database/connect.php';
        
        $db = new DbConnect();

        $this->con = $db->connect();
    }

    public function createNotification($userid, $notification, $type) {
        if ($this->isExist($userid, $type)){
			return 0;
		} else {
            $stmt = $this->con->prepare("INSERT INTO `notification` (`id`, `user_id`, `notification`, `read_status`, `type`, `created`) 
                                    VALUES (NULL, ?, ?, 'new', ?, current_timestamp())");
            $stmt->bind_param("iss", $userid, $notification, $type);
            if ($stmt->execute()) {
                return 1;
            } else {
                return 2;
            }
        }
    }

    private function isExist($userid, $type){
		$stmt = $this->con->prepare("SELECT * FROM `notification` WHERE user_id = ? AND `type` = ? AND read_status = 'new' ");
		$stmt->bind_param("is", $userid, $type);
		$stmt->execute();
		$stmt->store_result();
		return $stmt->num_rows > 0;
	}

}