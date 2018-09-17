<?
require_once('../config.php');

function push_enqueue($postid)
{
    $sql = "insert into push_queue (post_id, in_date) values (?, current_timestamp)";
    dbquery($sql, array($postid));
}

function push_regdevice($username, $devicetoken)
{
    $sql = "insert into push_devices (user_name, aps_token) values (?,?)
        on duplicate key update aps_token = ?";
    dbquery($sql, array($username,$devicetoken,$devicetoken));
}

function push_to_user($postid, $users = array())
{
    $sql = "insert into push_to_user (post_id, user_name) values (?,?)";
    foreach ($users as $user) {
        dbquery($sql, array($postid, $user));
    }
}

?>