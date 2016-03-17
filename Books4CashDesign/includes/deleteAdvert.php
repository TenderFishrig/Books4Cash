<?php
session_start();
require 'DBCommunication.php';
header('Content-type: application/json');
$response=1;
if(isset($_POST['advert_id'])){
    if(isset($_SESSION['user_id'])){
        try{
            $conn=new DBCommunication();
            $query="SELECT advert_owner FROM whwp_Advert WHERE advert_id=:advert_id";
            $conn->prepQuery($query);
            $conn->bind('advert_id',$_POST['advert_id']);
            $result=$conn->single();
            if($result->advert_owner==$_SESSION['user_id']){
                $query="UPDATE whwp_Advert SET advert_expired = 1 WHERE advert_id = :advert_id";
                $conn->prepQuery($query);
                $conn->bind('advert_id',$_POST['advert_id']);
                $conn->execute();
                $response=0;
            }
            else {
                $response=4;
            }
        }
        catch(PDOException $e){
            $response=3;
        }
    }
    else {
        $response=2;
    }
}
echo json_encode($response);