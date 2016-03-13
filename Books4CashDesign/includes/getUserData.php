<?php
session_start();
require 'DBCommunication.php';
require 'crypting.php';
header('Content-type: application/json');
$response_array=array('success' => false,'error_code'=>array(),'message' => '','data'=>array());

try{
    $conn=new DBCommunication();
    $query ="SELECT * FROM whwp_User WHERE user_id=:user_id";
    $conn->prepQuery($query);
    $conn->bind('user_id',$_SESSION['user_id']);
    $result=$conn->single();
    if($result->user_city!=null)
    $response_array['data']['city']=decrypt($result->user_city);
    if($result->user_firstname!=null)
    $response_array['data']['firstname']=decrypt($result->user_firstname);
    if($result->user_surname!=null)
    $response_array['data']['surname']=decrypt($result->user_surname);
    $response_array['data']['email']=decrypt($result->user_email);
    $response_array['success']=true;
}
catch (PDOException $e){
    array_push($response_array['error_code'], 1);
    $response_array['message']=$e->getMessage();
}
echo json_encode($response_array);
