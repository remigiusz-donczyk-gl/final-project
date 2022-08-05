<?php declare(strict_types=1);

class Functions {

  function connectToDatabase(): mysqli {
    return new mysqli("localhost", "dbuser", ini_get("mysqli.default_pw"), "website");
  }

  function countSetBits(int $n): int {
    $count = 0;
    while ($n) {
      $count += $n & 1;
      $n >>= 1;
    }
    return $count;
  }

  function getMemeAmount(mysqli $db): int {
    $query = "SELECT * FROM memes";
    $all = $db->query($query);
    return $all->num_rows;
  }

  function getRealClientIP(): string {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
         $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
               $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
  }

  function createClientData(mysqli $db, string $ip): array {
    $query = "INSERT INTO userdata (IP) VALUES ('" . $ip . "')";
    $db->query($query);
    return array(
      "Database" => $db,
      "IP"       => $ip,
      "Seen"     => 0,
      "Tries"    => 0
    );
  }

  function getClientData(mysqli $db, string $ip): array {
    $query = "SELECT Seen, Tries FROM userdata WHERE IP='" . $ip . "'";
    $userdata = $db->query($query);
    if ($userdata->num_rows == 0) {
      return $this->createClientData($db, $ip);
    }
    return array_merge(array(
      "Database" => $db,
      "IP"       => $ip,
    ), $userdata->fetch_array());
  }

  function updateClientData(array $data, int $meme): array {
    $newseen = $data["Seen"] | (1 << ($meme - 1));
    $newtries = $data["Tries"] + 1;
    if ($newtries > 999) {
      $newtries = 999;
    }
    $query = "UPDATE userdata SET Seen=" . $newseen . ", Tries=" . $newtries . " WHERE IP='" . $data["IP"] . "'";
    $data["Database"]->query($query);
    return array(
      "Database" => $data["Database"],
      "IP"       => $data["IP"],
      "Seen"     => $newseen,
      "Tries"    => $newtries
    );
  }

  function getImage(mysqli $db, int $n): string {
    $query = "SELECT Path FROM memes WHERE Id=" . $n;
    $img = $db->query($query)->fetch_array()["Path"];
    return "<img src=data/$img></img>";
  }

  function getCountMessage(int $seen, int $total): string {
    $seenbit = $this->countSetBits($seen);
    if ($seenbit == $total) {
      return "<p>You have seen all of the memes!</p>";
    }
    return "<p>You have seen " . $seenbit . "/" . $total . " memes so far!</p>";
  }

  function getTryMessage(int $tries): string {
    if ($tries >= 999) {
      return "<p>You have tried <i>too many</i> times, seriously.</p>";
    }
    return "<p>You have tried " . $tries . " times so far.</p>";
  }
}

?>

