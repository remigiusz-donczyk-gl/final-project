<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
include_once "Website.php";

/**
 * @uses WebsiteTest
 *
 * phpunit needs to know that the test class
 * is using its own functions to run tests
 */
final class WebsiteTest extends TestCase {

  /**
   * @covers Website::countSetBits
   */
  public function testCountSetBits(): void {
    $w = new Website();
    // no chance of passing this test by accident on such a large int
    $this->assertEquals(30, $w->countSetBits(12750421999));
  }

  /**
   * @uses MysqliResultMockOne
   * @covers Website::getMemeAmount
   */
  public function testGetMemeAmount(): void {
    $w = new Website();
    $db = $this->createMock(mysqli::class);
    $db->expects($this->exactly(1))
       ->method("query")
       ->with($this->equalTo("SELECT * FROM memes"))
       ->willReturn(new MysqliResultMockOne);
    $this->assertEquals(2, $w->getMemeAmount($db));
  }

  /**
   * @covers Website::getRealClientIP
   */
  public function testGetRealClientIP(): void {
    $w = new Website();
    // try the default variable
    $_SERVER['REMOTE_ADDR'] = "127.0.0.1";
    $this->assertEquals("127.0.0.1", $w->getRealClientIP());
    // try X_Forwarded_For, which overrides default
    $_SERVER['HTTP_X_FORWARDED_FOR'] = "127.0.0.2";
    $this->assertEquals("127.0.0.2", $w->getRealClientIP());
    // try HTTP_CLIENT_IP, which overrides both
    $_SERVER['HTTP_CLIENT_IP'] = "127.0.0.3";
    $this->assertEquals('127.0.0.3', $w->getRealClientIP());
  }

  /**
   * @uses UserData::__construct
   * @covers Website::createClientData
   */
  public function testCreateClientData(): void {
    $w = new Website();
    $db = $this->createMock(mysqli::class);
    $this->assertEquals(new UserData($db, "127.0.0.1", 0, 0), $w->createClientData($db, "127.0.0.1"));
  }

  /**
   * @uses UserData::__construct
   * @uses MysqliResultMockTwo
   * @uses MysqliResultMockThree
   * @uses Website::createClientData
   * @covers Website::getClientData
   */
  public function testGetClientData(): void {
    $w = new Website();
    $db = $this->createMock(mysqli::class);
    $db->expects($this->exactly(3))
       ->method("query")
       ->withConsecutive(
         [$this->equalTo("SELECT Seen, Tries FROM userdata WHERE IP='127.0.0.1'")],
         [$this->equalTo("SELECT Seen, Tries FROM userdata WHERE IP='127.0.0.1'")],
         [$this->equalTo("INSERT INTO userdata (IP) VALUES ('127.0.0.1')")]
       )
       ->willReturnOnConsecutiveCalls(
         $this->returnValue(new MysqliResultMockTwo),
         $this->returnValue(new MysqliResultMockThree),
         null
       );
    // try with an existing user IP
    $this->assertEquals(new UserData($db, "127.0.0.1", 85, 4), $w->getClientData($db, "127.0.0.1"));
    // try without an existing user IP -> calls createClientData
    $this->assertEquals(new UserData($db, "127.0.0.1", 0, 0), $w->getClientData($db, "127.0.0.1"));
  }

  /**
   * @uses UserData::__construct
   * @covers Website::updateClientData
   */
  public function testUpdateClientData(): void {
    $w = new Website();
    $db = $this->createMock(mysqli::class);
    $db->expects($this->exactly(2))
       ->method('query')
       ->withConsecutive(
         [$this->equalTo("UPDATE userdata SET Seen=117, Tries=5 WHERE IP='127.0.0.1'")],
         [$this->equalTo("UPDATE userdata SET Seen=93, Tries=999 WHERE IP='127.0.0.1'")]
       );
    // try with less than 999 `tries`, adds one to tries
    $data = new UserData($db, "127.0.0.1", 85, 4);
    $this->assertEquals(new UserData($db, "127.0.0.1", 117, 5), $w->updateClientData($data, 6));
    // try with 999 or more `tries`, does not add one
    $data = new UserData($db, "127.0.0.1", 85, 999);
    $this->assertEquals(new UserData($db, "127.0.0.1", 93, 999), $w->updateClientData($data, 4));
  }

