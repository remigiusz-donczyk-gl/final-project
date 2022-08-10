<?php declare(strict_types=1);
  include_once "Functions.php";
  include_once "Website.php";
  $f = new Functions();
  $w = new Website();
  $msg = $w->run($f);
?>
<!doctype html>
<html lang=en>
  <head>
    <meta charset=UTF-8>
    <!-- use a nice font -->
    <link rel=stylesheet href=http://fonts.cdnfonts.com/css/renogare>
    <link rel=stylesheet href=style.css>
    <title>Meme DB</title>
  </head>
  <body>
    <div id=txtcontainer>
      <!-- #roundleft and #roundright elements are CSS magic to make rounded inside corners -->
      <div id=roundleft></div>
      <div id=roundright></div>
      <p id=title>Here is your random meme</p>
      <?php
        print $msg["count"];
        print $msg["try"];
      ?>
      <button id=refresh>Give me another!</button>
    </div>
    <div id=imgcontainer>
      <?php
        print $msg["image"];
      ?>
    </div>
    <script src=script.js></script>
  </body>
</html>

