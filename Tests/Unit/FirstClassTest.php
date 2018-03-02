<?php
namespace T3v\T3vDataMapper\Tests\Unit;

use Nimut\TestingFramework\TestCase\UnitTestCase;

use T3v\T3vDataMapper\Tests\Unit\Fixtures\LoadableClass;

/**
 * The first class test class.
 *
 * @package T3v\T3vDataMapper\Tests\Unit
 */
class FirstClassTest extends UnitTestCase {
  /**
   * Test if method returns true.
   *
   * @test
   */
  public function methodReturnsTrue() {
    $firstClassObject = new LoadableClass();

    $this->assertTrue($firstClassObject->returnsTrue());
  }
}