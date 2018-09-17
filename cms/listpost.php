<?
require_once('htmlhelper.php');

$pagetitle = "Posts";
require_once('header.php');
?>

<h1>Posts</h1>

<?
$pdo = get_pdo();
$st = $pdo->prepare("select * from cms_posts order by post_date desc");
echo html_datatable($st,"table table-bordered table-striped");
?>

<? require_once('footer.php');?>
