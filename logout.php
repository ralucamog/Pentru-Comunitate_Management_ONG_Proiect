<?php
session_start();
session_unset();
session_destroy(); // Distruge sesiunea
header("Location: login.php"); // Ajungem înapoi la login
exit();
