<?= $this->extend('index') ?>

<?= $this->section('title') ?>
Game
<?= $this->endSection() ?>


<?= $this->section('content') ?>
<div>Player Name: <?php echo $name; ?></div>

<script type="text/javascript">
    var config = {
        type: Phaser.AUTO,
        //width: 800,
        //height: 600,
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
        }
    };

    var anims;
    var group;
    //var timetext;
    //var timedEvent;
    var score = 0;
    var scoreText;
    var timeText;
    var timeBar;
    var hsv;
    var timerEvents = [];
    var originalDuration = 3000; 
    var duration = originalDuration; 
    var game = new Phaser.Game(config);
    var gemCount = 10;

    var scoreDict = {
        'diamond': 50,
        'prism': 40,
        'ruby': 30,
        'square': 20,
    };

    function preload() {
        this.load.setBaseURL('http://labs.phaser.io');

        //background
        this.load.image('sky', 'assets/skies/deep-space.jpg');

        //audio
        //this.load.audio('theme', 'assets/audio/CatAstroPhi_shmup_normal.wav');
        //this.load.audio('theme', 'assets/audio/DOG.mp3');
        this.load.audio('theme', 'assets/audio/neriakX_-_Enigma_Gun_Extended_Mix.mp3');

        //elements
        this.load.image('el', 'assets/sprites/orb-red.png'); //orb-blue.png
        this.load.image('el1', 'assets/sprites/orb-green.png'); //orb-red.png
        this.load.image('el2', 'assets/sprites/orb-blue.png'); //orb-green.png

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
        //background
        this.add.image(250, 250, 'sky');

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

        //elements
        var el = this.physics.add.image(400, 100, 'el').setInteractive();
        el.setVelocity(200, 100);
        el.setBounce(1, 1);
        el.setCollideWorldBounds(true);
        el.on('pointerdown', function(pointer) {
            el.destroy();
        });

        var el1 = this.physics.add.image(400, 100, 'el1').setInteractive();
        el1.setVelocity(200, 200);
        el1.setBounce(1, 1);
        el1.setCollideWorldBounds(true);
        el1.on('pointerdown', function(pointer) {
            el1.destroy();
        });

        var el2 = this.physics.add.image(400, 100, 'el2').setInteractive();
        el2.setVelocity(100, 300);
        el2.setBounce(1, 1);
        el2.setCollideWorldBounds(true);
        el2.on('pointerdown', function(pointer) {
            el2.destroy();
        });

        //score
        scoreText = this.add.text(10, 10, 'Score:' + score);
        scoreText.setTint(0xff00ff, 0xffff00, 0x0000ff, 0xff0000);

        timeText = this.add.text(10, 30);
        timeText.setTint(0xff00ff, 0xffff00, 0x0000ff, 0xff0000);

        durationText = this.add.text(10, 50);
        durationText.setTint(0xff00ff, 0xffff00, 0x0000ff, 0xff0000);

        timerEvents.push(this.time.addEvent({
            delay: Phaser.Math.Between(100000, 100000)
        }));
        //200 is 2s

        hsv = Phaser.Display.Color.HSVColorWheel();

        timeBar = this.add.graphics({
            x: 100,
            y: 36
        });

        //make particles follow elements
        //em[0].startFollow(el);
        //em[1].startFollow(el1);
        //em[2].startFollow(el2);

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
        group = this.physics.add.group({
            key: 'gems',
            repeat: gemCount
        });
        group.children.iterate(createGem, this);

        //group friends & appear in certain time
        group1 = this.physics.add.group({
            key: 'friend',
            repeat: 1
        });
        group1.children.iterate(createfriend, this);

    }

    function update(time) {

        this.physics.world.wrap(group, 32);
        this.physics.world.wrap(group1, 32);

        var output = [];

        timeBar.clear();

        for (var i = 0; i < timerEvents.length; i++) {
            output.push('Timer: ');

            timeBar.fillStyle(hsv[i * 8].color, 1);
            timeBar.fillRect(0, i * 16, (duration/originalDuration * 300), 8);
        }

        duration--;
        durationText.setText('Duration: ' + Math.round(duration/100) + ' seconds left');

        if (duration < 0){
            game.destroy();
        }

        timeText.setText(output);

        if (gemCount < 6) {
            console.log("Running out of gems!");
            group = this.physics.add.group({
                key: 'gems',
                repeat: 7
            });
            group.children.iterate(createGem, this);
            gemCount = 10;
        }
    }

    function createGem(gem) {
        Phaser.Geom.Rectangle.Random(this.physics.world.bounds, gem).setInteractive();

        gem.play(Phaser.Math.RND.pick(anims));
        gem.setVelocity(Phaser.Math.Between(-70, 70), Phaser.Math.Between(-70, 70));
        gem.setBounce(1, 1);

        gem.on('pointerdown', function(pointer) {
            gemType = gem?.frame?.name.slice(0, -5).trim();
            gemValue = scoreDict[gemType]
            score += gemValue
            scoreText.text = 'Score:' + score;
            gem.destroy();
            --gemCount;
            // console.log(gemCount);
        });
    }

    function createfriend(fren) {
        Phaser.Geom.Rectangle.Random(this.physics.world.bounds, fren).setInteractive();

        fren.setVelocity(Phaser.Math.Between(90, 40), Phaser.Math.Between(0, 0));
        fren.setBounce(1, 1);
        fren.on('pointerdown', function(pointer) {
            fren.destroy();
        });
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
<?= $this->endSection() ?>