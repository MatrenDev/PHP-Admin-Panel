<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') 
{

	if($_SESSION['admin_type']!='super'){
		$_SESSION['failure'] = "Nie masz uprawnień by wykonać tą akcje";
    	header('location: items.php');
        exit;

	}
    $item_id = $del_id;

    $db = getDbInstance();
    $db->where('id', $item_id);
    $status = $db->delete('items');
    
    if ($status) 
    {
        $_SESSION['info'] = "Sprzęt został usunięty!";
        header('location: items.php');
        exit;
    }
    else
    {
    	$_SESSION['failure'] = "Błąd podczas usuwania sprzętu";
    	header('location: items.php');
        exit;

    }
    
}