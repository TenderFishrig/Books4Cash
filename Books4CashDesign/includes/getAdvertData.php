<?php
session_start();
require 'DBCommunication.php';
header('Content-type: application/json');
$response_array=array('success' => false,'error_code'=>array(),'message' => '','advert_data'=>array(),'tags'=>array());

if(isset($_POST['advert_id'])) {
    try {
        $conn = new DBCommunication();
        $query = "SELECT advert_category,advert_bookname,advert_bookauthor,advert_price,advert_description,advert_condition FROM whwp_Advert WHERE advert_id=:advert_id";
        $conn->prepQuery($query);
        $conn->bind('advert_id', $_POST['advert_id']);
        $result = $conn->single();
        $response_array['advert_data']=$result;
        $query = "SELECT tag_description FROM whwp_Advert, whwp_AdTag, whwp_Tag "
            . "WHERE whwp_Advert.advert_id = :advert_id "
            . "AND whwp_Tag.tag_id = whwp_AdTag.adtag_tag "
            . "AND whwp_AdTag.adtag_advert = whwp_Advert.advert_id";
        $conn->prepQuery($query);
        $conn->bind('advert_id', $_POST['advert_id']);
        $result = $conn->resultset();
//        foreach($result as $item){
//            array_push($response_array['tags'],$item->tag_description);
//        }
        $response_array['tags']=explode(',',$result[0]->tag_description);
        $response_array['success'] = true;
    } catch (PDOException $e) {
        array_push($response_array['error_code'], 1);
        $response_array['message'] = $e->getMessage();
    }
}
else {
    array_push($response_array['error_code'], 2);
}
echo json_encode($response_array);