<?php
namespace T3v\T3vDataMapper\Tests\Functional;

use \TYPO3\CMS\Core\Tests\Functional\Framework\Frontend\Response;
use \TYPO3\CMS\Core\Tests\FunctionalTestCase;
use \TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Rendering Test Class
 */
class RenderingTest extends FunctionalTestCase {
  /**
   * The core extensions to load.
   *
   * @var array
   */
  protected $coreExtensionsToLoad = ['fluid'];

  /**
   * The test extensions to load.
   *
   * @var array
   */
  protected $testExtensionsToLoad = ['typo3conf/ext/t3v_datamapper'];

  /**
   * Set up.
   *
   * @return void
   */
  public function setUp() {
    parent::setUp();

    $this->importDataSet(__DIR__ . '/Fixtures/Database/Pages.xml');
    $this->setUpFrontendRootPage(1, ['EXT:t3v_datamapper/Tests/Functional/Fixtures/Frontend/Basic.ts']);
  }

  /**
   * Test if template is rendered.
   *
   * @test
   */
  public function templateIsRendered() {
    $expectedDom = new \DomDocument();
    $expectedDom->loadHTML('<h1>T3v DataMapper</h1>');
    $expectedDom->preserveWhiteSpace = false;

    $actualDom = new \DomDocument();
    $actualDom->loadHTML($this->fetchFrontendResponse(['id' => '1'])->getContent());
    $actualDom->preserveWhiteSpace = false;

    $this->assertEquals($expectedDom->saveHTML(), $actualDom->saveHTML());
  }

  /**
   * Helper function to fetch frontend response.
   *
   * @param array $requestArguments The request arguments
   * @param boolean $failOnFailure Fail on failure, defaults to `true`
   * @return Response The response
   */
  protected function fetchFrontendResponse(array $requestArguments, $failOnFailure = true) {
    if (!empty($requestArguments['url'])) {
      $requestUrl = '/' . ltrim($requestArguments['url'], '/');
    } else {
      $requestUrl = '/?' . GeneralUtility::implodeArrayForUrl('', $requestArguments);
    }

    if (property_exists($this, 'instancePath')) {
      $instancePath = $this->instancePath;
    } else {
      $instancePath = ORIGINAL_ROOT . 'typo3temp/functional-' . substr(sha1(get_class($this)), 0, 7);
    }

    $arguments = [
      'documentRoot' => $instancePath,
      'requestUrl' => 'http://localhost' . $requestUrl
    ];

    $template = new \Text_Template(ORIGINAL_ROOT . 'typo3/sysext/core/Tests/Functional/Fixtures/Frontend/request.tpl');
    $template->setVar(['arguments' => var_export($arguments, true), 'originalRoot' => ORIGINAL_ROOT]);

    $php = \PHPUnit_Util_PHP::factory();
    $response = $php->runJob($template->render());
    $result = json_decode($response['stdout'], true);

    if ($result === null) {
      $this->fail('Frontend Response is empty');
    }

    if ($failOnFailure && $result['status'] === Response::STATUS_Failure) {
      $this->fail('Frontend Response has failure:' . LF . $result['error']);
    }

    $response = new Response($result['status'], $result['content'], $result['error']);

    return $response;
  }
}