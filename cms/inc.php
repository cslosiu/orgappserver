<?
require_once('../config.php');

function insert_post($title,$content,$type)
{
    $sql = "insert into cms_posts (`post_author`, `post_date`, `post_date_gmt`, `post_content`, 
        `post_title`, `post_status`, `post_type`)
        values (0,current_timestamp, utc_timestamp(),?,
        ?,'publish',?) ";
    $h = get_pdo();
    $st = $h->prepare($sql);
    $st->bindValue(1,$content);
    $st->bindValue(2,$title);
    $st->bindValue(3,$type);
    $st->execute();
    return $h->lastInsertId();
}

// convert an array of user-logins to user-ids
function userid_from_userlogin($logins)
{
    $ids = array();
    $sql = "select user_id from cms_users where user_login = ?";
    foreach($logins as $login) {
        $st = dbquery($sql, array($login));
        $id = $st->fetchColumn();
        array_push($ids, $id);
    }
    return $ids;
}

function redirect($url) 
{
    header("Location: $url");
}


?>