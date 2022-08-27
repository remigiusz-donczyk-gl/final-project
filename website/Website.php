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
   * @return array A list of messages to be printed by the website.
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
      "count" => $this->getCountMessage($data->Seen, $memes),
      "try"   => $this->getTryMessage($data->Tries),
      "image" => $this->getImageEmbed($db, $random)
    );
  }

  /**
   * @brief Creates a connection to the database.
   * @return mysqli The database object to access.
   *
   * Creates a connection to a 'website' local database as user 'dbuser',
   * with the default mysqli password (set in the ini file). Returns a mysqli object.
   */
  function connectToDatabase(): mysqli {
    //  log in as root as a quick fix
    return new mysqli("appdb", "root", "", "website");
    //return new mysqli("appdb", "dbuser", file_get_contents("/pw.conf"), "website");
  }

  /**
   * @brief Counts set bits in an int.
   * @param  $n  The integer to count bits in.
   * @return int The number of bits set to 1.
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
   * @param  $db The database to access.
   * @return int The total amount of memes.
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
   * @return string The IP of the connecting client.
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
   * @param  $db      The database to connect to.
   * @param  $ip      The IP of the user, used as an identifier.
   * @return UserData The newly-created client data.
   *
   * Connects to the database and creates a client object with default parameters.
   * Returns the database, IP, 'seen' memes (see countSetBits), and the amount of tries.
   * Since this is a new client, both 'seen' memes and tries are 0.
   */
  function createClientData(mysqli $db, string $ip): UserData {
    $query = "INSERT INTO userdata (IP) VALUES ('" . $ip . "')";
    $db->query($query);
    return new UserData($db, $ip, 0, 0);
  }

  /**
   * @brief Gets client data from the database.
   * @param  $db      The database to connect to.
   * @param  $ip      The IP of the user, used as an identifier.
   * @return UserData The client data object.
   *
   * Connects to the database and retrieves data stored with a matching identifier.
   */
  function getClientData(mysqli $db, string $ip): UserData {
    $query = "SELECT Seen, Tries FROM userdata WHERE IP='" . $ip . "'";
    $data = $db->query($query);
    if ($data->num_rows == 0) {
      return $this->createClientData($db, $ip);
    }
    $row = $data->fetch_array();
    return new UserData($db, $ip, intval($row["Seen"]), intval($row["Tries"]));
  }

  /**
   * @brief Updates client data with the newly-seen meme.
   * @param  $data    The client data to update.
   * @param  $meme    The randomly-generated meme index.
   * @return UserData The updated version of client data.
   *
   * User data includes the database they are stored in,
   * so the data is updated locally as well as in the database,
   * and returned in the same format as the input.
   */
  function updateClientData(UserData $data, int $meme): UserData {
    $newseen = $data->Seen | (1 << ($meme - 1));
    $newtries = $data->Tries + 1;
    if ($newtries > 999) {
      $newtries = 999;
    }
    $query = "UPDATE userdata SET Seen=" . $newseen . ", Tries=" . $newtries . " WHERE IP='" . $data->IP . "'";
    $data->Database->query($query);
    return new UserData($data->Database, $data->IP, $newseen, $newtries);
  }

  /**
   * @brief Gets the meme to display.
   * @param  $db    The database to access.
   * @param  $n     Index to the meme to fetch.
   * @return string The image tag with the correct path.
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
   * @param  $seen  The user's seen memes integer.
   * @param  $total The total count of memes in the database.
   * @return string The message to display on the page.
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
   * @param  $tries The number of tries by user.
   * @return string The message to display on the page.
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

class UserData {
  public mysqli $Database;
  public string $IP;
  public int $Seen;
  public int $Tries;
  function __construct(mysqli $db, string $ip, int $seen, int $tries) {
    $this->Database = $db;
    $this->IP = $ip;
    $this->Seen = $seen;
    $this->Tries = $tries;
  }
}

?>

