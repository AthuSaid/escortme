<?php

require '../ws/class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('page.myrequest');
$db = DatabaseConnection::get();

?>

<script type="text/javascript">
    $(".esc-profile-pic img").prop("src", "ws/picture.php?type=thumbnail&picture_id=<?php echo $user['picture']; ?>");
    $(".esc-menu-name").text("<?php echo $user['firstName']; ?>");

    Topbar.show();
    Topbar.setText("");
    Sidebar.open();
</script>