<?php
namespace T3v\T3vDataMapper\Tests\Unit;

use \TYPO3\CMS\Core\Tests\UnitTestCase;

use \T3v\T3vDataMapper\Tests\Unit\Fixtures\LoadableClass;

class FirstClassTest extends UnitTestCase {
  /**
   * @test
   */
  public function methodReturnsTrue() {
    $firstClassObject = new LoadableClass();

    $this->assertTrue($firstClassObject->returnsTrue());
  }

  /**
   * @test
   */
  public function viewHelperBaseClassIsLoadable() {
    $this->assertTrue(class_exists('TYPO3\\CMS\\Fluid\\Tests\\Unit\\ViewHelpers\\ViewHelperBaseTestcase'));
  }
}