<?
require_once('htmlhelper.php');

$pagetitle = "Devices";
require_once('header.php');
?>

<h1><?=$pagetitle?></h1>

<?
$pdo = get_pdo();
$st = $pdo->prepare("select * from push_devices order by update_date desc");
echo html_datatable($st,"table table-bordered table-striped");
?>

<? require_once('footer.php');?>
