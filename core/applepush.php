<?
require_once('config.php');
//apple Push

function ap_regdevice($username, $devicetoken)
{
  $sql = "insert into oa_push (user_name, aps_token) values (?,?)
    on duplicate key update aps_token = ?";
  dbquery($sql,'sss',array($username,$devicetoken,$devicetoken));
}

?>
