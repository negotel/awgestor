<?php 

  @session_start();

  require_once '../../class/Conn.class.php';

  if(isset($_SESSION['AFILIADO'])){
      
      $idAf = $_SESSION['AFILIADO']['id'];
      
      $conn = new Conn();
      $pdo = $conn->pdo();
      
      $pdo->query("DELETE FROM `notification_af` WHERE af='{$idAf}' ");
      
  }

?>