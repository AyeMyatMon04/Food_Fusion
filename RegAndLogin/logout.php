<?php
session_start();
session_destroy();
header("Location: MemLogin.php");
exit;
?>
