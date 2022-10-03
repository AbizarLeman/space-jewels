<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css" href="<?php echo base_url('bootstrap.min.css'); ?>" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url('style.css'); ?>" rel="stylesheet">
    <script src="<?php echo base_url('phaser.js'); ?>"></script>
    <title><?= $this->renderSection('title') ?></title>
</head>
<body>  
    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <script src="<?php echo base_url('bootstrap.bundle.min.js'); ?>"></script>
</body>
</html>