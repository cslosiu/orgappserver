<?
require_once('../config.php');

function push_enqueue($postid)
{
    $sql = "insert into push_queue (post_id, in_date) values (?, current_timestamp)";
    dbquery($sql, array($postid));
}

function push_regdevice($userid, $devicetoken)
{ 
    $sql = "insert into push_devices (user_id, aps_token) values (?,?)
        on duplicate key update aps_token = ?";
    dbquery($sql, array($userid,$devicetoken,$devicetoken));
}

function push_to_user($postid, $userids = array())
{
    $sql = "insert into push_to_user (post_id, user_id) values (?,?)";
    foreach ($userids as $user) {
        dbquery($sql, array($postid, $user));
    }
}

?>