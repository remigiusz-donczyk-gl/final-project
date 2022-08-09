<?php declare(strict_types=1);

/**
 * @brief The main entrypoint class, which runs all commands.
 *
 * The main entrypoint, meant to be directly called from the website index,
 * which runs all necessary commands and returns a list of printable messages.
 */
class Website {

  /**
   * @brief The main entrypoint method.
   * @param[in] $f  An instance of a class extending Functions.
   * @return    msg A list of messages to be printed by the website.
   */
  function run(Functions $f): array {
    $ip = $f->getRealClientIP();
    $db = $f->connectToDatabase();
    $memes = $f->getMemeAmount($db);
    $random = rand(1, $memes);
    $olddata = $f->getClientData($db, $ip);
    $data = $f->updateClientData($olddata, $random);
    return array(
      "count" => $f->getCountMessage($data["Seen"], $memes),
      "try"   => $f->getTryMessage($data["Tries"]),
      "image" => $f->getImageEmbed($db, $random)
    );
  }
}

?>

