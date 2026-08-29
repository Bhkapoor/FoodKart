<?php
session_start();
session_destroy();
header("Location: ../index.php");
exit;
?>
<script>
window.location.replace("../index.php");
</script>