<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href= 'style/style.css' >
    <title>H5AI</title>
</head>
<body>
<div class="container">
  <div class="top">
    <div class="tools">
      <p>Trier par : </p>
      <form method="post" action=""><input type="hidden" name="order" value="size"><input type="submit" value="Taille"></form>
      <form method="post" action=""><input type="hidden" name="order" value="last-mod"><input type="submit" value="Date"></form>
    </div>
  </div>
  <div class="corp">

<?php
$controller = new Controller;
$controller->start($url);
?>
</body>
</html>