  /**
   * @uses MysqliResultMockFour
   * @covers Website::getImageEmbed
   */
  public function testGetImageEmbed(): void {
    $w = new Website();
    $db = $this->createMock(mysqli::class);
    $db->expects($this->exactly(1))
       ->method('query')
       ->with($this->equalTo("SELECT Path FROM memes WHERE Id=6"))
       ->willReturn(new MysqliResultMockFour);
    $this->assertEquals("<img id=meme src=data/test.png></img>", $w->getImageEmbed($db, 6));
  }

  /**
   * @uses Website::countSetBits
   * @covers Website::getCountMessage
   */
  public function testGetCountMessage(): void {
    $w = new Website();
    // try without all memes seen
    $this->assertEquals("<p>You have seen 5/10 memes so far!</p>", $w->getCountMessage(117, 10));
    // try with all memes seen
    $this->assertEquals("<p>You have seen all of the memes!</p>", $w->getCountMessage(1023, 10));
  }

  /**
   * @covers Website::getTryMessage
   */
  public function testGetTryMessage(): void {
    $w = new Website();
    // try with a normal amount of tries
    $this->assertEquals("<p>You have tried 3 times so far.</p>", $w->getTryMessage(3));
    // try with a stupid amount of tries (>=999) for the easter egg
    $this->assertEquals("<p>You have tried <i>too many</i> times, seriously.</p>", $w->getTryMessage(999));
  }

  /**
   * @uses UserData::__construct
   * @covers Website
   */
  public function testRun(): void {
    $db = $this->createMock(mysqli::class);
    $w = $this->getMockBuilder(Website::class)
              ->setMethodsExcept(["run"])
              ->disableOriginalConstructor()
              ->getMock();

    $w->expects($this->exactly(1))
      ->method("getRealClientIP")
      ->willReturn("127.0.0.1");

    $w->expects($this->exactly(1))
      ->method("connectToDatabase")
      ->willReturn($db);

    $w->expects($this->exactly(1))
      ->method("getMemeAmount")
      ->with($db)
      ->willReturn(10);

    $olddataparam = new UserData($db, "127.0.0.1", 3, 2);
    $w->expects($this->exactly(1))
      ->method("getClientData")
      ->with($db, "127.0.0.1")
      ->willReturn($olddataparam);

    $newdataparam = new UserData($db, "127.0.0.1", 7, 3);
    $w->expects($this->exactly(1))
      ->method("updateClientData")
      ->with($olddataparam, $this->callback(function($random) {
        return is_int($random);
      }))
      ->willReturn($newdataparam);

    $w->expects($this->exactly(1))
      ->method("getCountMessage")
      ->with(7, 10)
      ->willReturn("<p>You have seen 3/10 memes so far!</p>");

    $w->expects($this->exactly(1))
      ->method("getTryMessage")
      ->with(3)
      ->willReturn("<p>You have tried 3 times so far.</p>");

    $w->expects($this->exactly(1))
	    ->method("getImageEmbed")
      ->with($db, $this->callback(function($random) {
        return is_int($random);
      }))
      ->willReturn("<img src=data/test.png></img>");

    $w->run();
  }
}

class MysqliResultMockOne {
  public int $num_rows = 2;
}

class MysqliResultMockTwo {
  public int $num_rows = 1;
  public function fetch_array(): array {
    return array(
      "Seen"  => 85,
      "Tries" => 4
    );
  }
}

class MysqliResultMockThree {
  public int $num_rows = 0;
}

class MysqliResultMockFour {
  public function fetch_array(): array {
    return array(
      "Path" => "test.png"
    );
  }
}

?>

