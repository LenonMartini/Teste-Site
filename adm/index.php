<?php
/**
 * Created by PhpStorm.
 * User: Desenvolvimento 2
 * Date: 05/07/2018
 * Time: 17:37
 */
require_once 'core/config.inc.php';
//var_dump(die(first_config()));
if (first_config()) {
    header("Location: first.php");
    exit();
}
session_start();

if(!isset($_SESSION['usu_id']) || !$_SESSION['usu_id'] ) header('Location: login.php');
else header("Location: home");
?>


