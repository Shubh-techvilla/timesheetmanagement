<?php 
require_once('../function/function.php');
$pdo = getPDOObject();

/** Get State Data */
if(isset($_POST['action']) && $_POST['action']=='getState' )
{
    $country_id = $_POST['countID'];
    //echo $country_id; die();
    $sql = $pdo->prepare("SELECT * FROM `states` WHERE country_id=?");
    $sql->execute([$country_id]);
    $statedata = $sql->fetchAll(PDO::FETCH_ASSOC);
    $cntRow = $sql->rowCount();
   
    if($cntRow > 0)
    {
       
        foreach($statedata as $state)
        {
            echo '<option value="'.$state['id'].'">'.$state['name'].'</option>';
        }
    }else{
        echo '<option value="">No data found</option>';
    }
}


/** Get City Data */
if(isset($_POST['action']) && $_POST['action']=='getCity' )
{
    $state_id = $_POST['stateID'];
    //echo $country_id; die();
    $sql = $pdo->prepare("SELECT * FROM `cities` WHERE state_id=?");
    $sql->execute([$state_id]);
    $citydata = $sql->fetchAll(PDO::FETCH_ASSOC);
    $cntRow = $sql->rowCount();
   
    if($cntRow > 0)
    {
       
        foreach($citydata as $city)
        {
            echo '<option value="'.$city['id'].'">'.$city['name'].'</option>';
        }
    }else{
        echo '<option value="">No data found</option>';
    }
}

?>