<?
require_once('htmlhelper.php');

$pagetitle = "new post";
require_once('header.php');
?>

<h1>New Post</h1>

<form action="action.php" method="post">
  <input type="hidden" name="action" value="insert-post"/>

  <div class="form-group">
    <label for="posttype">Post Type</label>
    <?= html_select("posttype","posttype","form-control",
            "select type_name, type_label from cms_post_types order by type_label",
            "type_name", "type_label") ?>
  </div>

  <div class="form-group">
    <label for="title">Title</label>
    <input id="title" name="title" class="form-control"/>
  </div>

  <div class="form-group">
    <label for="content">Content</label>
    <textarea id="content" name="content" class="form-control"></textarea>
  </div>

  <div class="form-group">
    <label for="users">PUSH To Users</label>
    <input id="users" name="users" class="form-control"/>
    <small>Use comma to separate multiple user-name.</small>
  </div>
  

  <div class="form-group">
    <label for="buttons"></label>
    <button type="submit" class="btn btn-primary">Submit</button>
    <button type="button" class="btn btn-secondary">Reset</button>
  </div>

</form>

<? require_once('footer.php');?>