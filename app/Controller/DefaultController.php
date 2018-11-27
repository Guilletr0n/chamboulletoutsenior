<?php

namespace Controller;

use \W\Controller\Controller;
use \Model\PlayersModel as Player;

class DefaultController extends Controller
{

  /**
   * Page d'accueil par défaut
   */

  protected $player;

  public function __construct()
  {
    $this->player = new Player;
  }

  public function home()
  {
    $this->show('default/home');
  }

  public function newGame()
  {
    // read raw http post data
    $input = $this->getPost();
    // checks how many shoots the player have made
    $count = $this->player->countGames($input["name"]);
    $totalGames = intval($count);
    if($totalGames > 1){
      $arr = array('score'=>$score, 'totalGames'=>$totalGames, 'allowGame'=>false,);
      $output = $arr;
    } else {
      $score = $this->player->showScore($input["name"]);
      $arr = array('score'=>$score, 'totalGames'=>$totalGames, 'allowGame' => true);
      $output = $arr;
    }
    
    $this->showJson($output);
  }
  
  public function shoot()
  {
    $input = $this->getPost();
    $playerName = $input["name"];
    $count = intval($this->player->countGames($playerName));
    $scoreArr = $input["score"];
    $score = $this->calculeScore($scoreArr);

    if($count < 2){
      $this->player->insert(array('name'=>$input["name"],'score'=>$score));
    }

    $allowGame = ($count < 2);
    $output = (object) array('score' => $score, 'totalGames' => intval($count+1), 'allowGame' => $allowGame);
    
    $this->showJson($output);
  }
  private function calculeScore($pointsArray)
  {
    //var_dump($pointsArray);

    foreach($pointsArray as $key=>$value)
    {
      if($value > 0){
        if($key == 1) $totalPoints += 30;
        if($key == 2) $totalPoints += 20;
        if($key == 3) $totalPoints += 20;
        if($key == 4) $totalPoints += 10;
        if($key == 5) $totalPoints += 10;
        if($key == 6) $totalPoints += 10;
      } 
    }
    return $totalPoints;
  }
}