<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css" href="<?php echo base_url('bootstrap.min.css'); ?>" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url('style.css'); ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Press Start 2P" rel="stylesheet">
    <script src="<?php echo base_url('phaser.js'); ?>"></script>
    <title><?= $this->renderSection('title') ?></title>
</head>

<body>
    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <script src="<?= base_url('/jquery-3.6.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('bootstrap.bundle.min.js'); ?>"></script>
</body>

</html>