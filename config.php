<?php
session_start();

function loadLanguage($lang) {
    $filePath = __DIR__ . '/lang/' . $lang . '.php';
    if (file_exists($filePath)) {
        return include($filePath);
    } else {
        return include(__DIR__ . '/lang/en.php');  
    }
}

if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en'; 
$translations = loadLanguage($lang);
