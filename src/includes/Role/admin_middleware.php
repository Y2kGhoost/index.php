<?php
require_once '../includes/auth.inc.php';
if (!isAdmin()) {
    header("Location: /unauthorized.php");
    exit();
}
