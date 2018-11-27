<?php

namespace Model;

class PlayersModel extends \W\Model\Model 
{
  protected $dbh;

  public function countGames($name)
  {
    $sql = "select count(*) FROM `players` WHERE name IN (:name)";
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':name', $name);
    $sth->execute();
    $result = $sth->fetch();
    return $result["count(*)"];
  }

  public function showScore($name)
  {
    $sql = "select SUM(score) FROM players WHERE name = :name";
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':name', $name);
    $sth->execute();
    $result = $sth->fetch();
    return $result["SUM(score)"];
    //return "hello";
  }
}
?>
