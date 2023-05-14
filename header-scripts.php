<?php
    session_start();
    if(!isset($_SESSION['UserID'])){
        header('Location: signin.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Dashboard | Fetch.IT </title>
    <link rel="icon" type="image/x-icon" href="src/assets/img/logo-browser.png"/>
    <link href="layouts/vertical-dark-menu/css/light/loader.css" rel="stylesheet" type="text/css" />
    <!-- <link href="layouts/vertical-dark-menu/css/dark/loader.css" rel="stylesheet" type="text/css" /> -->
    <script src="layouts/vertical-dark-menu/loader.js"></script>
    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="src/css/customize.css" rel="stylesheet" type="text/css" />
    <link href="layouts/vertical-dark-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="src/assets/css/light/elements/alert.css">
    <!-- <link rel="stylesheet" type="text/css" href="src/assets/css/dark/elements/alert.css"> -->
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <style>
        .main-content{
            background-image: url(images/bgg.png);
            background-size: cover;
        }
    </style>
</head>