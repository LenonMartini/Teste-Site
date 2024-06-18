<?php
/**
 * Created by PhpStorm.
 * User: Desenvolvimento 2
 * Date: 09/02/2018
 * Time: 10:07
 */

if(file_exists(basename(__DIR__).".php")) header("Location: ".basename(__DIR__).".php" );
if(file_exists(basename(__DIR__)."s.php")) header("Location: ".basename(__DIR__).".php" );

else die();
?>