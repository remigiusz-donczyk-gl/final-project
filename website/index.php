<!doctype html>
<html lang=en>
  <head>
    <meta charset=UTF-8>
  </head>
  <body>
    <?php
      $db = new mysqli("localhost", "dbuser", "123", "website");
      $res = $db->query('select * from test');
      print "<table style='border: 1px solid black'><tr><td style='width: 200px'>Id</td><td style='width: 200px'>Text</td></tr>";
      while ($row = $res->fetch_array()) {
        print "<tr><td>" . $row['Id'] . "</td><td>" . $row['Text'] . "</td></tr>";
      }
      print "</table>";
    ?>
  </body>
</html>

