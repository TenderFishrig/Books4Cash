<?php
require 'DBCommunication.php';
header('Content-type: application/json');

$response_array=array('success' => false,'data' => '');
try{
    $conn=new DBCommunication();
    $query="SELECT category_id,category_Description FROM whwp_Category";
    $conn->prepQuery($query);
    $response_array['data']=$conn->resultset();
    $response_array['success']=true;
}
catch(PDOException $e){

}
echo json_encode($response_array);