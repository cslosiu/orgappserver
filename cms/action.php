<?
require_once('inc.php');
require_once('../push/pushinc.php');

$action = $_POST['action'];

if ($action == 'insert-post') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $type = $_POST['posttype'];
    $users = $_POST['users'];

    // store the new post.
    $postid = insert_post($title,$content,$type);

    // if do Push?
    if ($users) {
        push_enqueue($postid);
        $userarray = explode(',',$users);
        push_to_user($postid,$userarray);
    }
    redirect("listpost.php");
}

?>
