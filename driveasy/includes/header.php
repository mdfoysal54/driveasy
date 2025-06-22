<?php
require_once('init.php'); // Include the initialization file for session management and other settings
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><!-- Character encoding for the document -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DriveEasy Car Rentals - <?= $pageTitle ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">DriveEasy</div>
                <?php include('nav.php'); ?>
            </div>
        </div>
    </header>