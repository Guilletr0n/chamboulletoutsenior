<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Chamboulle tout</title>
    <script src="https://unpkg.com/vue"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <!-- <script src="vue.js"></script> -->
    <link rel="stylesheet" href="<?= $this->assetUrl('css/style.css') ?>">
</head>
<body>
    <div class="container">
        <header>
            <h1>Chamboulle tout!!</h1>
        </header>

        <section>
            <div id="glob" align="center">
            <h1></h1>
            <h2>{{ output }}</h2>
            <p v-if="shoots > 0">Vous avez tiré {{ shoots }} fois</p>
            <p>Score:{{ score }}</p>
            <p v-if="manyTimes" class="alert">Vous avez tiré déjà deux fois</p>
            <label for="player">Joueur : </label>
            <input name="player" v-model="playerName" placeHolder="prenom">
            <input type="submit" v-on:click="newGame()" value="Jouer">
            
            <ol v-bind:class="{ active: allowGame }">
              <li v-for="n in totalBoxes">
                <input type="checkbox" :id="'box_'+n" :value="n" v-model="checkedboxes" v-on:click="shoot"/>
              </li>
            <ol>
            
            </div>
            <?= $this->section('main_content') ?>
        </section>

        <footer>
        </footer>
    </div>
    <script type="text/javascript">
    var chamboulletout = new Vue({
        el: '#glob',
        computed: {
          
        },
        methods: {
            newGame: function(event) {
              let self = this
              axios
                .post('<?=$this->url("newGame")?>',{
                  name:this.playerName,
                  action:'newGame'
                })
                .then(function(response){
                  this.update(response)
                }.bind(this))
            },
            update: function(response){
              this.shoots = response.data.totalGames;
              this.score = response.data.score;
              if(response.data.totalGames >= 2) {
                this.manyTimes = true;
              } else {
                this.manyTimes = false;
              }
              if(response.data.allowGame)
              {
                console.log("allowed to play");
                this.allowGame = true;
              } else {
                this.allowGame = false;
                this.score = response.data.score
              }
            },
            shoot: function(event){
              let points = Number(event.target.value);
              switch(points){
                case 1:
                  console.log("uno");
                break
                default:
                break;
              }
            }
        },
        created(){
          var serlf = this;
        },
        data: {
          totalBoxes:6,
          allowGame:false,
          manyTimes:false,
          shoots:0,
          output:null,
          score:0,
          playerName:null,
          checkedboxes: [0,0,0,0,0,0],
          info: null,
        },
        mounted () {
          
        },
        watch: {
          checkedboxes: function (val) {
            //console.log(val);
            //val[1] = 1;
            scored = val[val.length - 1];
            val[scored-1] = scored;
            val[0] = 1;
            val[Math.floor(scored/2)-1] = Math.floor(scored/2);
            val.forEach( (value, index) =>
            {
              if(scored == 5) val[index] = index;
              if(index>6) val.pop();
            });
             axios
              .post('<?=$this->url("shoot")?>',{
                name:this.playerName,
                score:val
              })
              .then(function(response){
                this.update(response);
              }.bind(this));
            
          },
          score: function() {

          }
        }
    })

</script>
</body>
</html>