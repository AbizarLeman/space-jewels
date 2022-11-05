<?= $this->extend('index') ?>

<?= $this->section('title') ?>
Highscore
<?= $this->endSection() ?>


<?= $this->section('content') ?>
<div class="col-md-6 offset-md-3 p-5" style="background-color:black">
    <img id="optionalstuff" src="<?php echo base_url('assets/highscore1.png') ?> " class="col-md-6 offset-md-3 my-3" />
    <div class="list-group w-auto">
        <?php foreach ($highscores as $highscore) {
            echo '
                <div class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true" style="background-color:light-grey">
                    <img src="' . base_url('assets/rocket.png') . '" alt="twbs" width="32" height="32" class="rounded-circle flex-shrink-0">
                    <div class="d-flex gap-2 w-100 justify-content-between">
                    <div>
                        <h5 class="mb-0">' . $highscore->player_name . '</h5>
                        <p class="mb-0 opacity-75">Score: <b>' . $highscore->score . ' </b>points.</p>
                    </div>
                    <small class="opacity-50 text-nowrap">' . $highscore->time . '</small>
                    </div>
                </div> ';
        }
        ?>

        <div class="text-center">
            <a href="<?= base_url('/'); ?>"><button type="button" class="btn btn-danger mt-3 btn-lg">Main Page</button></a>
        </div>
    </div>
</div>

<style>
    body {
        background-image: url(<?php echo base_url('assets/space1.png') ?>);
    }

    @media (max-width:770px) {
        img#optionalstuff {
            display: none;
        }
    }
</style>
<?= $this->endSection() ?>