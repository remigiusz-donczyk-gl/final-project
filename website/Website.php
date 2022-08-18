<?php declare(strict_types=1);

/**
 * @brief All the functions used by the website.
 *
 * Meant to be directly called from the website index,
 * contains all the functions used by the website.
 */
class Website {

  /**
   * @brief The main entrypoint method.
   * @return msg A list of messages to be printed by the website.
   *
   * The main entrypoint, runs all functions in the correct order,
   * passes data between them and returns a list of messages to print.
   */
  function run(): array {
    $ip = $this->getRealClientIP();
    $db = $this->connectToDatabase();
    $memes = $this->getMemeAmount($db);
    $random = rand(1, $memes);
    $olddata = $this->getClientData($db, $ip);
    $data = $this->updateClientData($olddata, $random);
    return array(
      "count" => $this->getCountMessage($data["Seen"], $memes),
      "try"   => $this->getTryMessage($data["Tries"]),
      "image" => $this->getImageEmbed($db, $random)
    );
  }

  /**
   * @brief Creates a connection to the database.
   * @return db The database object to access.
   *
   * Creates a connection to a 'website' local database as user 'dbuser',
   * with the default mysqli password (set in the ini file). Returns a mysqli object.
   */
  function connectToDatabase(): mysqli {
    return new mysqli("localhost", "dbuser", ini_get("mysqli.default_pw"), "website");
  }

  /**
   * @brief Counts set bits in an int.
   * @param[in] $n   The integer to count bits in.
   * @return    seen The number of bits set to 1.
   *
   * Counts set bits in an integer, this is how I have decided to store the memes already seen by a user;
   * each bit represents the 'seen' state of the meme at the same index in the database,
   * this allows for a space-efficient storing method, where each bit stores one meme, instead of a byte (or multiple)
   * in the case it was stored simply as a list of seen images.
   */
  function countSetBits(int $n): int {
    $count = 0;
    while ($n) {
      $count += $n & 1;
      $n >>= 1;
    }
    return $count;
  }

  /**
   * @brief Gets the length of the meme table.
   * @param[in] $db  The database to access.
   * @return    rows The total amount of memes.
   *
   * Gets all memes from the database and counts the number of rows.
   */
  function getMemeAmount(mysqli $db): int {
    $query = "SELECT * FROM memes";
    $all = $db->query($query);
    return $all->num_rows;
  }

  /**
   * @brief Gets the IP of a user.
   * @return ip The IP of the connecting client.
   *
   * Accesses server headers in order to get the most accurate reading possible of the user's IP.
   * Tries more accurate methods before falling back on less precise, but more readily available ones.
   */
  function getRealClientIP(): string {
    if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
         $ip = $_SERVER["HTTP_CLIENT_IP"];
    } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
               $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else {
      $ip = $_SERVER["REMOTE_ADDR"];
    }
    return $ip;
  }

  /**
   * @brief Creates a client object in the database.
   * @param[in] $db  The database to connect to.
   * @param[in] $ip  The IP of the user, used as an identifier.
   * @return    data The newly-created client data.
   *
   * Connects to the database and creates a client object with default parameters.
   * Returns the database, IP, 'seen' memes (see countSetBits), and the amount of tries.
   * Since this is a new client, both 'seen' memes and tries are 0.
   */
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

  /**
   * @brief Gets client data from the database.
   * @param[in] $db  The database to connect to.
   * @param[in] $ip  The IP of the user, used as an identifier.
   * @return    data The client data object.
   *
   * Connects to the database and retrieves data stored with a matching identifier.
   */
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

  /**
   * @brief Updates client data with the newly-seen meme.
   * @param[in] $data The client data to update.
   * @param[in] $meme The randomly-generated meme index.
   * @return    data  The updated version of client data.
   *
   * User data includes the database they are stored in,
   * so the data is updated locally as well as in the database,
   * and returned in the same format as the input.
   */
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

  /**
   * @brief Gets the meme to display.
   * @param[in] $db The database to access.
   * @param[in] $n  Index to the meme to fetch.
   * @return    img The image tag with the correct path.
   *
   * Accesses the database to fetch a meme, and creates an img HTML tag with the path to it.
   */
  function getImageEmbed(mysqli $db, int $n): string {
    $query = "SELECT Path FROM memes WHERE Id=" . $n;
    $img = $db->query($query)->fetch_array()["Path"];
    return "<img id=meme src=data/" . $img . "></img>";
  }

  /**
   * @brief Gets the count of seen memes message.
   * @param[in] $seen  The user's seen memes integer.
   * @param[in] $total The total count of memes in the database.
   * @return    msg    The message to display on the page.
   *
   * Checks the amount of memes seen and returns 'x/y memes seen' or,
   * if all memes were seen, 'all memes seen' message.
   */
  function getCountMessage(int $seen, int $total): string {
    $seenbit = $this->countSetBits($seen);
    if ($seenbit == $total) {
      return "<p>You have seen all of the memes!</p>";
    }
    return "<p>You have seen " . $seenbit . "/" . $total . " memes so far!</p>";
  }

  /**
   * @brief Gets the amount of tries message.
   * @param[in] $tries The number of tries by user.
   * @return    msg    The message to disaply on the page.
   *
   * Checks the amount of tries, and displays a 'x tries so far' or,
   * if the number of tries excedds 999, a 'too many times' message.
   */
  function getTryMessage(int $tries): string {
    if ($tries >= 999) {
      return "<p>You have tried <i>too many</i> times, seriously.</p>";
    }
    return "<p>You have tried " . $tries . " times so far.</p>";
  }
}

?>

