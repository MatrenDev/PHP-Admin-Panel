<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH.'/includes/auth_validate.php';

$item_id = filter_input(INPUT_GET, 'item_id', FILTER_VALIDATE_INT);
$operation = filter_input(INPUT_GET, 'operation', FILTER_SANITIZE_STRING); 
($operation == 'edit') ? $edit = true : $edit = false;
$db = getDbInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $item_id = filter_input(INPUT_GET, 'item_id', FILTER_SANITIZE_STRING);

    $data_to_db = filter_input_array(INPUT_POST);

    $data_to_db['updated_by'] = $_SESSION['user_id'];
    $data_to_db['updated_at'] = date('Y-m-d H:i:s');

    $db = getDbInstance();
    $db->where('id', $item_id);
    $stat = $db->update('items', $data_to_db);

    if ($stat)
    {
        $_SESSION['success'] = 'Sprzęt został zaktualizowany!';
        header('Location: items.php');
        exit();
    }
}

if ($edit)
{
    $db->where('id', $item_id);
    $item = $db->getOne('items');
}
?>
<?php include BASE_PATH.'/includes/header.php'; ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Edytuj Sprzęt</h2>
        </div>
    </div>
    <?php include BASE_PATH.'/includes/flash_messages.php'; ?>
    <form class="form" action="" method="post" id="items_form" enctype="multipart/form-data">
        <?php include BASE_PATH.'/forms/items_form.php'; ?>
    </form>
</div>
<?php include BASE_PATH.'/includes/footer.php'; ?>
