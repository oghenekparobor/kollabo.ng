<?php
class CreateLog {

    private $con;

    function __construct() {
        require ('admin/database/connect.php');
        $db = new DbConnect();
        $this->$con = $db->connect();
    }

    public function createLog($message) {
        $stmt = $this->con->prepare("INSERT INTO `logs` (`id`, `log_message`, `created`) VALUES (NULL, '$message', current_timestamp())");
        $stmt->execute();
    }

}