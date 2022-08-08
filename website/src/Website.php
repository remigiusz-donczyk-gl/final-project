<?php declare(strict_types=1);

class Website {

  function run(Functions $f): array {
    $ip = $f->getRealClientIP();
    $db = $f->connectToDatabase();
    //  get the total amount of memes and generate a random index
    $memes = $f->getMemeAmount($db);
    $random = rand(1, $memes);
    //  get the current client data and update it with the random meme
    $olddata = $f->getClientData($db, $ip);
    $data = $f->updateClientData($olddata, $random);
    //  return x/y memes shown and the amount of times tried
    return array(
      "count" => $f->getCountMessage($data["Seen"], $memes),
      "try"   => $f->getTryMessage($data["Tries"]),
      "image" => $f->getImage($db, $random)
    );
  }
}

?>

