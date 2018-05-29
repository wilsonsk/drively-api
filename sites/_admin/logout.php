<?php
    session_start();
    require_once('../site_settings.php');

    unset($_SESSION[ADMIN_SITE]);
    header("Location: ".ADMIN_URL);
?>