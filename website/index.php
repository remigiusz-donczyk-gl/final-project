<!doctype html>
<html lang=en>
  <head>
    <!-- set the charset and get a nice font -->
    <meta charset=UTF-8>
    <link rel=stylesheet href=http://fonts.cdnfonts.com/css/renogare>
    <link rel=stylesheet href=style.css>
    <title>Meme DB</title>
      </head>
  <body>
    <?php
      include "Functions.php";
      include "Website.php";
      $f = new Functions();
      $w = new Website();
      $msg = $w->run($f);
      print $msg["count"];
      print $msg["try"];
    ?>
    <div id=txtcontainer>
      <!-- #roundleft and #roundright elements are CSS magic to make rounded inside corners -->
      <div id=roundleft></div>
      <p id=title>Here is your random meme</p>
      <button onclick=window.location.reload();>Give me another!</button>
      <div id=roundright></div>
    </div>
    <div id=imgcontainer>
      <?php
        //  get the random meme from the database
        print $msg["image"];
      ?>
    </div>
  </body>
</html>

