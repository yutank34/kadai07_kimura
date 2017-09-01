enchant();

window.onload = function(){
  var core = new Core(640, 640);
  core.preload('hipman.png', 'enemy.png', 'back.png', 'he.png', 'gameover.png');
  core.scale = 1;
  core.onload = function(){
    //背景画像の表示
    var space = new Sprite(640, 640);
    space.image = core.assets['back.png'];
    space.x = 0;
    space.y = 0;
    core.rootScene.addChild(space);

    //hipmanのクラス設定
    var Hipman = Class.create(Sprite,{
      initialize: function(x, y){
        Sprite.call(this, 67, 80);
        this.x = x;
        this.y = y;
        this.image = core.assets['hipman.png'];
        this.on('touchmove', function(e){
          this.x = e.x;
          this.y = e.y;
          this.frame = this.age % 3;
        });
        core.rootScene.addChild(this);
      }
    });

    //enemyのクラス設定
    var Enemy = Class.create(Sprite, {
      initialize: function(){
        Sprite.call(this, 30, 60);
        this.image = core.assets['enemy.png'];
        this.x = Math.floor(Math.random() * 610);
        this.y = 0;
        this.tl.moveBy(0, 670, 100);
        core.rootScene.addChild(this);
      }
    });

    //ラベルの表示設定
    var label = new Label();
    label.x = 5;
    label.y = 5;
    label.color = 'red';
    label.font = '20px "Arial"';
    label.text = '0';

    label.on('enterframe', function(){
      this.text = (core.frame / core.fps).toFixed(2);
    });

    //hipmanを表示
    var hipman = new Hipman(0, 550);

    //enemyを表示
    core.rootScene.tl.then(function(){
      var enemy = new Enemy();

      //攻撃の実装
      core.rootScene.on('touchstart', function(evt){
        var fart = new Sprite(42, 40);
        fart.image = core.assets['he.png'];
        fart.moveTo(hipman.x, hipman.y + 20);
        fart.tl.moveBy(0, -680, 70);
        core.rootScene.addChild(fart);
        enemy.addEventListener('enterframe', function(){
          if(enemy.intersect(fart)){
            core.rootScene.removeChild(enemy);
          }
        });
      });

      //gameOverイベント
      enemy.addEventListener('enterframe', function(){
        if(enemy.intersect(hipman)){
          core.pushScene(gameOverScene);
        }
      });
    }).delay(15).loop();

    //経過時間を表示
    core.rootScene.addChild(label);

    //gameoverのシーン
    var gameOverScene = new Scene();
    gameOverScene.backgroundColor = 'black';
    var gameover = new Sprite(640, 640);
    gameover.image = core.assets['gameover.png']
    gameOverScene.addChild(gameover)

  }
  core.start();
};
//   var game = new Game(640, 640);
//   game.preload('hipman.png', 'enemy.png', 'he.png', 'back.png');
//   game.scale = 1;
//   game.fps = 30;
//
//   game.onload = function () {
//     //背景画像の表示
//     // var space = new Sprite(640, 640);
//     // space.image = game.assets['back.png'];
//     // space.x = 0;
//     // space.y = 0;
//     // game.rootScene.addChild(space);
//
//     //Hipman（player）の設定
//     var Hipman = enchant.Class.create(enchant.Sprite, {
//       initialize: function(){
//         enchant.Sprite.call(this, 67, 75);
//         this.y = 550;
//         this.image = game.assets['hipman.png'];
//         this.frame = 30;
//         game.rootScene.addChild(this);
//       }
//     });
//
//
//     //敵の設定（上から下に降りてくる）
//     var Enemy = enchant.Class.create(enchant.Sprite, {
//       initialize: function(){
//         enchant.Sprite.call(this, 30, 60);
//         this.image = game.assets['enemy.png'];
//         this.x = Math.floor(Math.random()* 610, 0);
//         this.frame = 30;
//         this.tl.moveBy(0, 670 ,100);
//         game.rootScene.addChild(this);
//       }
//     });
//
//     //Hipmanの表示
//     var player = new Hipman();
//
//     //Hipmanの操作
//     game.rootScene.on('touchmove',function(evt){
//       player.x = evt.localX;
//       player.y = evt.localY;
//     });
//
//     //敵を一定時間毎に表示させる
//     game.rootScene.tl.then(function(){
//       var enemy = new Enemy();
//     }).delay(15).loop();
//
//     //当たり判定処理
//     player.addEventListener("enterframe", function(){
//       if(Hipman.intersect(Enemy)){
//         console.log("s");
//       }
//     });
//   };
//   game.start();
// };
