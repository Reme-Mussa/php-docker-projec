<?php
session_start();
session_unset();
session_destroy();
header("Location: notes.php");
exit;