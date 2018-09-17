<?
require_once('inc.php');

$id = insert_post('foo','bar bar bar bar text','notification');

$db = get_pdo();
$st = $db->query('select * from cms_posts');
$rs = $st->fetchAll();

header('content-type: text/plain');
echo "xx";
echo $id;
var_dump($rs);

?>
