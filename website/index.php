<!doctype html>
<html lang=en>
  <head>
    <!-- set the charset and get a nice font -->
    <meta charset=UTF-8>
    <link href=http://fonts.cdnfonts.com/css/renogare rel=stylesheet>
    <!-- CSS Magic -->
    <style>
      * {
        border: 0;
        margin: 0;
        padding: 0;
      }
      body, #txtcontainer, #imgcontainer {
        display: flex;
        flex-direction: column;
        align-items: center;
      }
      #txtcontainer, #imgcontainer {
        justify-content: space-evenly;
      }
      body {
        color: #fff;
        background: #444;
        overflow: hidden;
        width: 100vw;
        height: 100vh;
        justify-content: center;
      }
      p {
        font-size: 1.3rem;
        font-family: 'Renogare', sans-serif;
        text-align: center;
      }
      button {
        background: #4caf50;
        border: none;
        border-radius: 1vh;
        padding: 10px 20px;
        display: inline-block;
        font-size: 1.1rem;
        text-decoration: none;
        transition: background 0.5s;
      }
      button:hover {
        background: #3b9e39;
      }
      img {
        max-height: 100%;
        max-width: 100%;
      }
      #title {
        font-size: 2.5rem;
      }
      #txtcontainer {
        width: 40%;
        gap: 10%;
        border-radius: 5vh 5vh 0 0;
        justify-content: center;
        height: 20%;
        background: #555;
        position: relative;
      }
      #imgcontainer {
        width: 60%;
        border-radius: 5vh;
        height: 70%;
        background: #555;
      }
      #roundleft, #roundright {
        height: 5vh;
        aspect-ratio: 1;
        background: inherit;
        position: absolute;
        bottom: 0;
      }
      #roundleft::before, #roundright::before {
        content: '';
        background: #444;
        position: absolute;
        width: 10vh;
        aspect-ratio: 1;
        border-radius: 50%;
        bottom: 0;
      }
      #roundleft {
        left: -5vh;
      }
      #roundright {
        right: -5vh;
      }
      #roundleft::before {
        right: 0;
      }
      #roundright::before {
         left: 0;
      }
    </style>
    <?php
      // helper function to count set bits in an int
      function countSetBits($n) {
        $count = 0;
        while ($n) {
          $count += $n & 1;
          $n >>= 1;
        }
        return $count;
      }
      // helper function to get client IP
      function getRealClient() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
          $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
          $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
          $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
      }
    ?>
  </head>
  <body>
    <?php
      // connect to the database
      $db = new mysqli("localhost", "dbuser", "Very!Strong@Password#I%Presume", "website");
      // get user info from the database
      $client = getRealClient();
      $userindb = $db->query("select Seen, Tries from userdata where IP='$client'");
      if ($userindb->num_rows == 0) {
        // if the user does not exist, make a record for them and fetch the default value
        $db->query("insert into userdata (IP) values ('$client')");
        $userindb = $db->query("select Seen, Tries from userdata where IP='$client'");
      }
      $row = $userindb->fetch_array();
      $seen = $row["Seen"];
      $tries = $row["Tries"];
      // get all available memes and choose a random one
      $all = $db->query("select * from memes");
      $random = rand(1, $all->num_rows);
      // update the list of seen memes with the newly picked one and update the database
      $newseen = $seen | (1 << ($random - 1));
      $newtries = $tries + 1;
      if ($newtries > 999) {
        $newtries = 999;
      }
      $db->query("update userdata set Seen=$newseen, Tries=$newtries where IP='$client'");
      // count the number of set bits in the meme list and print seen/all amount
      if (countSetBits($newseen) == $all->num_rows) {
        print "<p>You have seen all of the memes!<br />";
      } else {
        $display = countSetBits($newseen) . "/" . $all->num_rows;
        print "<p>You have seen $display memes so far!<br />";
      }
      if ($tries >= 999) {
        print "You have tried <i>too many</i> times, seriously.</p>";
      } else {
        print "You have tried $newtries times so far.</p>";
      }
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
        // get the chosen random meme and display it
        $meme = $db->query("select Path from memes where Id = $random")->fetch_array()["Path"];
        print "<img src=data/$meme></img>";
      ?>
    </div>
  </body>
</html>

