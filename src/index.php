<?php
require_once 'includes/auth.php';
redirectIfNotLoggedIn();

header("Location: pages/poems.php");
?>