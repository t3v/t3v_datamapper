<?php
namespace T3v\T3vDataMapper\Tests\Functional;

use Nimut\TestingFramework\Http\Response;
use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use PHPUnit\Util\PHP\DefaultPhpProcess;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * The rendering test class.
 *
 * @package T3v\T3vDataMapper\Tests\Functional
 */
class RenderingTest extends FunctionalTestCase
{
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
    protected $testExtensionsToLoad = [
        'typo3conf/ext/t3v_core',
        'typo3conf/ext/t3v_datamapper'
    ];

    /**
     * Tests if the template is rendered.
     *
     * @test
     */
    public function templateIsRendered()
    {
        $expectedDom = new \DomDocument();
        $expectedDom->preserveWhiteSpace = false;
        $expectedDom->loadHTML('<h1>T3v DataMapper</h1>');

        $actualDom = new \DomDocument();
        $actualDom->preserveWhiteSpace = false;
        $actualDom->loadHTML($this->fetchFrontendResponse(['id' => '1'])->getContent());

        $this->assertXmlStringEqualsXmlString($expectedDom->saveHTML(), $actualDom->saveHTML());
    }

    /**
     * Setup before running tests.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->importDataSet(__DIR__ . '/Fixtures/Database/Pages.xml');

        $this->setUpFrontendRootPage(1, ['EXT:t3v_datamapper/Tests/Functional/Fixtures/Frontend/Basic.typoscript']);
    }

    /**
     * Helper function to fetch the Frontend response.
     *
     * @param array $requestArguments The request arguments
     * @param bool $failOnFailure Fail on failure, defaults to `true`
     * @return \Nimut\TestingFramework\Http\Response The Frontend response
     */
    protected function fetchFrontendResponse(array $requestArguments, bool $failOnFailure = true)
    {
        if (!empty($requestArguments['url'])) {
            $requestUrl = '/' . ltrim($requestArguments['url'], '/');
        } else {
            $requestUrl = '/?' . GeneralUtility::implodeArrayForUrl('', $requestArguments);
        }

        if (property_exists($this, 'instancePath')) {
            $instancePath = $this->instancePath;
        } else {
            $instancePath = $this->getInstancePath();
        }

        $arguments = [
            'documentRoot' => $instancePath,
            'requestUrl' => 'http://localhost' . $requestUrl
        ];

        $template = new \Text_Template('ntf://Frontend/Request.tpl');
        $template->setVar(
            [
                'arguments' => var_export($arguments, true),
                'originalRoot' => ORIGINAL_ROOT,
                'ntfRoot' => __DIR__ . '/../../.build/vendor/nimut/testing-framework/'
            ]
        );

        $php = DefaultPhpProcess::factory();
        $response = $php->runJob($template->render());
        $result = json_decode($response['stdout'], true);

        if ($result === null) {
            $this->fail('Frontend Response is empty:' . LF . 'Error: ' . LF . $response['stderr']);
        }

        if ($result['status'] === Response::STATUS_Failure && $failOnFailure) {
            $this->fail('Frontend Response has failure:' . LF . $result['error']);
        }

        $response = new Response($result['status'], $result['content'], $result['error']);

        return $response;
    }
}
