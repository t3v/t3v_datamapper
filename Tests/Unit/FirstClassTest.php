<?php
namespace T3v\T3vDataMapper\Tests\Unit;

use \TYPO3\CMS\Core\Tests\UnitTestCase;

use \T3v\T3vDataMapper\Tests\Unit\Fixtures\LoadableClass;

/**
 * First Class Test Class
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

  /**
   * Test if view helper base class is loadable.
   *
   * @test
   */
  public function viewHelperBaseClassIsLoadable() {
    $this->assertTrue(class_exists('TYPO3\\CMS\\Fluid\\Tests\\Unit\\ViewHelpers\\ViewHelperBaseTestcase'));
  }
}