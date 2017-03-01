<?php

require '../ws/class/loader.php';
classloader("../");

SessionManager::logout();

?>
<script type="text/javascript">

    DataStore.autoLogin(0);
    window.location.hash = "#startview";

</script>