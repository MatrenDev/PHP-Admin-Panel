<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH.'/includes/auth_validate.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $data_to_db = array_filter($_POST);

    $data_to_db['created_by'] = $_SESSION['user_id'];
    $data_to_db['created_at'] = date('Y-m-d H:i:s');

    $db = getDbInstance();
    $last_id = $db->insert('items', $data_to_db);

    if ($last_id)
    {
        $_SESSION['success'] = 'Sprzęt dodany pomyślnie!';
        header('Location: items.php');
    	exit();
    }
    else
    {
        echo 'Wystąpił błąd podczas dodawania: ' . $db->getLastError();
        exit();
    }
}

$edit = false;
?>
<?php include BASE_PATH.'/includes/header.php'; ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Dodaj sprzęt</h2>
        </div>
    </div>
    <?php include BASE_PATH.'/includes/flash_messages.php'; ?>
    <form class="form" action="" method="post" id="items_form" enctype="multipart/form-data">
        <?php include BASE_PATH.'/forms/items_form.php'; ?>
    </form>
</div>
<script type="text/javascript">
$(document).ready(function(){
   $('#items_form').validate({
       rules: {
            nazwa: {
                required: true,
                minlength: 3
            },
            historia: {
                required: true,
                minlength: 3
            },   
        }
    });
});
</script>
<?php include BASE_PATH.'/includes/footer.php'; ?>
