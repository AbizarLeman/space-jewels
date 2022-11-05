<?= $this->extend('index') ?>

<?= $this->section('title') ?>
Game
<?= $this->endSection() ?>


<?= $this->section('content') ?>

<div class="modal" id="savingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="savingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <h1 class="modal-title text-center fs-1 text-danger" id="savingModalLabel">Saving score for ...</h1>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var config = {
        type: Phaser.AUTO,
        width: 500,
        height: 500,
        physics: {
            default: 'arcade',
            arcade: {
                gravity: {
                    y: 0
                }
            }
        },
        scene: {
            preload: preload,
            create: create,
            update: update
        },
        audio: {
            disableWebAudio: true
        },
        parent: 'game',
        scale: {
            mode: Phaser.Scale.FIT, // you can find another types in Phaser.Scale.ScaleModeType: RESIZE | FIT | ENVELOP ...
            autoCenter: Phaser.Scale.CENTER_BOTH,
        }
    };

    var game = new Phaser.Game(config);

    var anims;
    var gemGroup;
    var friendGroup;

    var gameOverBanner;
    var replayButton;
    var cancelButton;

    var scoreSaved = false;

    var highScore = '<?php echo $highscore; ?>';
    var highScoreText;
    var score = 0;
    var scoreText;
    var timeText;
    var timeBar;
    var hsv;
    var timerEvents = [];

    var originalDuration;
    var duration;

    var gemCount;
    var friendCount;
    var blueOrbCount;
    var redOrbCount;
    var greenOrbCount;

    var blueOrb;
    var redOrb;
    var greenOrb;

    var scoreDict = {
        'diamond': 50,
        'prism': 40,
        'ruby': 30,
        'square': 20,
        'blue': 300,
        'red': 200,
        'green': 100,
    };

    function preload() {
        this.load.setBaseURL('<?php echo base_url() ?>');

        //game over banner
        this.load.image('replaybutton', 'assets/replaybutton.png');
        this.load.image('cancelbutton', 'assets/cancelbutton.png');

        //game over banner
        this.load.image('gameover', 'assets/gameover.png');

        //background
        this.load.image('sky', 'assets/skies/deep-space.jpg');

        //audio
        //this.load.audio('theme', 'assets/audio/CatAstroPhi_shmup_normal.wav');
        //this.load.audio('theme', 'assets/audio/DOG.mp3');
        this.load.audio('theme', 'assets/audio/neriakX_-_Enigma_Gun_Extended_Mix.mp3');

        //orb elements
        this.load.image('blueOrb', 'assets/sprites/orb-blue.png'); //orb-blue.png
        this.load.image('redOrb', 'assets/sprites/orb-red.png'); //orb-red.png
        this.load.image('greenOrb', 'assets/sprites/orb-green.png'); //orb-green.png

        //gems
        this.load.atlas('gems', 'assets/tests/columns/gems.png', 'assets/tests/columns/gems.json');

        //friend
        this.load.image('friend', 'assets/sprites/alienbusters.png');

        //particles
        //this.load.image('par', 'assets/particles/green.png');
        //this.load.image('par', 'assets/particles/yellow.png');
        //this.load.image('par', 'assets/particles/red.png');
        this.load.image('par', 'assets/particles/blue.png');

    }

    function create() {
        scoreSaved = false;

        originalDuration = 1000;
        duration = originalDuration;

        gemCount = 10;
        friendCount = 1;
        blueOrbCount = 0;
        redOrbCount = 0;
        greenOrbCount = 0;

        //background
        this.add.image(250, 250, 'sky');

        replayButton = this.add.image(200, 350, 'replaybutton', {
                align: "center",
            }).setInteractive()
            .on('pointerdown', () => {
                score = 0;
                timerEvents = []
                this.scene.restart();
            });
        replayButton.setScale(0.2);
        replayButton.setDepth(1);
        replayButton.visible = false;

        cancelButton = this.add.image(300, 350, 'cancelbutton', {
                align: "center",
            }).setInteractive()
            .on('pointerdown', () => {
                window.location.replace("<?php echo base_url() ?>");
            });
        cancelButton.setScale(0.2);
        cancelButton.setDepth(1);
        cancelButton.visible = false;

        gameOverBanner = this.add.image(250, 250, 'gameover', {
            align: "center",
        });
        gameOverBanner.setScale(0.2);
        gameOverBanner.setDepth(1);
        gameOverBanner.visible = false;

        //audio
        var music = this.sound.add('theme');
        music.loop = true;
        music.play();

        //time
        //timetext = this.add.text(32, 32);
        //timedEvent = this.time.addEvent({ delay: 500, callback: onEvent, callbackScope: this, loop: true });

        //time 
        //this.timerText = this.add.text(x, y, "").setColor("#000000");

        //score
        //score = 5;
        //score = score + 10;

        //const text1 = this.add.text(10, 10, 'Score:' + score);
        //text1.setTint(0xff00ff, 0xffff00, 0x0000ff, 0xff0000);

        //particles
        var particles = this.add.particles('par');

        //create new varibles name emitter for particles features - to be use in attaching with elem later
        /*var em = [];
        for (var x = 0; x <=2 ; x++){
            em[x] = particles.createEmitter({
                speed: 100,
                scale: { start: 1, end: 0 },
                blendMode: 'ADD'
            });
        }*/

        //orb elements
        blueOrb = this.physics.add.image(400, 100, 'blueOrb').setInteractive();
        blueOrb.setVelocity(800, 700);
        blueOrb.setBounce(1, 1);
        blueOrb.setCollideWorldBounds(true);
        blueOrb.on('pointerdown', function(pointer) {
            if (duration > 0) {
                score += scoreDict["blue"]
                scoreText.text = 'Score:' + score;
                blueOrb.destroy();
                --blueOrbCount;
            }
        });


        redOrb = this.physics.add.image(400, 100, 'redOrb').setInteractive();
        redOrb.setVelocity(400, 300);
        redOrb.setBounce(1, 1);
        redOrb.setCollideWorldBounds(true);
        redOrb.on('pointerdown', function(pointer) {
            if (duration > 0) {
                score += scoreDict["red"]
                scoreText.text = 'Score:' + score;
                redOrb.destroy();
                --redOrb;
            }
        });

        greenOrb = this.physics.add.image(400, 100, 'greenOrb').setInteractive();
        greenOrb.setVelocity(200, 100);
        greenOrb.setBounce(1, 1);
        greenOrb.setCollideWorldBounds(true);
        greenOrb.on('pointerdown', function(pointer) {
            if (duration > 0) {
                score += scoreDict["green"]
                scoreText.text = 'Score:' + score;
                greenOrb.destroy();
                --greenOrbCount;
            }
        });

        //score
        highScoreText = this.add.text(10, 10, 'High Score:' + highScore);
        highScoreText.setTint(0xff00ff, 0xffff00, 0x0000ff, 0xff0000);
        highScoreText.setDepth(1);

        scoreText = this.add.text(10, 30, 'Score:' + score);
        scoreText.setTint(0xff00ff, 0xffff00, 0x0000ff, 0xff0000);
        scoreText.setDepth(1);

        timeText = this.add.text(10, 50);
        timeText.setTint(0xff00ff, 0xffff00, 0x0000ff, 0xff0000);
        timeText.setDepth(1);

        durationText = this.add.text(10, 70);
        durationText.setTint(0xff00ff, 0xffff00, 0x0000ff, 0xff0000);
        durationText.setDepth(1);

        timerEvents.push(this.time.addEvent({
            delay: Phaser.Math.Between(100000, 100000)
        }));
        //200 is 2s

        hsv = Phaser.Display.Color.HSVColorWheel();

        timeBar = this.add.graphics({
            x: 100,
            y: 55
        });
        timeBar.setDepth(1);

        //animation        
        this.anims.create({
            key: 'diamond',
            frames: this.anims.generateFrameNames('gems', {
                prefix: 'diamond_',
                end: 15,
                zeroPad: 4
            }),
            repeat: -1
        });

        this.anims.create({
            key: 'prism',
            frames: this.anims.generateFrameNames('gems', {
                prefix: 'prism_',
                end: 6,
                zeroPad: 4
            }),
            repeat: -1
        });

        this.anims.create({
            key: 'ruby',
            frames: this.anims.generateFrameNames('gems', {
                prefix: 'ruby_',
                end: 6,
                zeroPad: 4
            }),
            repeat: -1
        });

        this.anims.create({
            key: 'square',
            frames: this.anims.generateFrameNames('gems', {
                prefix: 'square_',
                end: 14,
                zeroPad: 4
            }),
            repeat: -1
        });

        anims = ['diamond', 'prism', 'ruby', 'square'];

        //repeat gems & group gems
        gemGroup = this.physics.add.group({
            key: 'gems',
            repeat: gemCount
        });
        gemGroup.children.iterate(createGem, this);

        //group friends & appear in certain time
        friendGroup = this.physics.add.group({
            key: 'friend',
            repeat: friendCount
        });
        friendGroup.children.iterate(createFriend, this);
    }

    // function createOrb(texture, velocityX, velocityY) {
    //     var orb = this.physics.add.image(400, 100, texture).setInteractive();
    //     orb.setVelocity(velocityX, velocityY);
    //     orb.setBounce(1, 1);
    //     orb.setCollideWorldBounds(true);
    //     orb.on('pointerdown', function(pointer) {
    //         orb.destroy();
    //     });
    // }

    function update(time) {
        this.physics.world.wrap(gemGroup, 32);
        this.physics.world.wrap(friendGroup, 32);


        timeBar.clear();

        for (var i = 0; i < timerEvents.length; i++) {
            timeBar.fillStyle(hsv[16].color, 1);
            timeBar.fillRect(0, i * 16, (duration / originalDuration * 300), 8);
        }

        if (duration < 0) {
            this.physics.pause();
            if (scoreSaved === false) {
                saveScore()
            }
            gameOverBanner.visible = true;
            replayButton.visible = true;
            cancelButton.visible = true;
        } else {
            duration--;
            durationText.setText('Duration: ' + Math.round(duration / 100) + ' seconds left');

            timeText.setText('Time: ');
        }

        if (gemCount < 6) {
            console.log("Running out of gems!");
            setTimeout(() => {
                gemGroup = this.physics.add.group({
                    key: 'gems',
                    repeat: 7
                });
                gemGroup.children.iterate(createGem, this);
            }, 2000);
            gemCount = 10;
        }

        if (friendCount < 0) {
            console.log("Oops, you have no friends!");
            setTimeout(() => {
                friendGroup = this.physics.add.group({
                    key: 'friend',
                    repeat: 1
                });
                friendGroup.children.iterate(createFriend, this);
            }, 3000);
            friendCount = 1;
        }

        if (blueOrbCount < 0) {
            setTimeout(() => {
                blueOrb = this.physics.add.image(400, 100, 'blueOrb').setInteractive();
                blueOrb.setVelocity(200, 100);
                blueOrb.setBounce(1, 1);
                blueOrb.setCollideWorldBounds(true);
                blueOrb.on('pointerdown', function(pointer) {
                    blueOrb.destroy();
                    --blueOrbCount;
                });
            }, 4000);
            blueOrbCount = 0;
        }

        if (redOrbCount < 0) {
            setTimeout(() => {
                redOrb = this.physics.add.image(400, 100, 'redOrb').setInteractive();
                redOrb.setVelocity(200, 200);
                redOrb.setBounce(1, 1);
                redOrb.setCollideWorldBounds(true);
                redOrb.on('pointerdown', function(pointer) {
                    redOrb.destroy();
                    --redOrbCount;
                });
            }, 4000);
            redOrbCount = 0;
        }

        if (greenOrbCount < 0) {
            setTimeout(() => {
                greenOrb = this.physics.add.image(400, 100, 'greenOrb').setInteractive();
                greenOrb.setVelocity(100, 300);
                greenOrb.setBounce(1, 1);
                greenOrb.setCollideWorldBounds(true);
                greenOrb.on('pointerdown', function(pointer) {
                    greenOrb.destroy();
                    --greenOrbCount;
                });
            }, 4000);
            greenOrbCount = 0;
        }
    }

    function createGem(gem) {
        Phaser.Geom.Rectangle.Random(this.physics.world.bounds, gem).setInteractive();

        gem.play(Phaser.Math.RND.pick(anims));
        gem.setVelocity(Phaser.Math.Between(-70, 70), Phaser.Math.Between(-70, 70));
        gem.setBounce(1, 1);

        gem.on('pointerdown', function(pointer) {
            if (duration > 0) {
                gemType = gem?.frame?.name.slice(0, -5).trim();
                gemValue = scoreDict[gemType]
                score += gemValue
                scoreText.text = 'Score:' + score;
                gem.destroy();
                --gemCount;
            }
        });
    }

    function createFriend(friend) {
        Phaser.Geom.Rectangle.Random(this.physics.world.bounds, friend).setInteractive();

        friend.setVelocity(Phaser.Math.Between(200, 120), Phaser.Math.Between(0, 0));
        friend.setBounce(1, 1);
        friend.on('pointerdown', function(pointer) {
            if (duration > 0) {
                score -= Math.round(score / 2)
                scoreText.text = 'Score:' + score;
                friend.destroy();
                --friendCount;
            }
        });
    }

    async function saveScore() {
        $('#savingModal').modal('show');
        try {
            $.ajax({
                type: "POST",
                async: false,
                url: '<?= base_url('/highscore'); ?>',
                data: {
                    "player_name": "<?php echo $name; ?>",
                    "score": score
                },
                success: function(response) {
                    console.log("Success!")
                    $('#savingModal').modal('hide');
                },
                error: function(request, error) {
                    console.log(error);
                    $('#savingModal').modal('hide');
                }
            });
        } catch (error) {

        }

        scoreSaved = true;
    }

    //time
    /*
    function onEvent ()
    {
        c++;

        if (c === 60)
        {
            timedEvent.remove(false);
        }
    }*/

    /*Note: 
    (1) Hit gems within the given time period and get score.
    (2) Score are based on hitting gem (type of gems = diff score)
    (3) Watch out obstacles - hitting it will reduce the score
    */
</script>

<style>
    body {
        background-image: url(<?php echo base_url('assets/space2.png') ?>);
    }

    @media (max-width:770px) {
        img#optionalstuff {
            display: none;
        }
    }
</style>
<?= $this->endSection() ?>