<?= $this->extend('index') ?>

<?= $this->section('title') ?>
Home
<?= $this->endSection() ?>


<?= $this->section('content') ?>
<div class="container">
    <div class="row justify-content-center align-items-center px-4" style="margin-top: 20vh">
        <img class="col-md-8 my-4" src="<?php echo base_url('assets/welcomebanner.png') ?>" class="col-md-6 offset-md-3" />
        <button type="button" class="col-md-8 menu-button btn btn-danger my-3 btn-lg" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <h1>Start Game</h1>
        </button>
        <button type="button" class="col-md-8 menu-button btn btn-danger my-3 btn-lg">
            <a href="<?= base_url('/highscore'); ?>">
                <h1>High Score</h1>
            </a>
        </button>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Rules</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" id="name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger mt-3 btn-lg" onclick="redirect();">Play</button>
            </div>
        </div>
    </div>
</div>
<script>
    const redirect = () => {
        window.location.href = "<?= base_url('/game'); ?>/" + document.getElementById("name").value;
    }
</script>

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