<!doctype html>
<html lang=en>
  <head>
    <meta charset=UTF-8>
    <style>
      body, div {
        display: flex;
        flex-direction: column;
        justify-content: space-evenly;
        align-items: center;
      }
      body {
        color: #fff;
        background: #444;
        overflow: hidden;
        width: 100vw;
        height: 100vh;
      }
      div {
        width: 60%;
        height: 80%;
      }
      img {
        max-height: 100%;
        max-width: 100%;
      }
    </style>
  </head>
  <body>
    <p>Here is your random meme!</p>
    <button onclick='window.location.reload();'>I want another</button>
    <div>
      <?php
        $db = new mysqli("localhost", "dbuser", "123", "website");
        $res = $db->query('select * from memes');
        $chosen = rand(1, $res->num_rows);
        $meme = $db->query("select Path from memes where Id = $chosen")->fetch_array()['Path'];
        print "<img src=data/$meme></img>";
      ?>
    </div>
  </body>
</html>

