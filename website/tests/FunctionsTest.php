<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
include_once "Functions.php";

/**
 * for whatever reason phpunit needs to know that the test class
 * is using its own functions to run tests, pretty stupid
 * @uses FunctionsTest
 */
final class FunctionsTest extends TestCase {

  /**
   * @covers Functions::countSetBits
   */
  public function testCountSetBits(): void {
    $f = new Functions();
    // no chance of passing this test randomly on such a large int
    $this->assertEquals(30, $f->countSetBits(12750421999));
  }

  /**
   * @uses MysqliResultMockOne
   * @covers Functions::getMemeAmount
   */
  public function testGetMemeAmount(): void {
    $f = new Functions();
    $db = $this->createMock(mysqli::class);
    $db->expects($this->once())
       ->method("query")
       ->with($this->equalTo("SELECT * FROM memes"))
       ->will($this->returnValue(new MysqliResultMockOne));
    $this->assertEquals(2, $f->getMemeAmount($db));
  }

  /**
   * @covers Functions::getRealClientIP
   */
  public function testGetRealClientIP(): void {
    $f = new Functions();
    // try in the order that will override less important values
    // try the default value
    $_SERVER['REMOTE_ADDR'] = "127.0.0.1";
    $this->assertEquals("127.0.0.1", $f->getRealClientIP());
    // try X_Forwarded_For, which overrides default
    $_SERVER['HTTP_X_FORWARDED_FOR'] = "127.0.0.2";
    $this->assertEquals("127.0.0.2", $f->getRealClientIP());
    // try HTTP_CLIENT_IP, which overrides both
    $_SERVER['HTTP_CLIENT_IP'] = "127.0.0.3";
    $this->assertEquals('127.0.0.3', $f->getRealClientIP());
  }

  /**
   * @covers Functions::createClientData
   */
  public function testCreateClientData(): void {
    $f = new Functions();
    $db = $this->createMock(mysqli::class);
    $this->assertEquals(array(
      "Database" => $db,
      "IP"       => "127.0.0.1",
      "Seen"     => 0,
      "Tries"    => 0
    ), $f->createClientData($db, "127.0.0.1"));
  }

  /**
   * @uses MysqliResultMockTwo
   * @uses MysqliResultMockThree
   * @uses Functions::createClientData
   * @covers Functions::getClientData
   */
  public function testGetClientData(): void {
    $f = new Functions();
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
    $this->assertEquals(array(
      "Database" => $db,
      "IP"       => "127.0.0.1",
      "Seen"     => 85,
      "Tries"    => 4
    ), $f->getClientData($db, "127.0.0.1"));
    // try without an existing user IP -> calls createClientData
    $this->assertEquals(array(
      "Database" => $db,
      "IP"       => "127.0.0.1",
      "Seen"     => 0,
      "Tries"    => 0
    ), $f->getClientData($db, "127.0.0.1"));
  }

  /**
   * @covers Functions::updateClientData
   */
  public function testUpdateClientData(): void {
    $f = new Functions();
    $db = $this->createMock(mysqli::class);
    $db->expects($this->exactly(2))
       ->method('query')
       ->withConsecutive(
         [$this->equalTo("UPDATE userdata SET Seen=117, Tries=5 WHERE IP='127.0.0.1'")],
         [$this->equalTo("UPDATE userdata SET Seen=93, Tries=999 WHERE IP='127.0.0.1'")]
       );
    // try with less than 999 `tries`, adds one to tries
    $data = array(
      "Database" => $db,
      "IP" => "127.0.0.1",
      "Seen" => 85,
      "Tries" => 4
    );
    $this->assertEquals(array(
      "Database" => $db,
      "IP" => "127.0.0.1",
      "Seen" => 117,
      "Tries" => 5
    ), $f->updateClientData($data, 6));
    // try with 999 or more `tries`, does not add one
    $data = array(
      "Database" => $db,
      "IP" => "127.0.0.1",
      "Seen" => 85,
      "Tries" => 999
    );
    $this->assertEquals(array(
      "Database" => $db,
      "IP" => "127.0.0.1",
      "Seen" => 93,
      "Tries" => 999
    ), $f->updateClientData($data, 4));
  }

  /**
   * @uses MysqliResultMockFour
   * @covers Functions::getImage
   */
  public function testGetImageEmbed(): void {
    $f = new Functions();
    $db = $this->createMock(mysqli::class);
    $db->expects($this->once())
       ->method('query')
       ->with($this->equalTo("SELECT Path FROM memes WHERE Id=6"))
       ->will($this->returnValue(new MysqliResultMockFour));
    $this->assertEquals("<img src=data/test.png></img>", $f->getImageEmbed($db, 6));
  }

  /**
   * @uses Functions::countSetBits
   * @covers Functions::getCountMessage
   */
  public function testGetCountMessage(): void {
    $f = new Functions();
    // try without all memes seen
    $this->assertEquals("<p>You have seen 5/10 memes so far!</p>", $f->getCountMessage(117, 10));
    // try with all memes seen
    $this->assertEquals("<p>You have seen all of the memes!</p>", $f->getCountMessage(1023, 10));
  }

  /**
   * @covers Functions::getTryMessage
   */
  public function testGetTryMessage(): void {
    $f = new Functions();
    // try with a normal amount of tries
    $this->assertEquals("<p>You have tried 3 times so far.</p>", $f->getTryMessage(3));
    // try with a stupid amount of tries (>=999) for the easter egg
    $this->assertEquals("<p>You have tried <i>too many</i> times, seriously.</p>", $f->getTryMessage(999));
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

