<?php

  @session_start();
  $painel = $_SESSION['PAINEL']['slug'];
  @session_destroy();
  setcookie('panel_user');
  header('LOCATION: ../'.$painel);

?>
