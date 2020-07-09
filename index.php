<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

$db = getDbInstance();

$numItems = $db->getValue ("items", "count(*)");

include_once('includes/header.php');
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Strona Główna</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $numItems; ?></div>
                            <div>Sprzęt</div>
                        </div>
                    </div>
                </div>
                <a href="items.php">
                    <div class="panel-footer">
                        <span class="pull-left">Szczegóły</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
        
        </div>
        <div class="col-lg-3 col-md-6">
            
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">


        </div>
        <div class="col-lg-4">

        </div>
    </div>
</div>

<?php include_once('includes/footer.php'); ?>
