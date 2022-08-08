<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
include_once("Functions.php");
include_once("Website.php");
/**
 * for whatever reason phpunit needs to know that the test class
 * is using its own functions to run tests, pretty stupid
 * @uses WebsiteTest
 */
final class WebsiteTest extends TestCase {

  /**
   * @uses Functions
   * @covers Website
   */
  public function testWebsite(): void {
    $db = $this->createMock(mysqli::class);
    $f = $this->createMock(Functions::class);

    $f->expects($this->exactly(1))
      ->method("getRealClientIP")
      ->will($this->returnValue("127.0.0.1"));

    $f->expects($this->exactly(1))
      ->method("connectToDatabase")
      ->will($this->returnValue($db));

    $f->expects($this->exactly(1))
      ->method("getMemeAmount")
      ->with($db)
      ->will($this->returnValue(10));

    $olddataparam = array(
      "Database" => $db,
      "IP"       => "127.0.0.1",
      "Seen"     => 3,
      "Tries"    => 2
    );

    $f->expects($this->exactly(1))
      ->method("getClientData")
      ->with($db, "127.0.0.1")
      ->will($this->returnValue($olddataparam));

    $newdataparam = array(
      "Database" => $db,
      "IP"       => "127.0.0.1",
      "Seen"     => 7,
      "Tries"    => 3
    );

    $f->expects($this->exactly(1))
      ->method("updateClientData")
      ->with($olddataparam, $this->callback(function($random) {
        return is_int($random);
      }))
      ->will($this->returnValue($newdataparam));

    $f->expects($this->exactly(1))
      ->method("getCountMessage")
      ->with(7, 10)
      ->will($this->returnValue("<p>You have seen 3/10 memes so far!</p>"));

    $f->expects($this->exactly(1))
      ->method("getTryMessage")
      ->with(3)
      ->will($this->returnValue("<p>You have tried 3 times so far.</p>"));

    $f->expects($this->exactly(1))
	  ->method('getImage')
      ->with($db, $this->callback(function($random) {
        return is_int($random);
      }))
      ->will($this->returnValue("<img src=data/test.png></img>"));

    $w = new Website();
    $w->run($f);
  }
}

?>
