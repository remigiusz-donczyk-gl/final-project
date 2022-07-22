<!doctype html>
<html lang=en>
  <head>
    <meta charset=UTF-8>
    <link href=http://fonts.cdnfonts.com/css/renogare rel=stylesheet>
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
        font-size: 2.5rem;
        font-family: 'Renogare', sans-serif;
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
  </head>
  <body>
    <div id=txtcontainer>
      <div id=roundleft></div>
      <p>Here is your random meme</p>
      <button onclick=window.location.reload();>Give me another!</button>
      <div id=roundright></div>
    </div>
    <div id=imgcontainer>
      <?php
        $db = new mysqli("localhost", "dbuser", "123", "website");
        $res = $db->query("select * from memes");
        $chosen = rand(1, $res->num_rows);
        $meme = $db->query("select Path from memes where Id = $chosen")->fetch_array()["Path"];
        print "<img src=data/$meme></img>";
      ?>
    </div>
  </body>
</html>

