<?php
require_once '../../../Model/User.php'; 

$user = new User();

if(isset($_POST['query'])){
    $search = $_POST['query'];
    $result = $user->searchUsername($search);
    if(!empty($result)) {
        echo "Username tidak tersedia";
    } else {
        echo "Username tersedia";
    }
}

?>