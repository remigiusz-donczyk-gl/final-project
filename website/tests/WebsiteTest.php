<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
include_once('Functions.php');
include_once('Website.php');
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
    $f->expects($this->exactly(8))
      ->withConsecutive(
        [],
        [],
        [$db],
        [$db, '127.0.0.1'],
        [array(
          "Database" => $db,
          "IP"       => '127.0.0.1',
          "Seen"     => 3,
          "Tries"    => 2
        ), $this->anything()],
        [7, 10],
        [3],
        [$db, $this->anything()]
      )->willReturnOnConsecutiveCalls(
        '127.0.0.1',
        $db,
        10,
        array(
          "Database" => $db,
          "IP"       => '127.0.0.1',
          "Seen"     => 3,
          "Tries"    => 2
        ),
        array(
          "Dataase" => $db,
          "IP"      => '127.0.0.1',
          "Seen"    => 7,
          "Tries"   => 3
        ),
        '<p>You have seen 3/10 memes so far!</p>',
        '<p>You have tried 3 times so far.</p>',
        '<img src=data/test.png></img>'
      );
    $w = new Website();
    $w->run($f);
  }
}

?>

