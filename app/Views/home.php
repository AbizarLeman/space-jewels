<?= $this->extend('index') ?>

<?= $this->section('title') ?>
Home
<?= $this->endSection() ?>


<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center align-items-center px-4" style="margin-top: 20vh">
        <img class="col-md-8 my-4" src="<?php echo base_url('assets/newlogo6.png') ?>" class="col-md-6 offset-md-3" />
        <br></br>
        <button type="button" class="col-md-8 button-85 btn btn-danger my-3 btn-lg" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <h1>START GAME</h1>
        </button>
        <button type="button" class="col-md-8 button-85 btn btn-danger my-3 btn-lg">
            <a href="<?= base_url('/highscore'); ?>">
                <h1>HIGH SCORE</h1>
            </a>
        </button>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><h1>Rules</h1></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="optionalstuff" src="<?php echo base_url('assets/rules.png') ?> " class="col-md-6 offset-md-3 my-3" />
                <div class="mb-3">
                    <label for="username" class="form-label">Enter your username:</label>
                    <input type="text" class="form-control" name="username" id="username">
                    <label for="time" class="form-label">Play time:</label>
                    <select class="form-select" name="seconds" id="seconds">
                        <option value="1000">10 Seconds</option>
                        <option value="2000">20 Seconds</option>
                        <option value="3000">30 Seconds</option>
                        <option value="6000">1 Minutes</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger mt-3 btn-lg" onclick="validate();">Play</button>
            </div>
        </div>
    </div>
</div>

<script>
    const validate = () => {
        const username = document.getElementById("username").value
        if (document.getElementById("username").value && document.getElementById("username").value) {
            redirect()
        }
    }

    const redirect = () => {
        window.location.href = "<?= base_url('/game'); ?>/" + document.getElementById("username").value + `?seconds=${document.getElementById("seconds").value}`;
    }
</script>

<style>
    body {
        background-image: url(<?php echo base_url('assets/skies/deep-space.jpg') ?>);
    }

    @media (max-width:770px) {
        img#optionalstuff {
            display: none;
        }
    }
</style>
<?= $this->endSection() ?>