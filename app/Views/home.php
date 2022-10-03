<?= $this->extend('index') ?>

<?= $this->section('title') ?>
Home
<?= $this->endSection() ?>


<?= $this->section('content') ?>
<h1>Best Game</h1>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Start Game</button>
<a href="<?= base_url('/highscore'); ?>"><button type="button" class="btn btn-primary">High Score</button></a>

<form method="post" action="<?= base_url('/game'); ?>">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Please Enter Your Name:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="exampleFormControlInput1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Play</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?= $this->endSection() ?>