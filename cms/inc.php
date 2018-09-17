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

function redirect($url) 
{
    header("Location: $url");
}


?>