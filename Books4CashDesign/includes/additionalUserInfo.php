<?php
session_start();
require 'DBCommunication.php';
require 'crypting.php';
header('Content-type: application/json');
$response_array=array('success' => false,'error_code'=>array(),'message' => '');
try {
    $conn=new DBCommunication();
    $conn->beginTransaction();
    $user_id=$_SESSION['user_id'];
    if(isset($_POST['firstname'])){
        $query="UPDATE whwp_User SET user_firstname = :firstname WHERE user_id = :user_id";
        $conn->prepQuery($query);
        $firsname=encrypt($_POST['firstname']);
        $conn->bindArrayValue(array('firstname'=>$firsname,'user_id'=>$user_id));
        $conn->execute();
    }

    if(isset($_POST['surname'])){
        $query="UPDATE whwp_User SET user_surname = :surname WHERE user_id = :user_id";
        $conn->prepQuery($query);
        $surname=encrypt($_POST['surname']);
        $conn->bindArrayValue(array('surname'=>$surname,'user_id'=>$user_id));
        $conn->execute();
    }

    if(isset($_POST['city'])){
        $query="UPDATE whwp_User SET user_city = :city WHERE user_id = :user_id";
        $conn->prepQuery($query);
        $city=encrypt($_POST['city']);
        $conn->bindArrayValue(array('city'=>$city,'user_id'=>$user_id));
        $conn->execute();
    }

    $response_array['success']=true;

    $conn->endTransaction();

}
catch (PDOException $e){
    $conn->cancelTransaction();
    array_push($response_array['error_code'], 1);
    $response_array['message']=$e->getMessage();
}
echo json_encode($response_array);