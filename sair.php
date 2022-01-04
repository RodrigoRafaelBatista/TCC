<?php
session_start();
ob_start();
unset($_SESSION['USU_ID'], $_SESSION['USU_NOME']);
$_SESSION['msg'] = "Deslogado com sucesso!";

header("Location: index.php");