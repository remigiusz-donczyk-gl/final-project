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
      $fn = new Functions();
      $ip = $fn->getRealClientIP();
      $db = $fn->connectToDatabase();
      //  get the total amount of memes and generate a random index
      $memes = $fn->getMemeAmount($db);
      $random = rand(1, $memes);
      //  get the current client data and update it with the random meme
      $olddata = $fn->getClientData($db, $ip);
      $data = $fn->updateClientData($olddata, $random);
      //  print x/y memes shown and the amount of times tried
      print $fn->getCountMessage($data["Seen"], $memes);
      print $fn->getTryMessage($data["Tries"]);
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
        print $fn->getImage($db, $random);
      ?>
    </div>
  </body>
</html>

