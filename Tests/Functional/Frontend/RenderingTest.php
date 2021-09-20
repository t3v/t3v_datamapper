<?php
declare(strict_types=1);

namespace T3v\T3vDataMapper\Tests\Functional\Frontend;

use T3v\T3vTesting\Tests\Functional\Frontend\Traits\SetupTrait;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * The rendering test class.
 *
 * @package T3v\T3vDataMapper\Tests\Functional\Frontend
 */
class RenderingTest extends FunctionalTestCase
{
    /**
     * Use the setup trait.
     */
    use SetupTrait;

    /**
     * The core extensions to load.
     *
     * @var array
     */
    protected $coreExtensionsToLoad = [
        'core',
        'frontend'
    ];

    /**
     * The test extensions to load.
     *
     * @var array
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/t3v_datamapper',
        'typo3conf/ext/t3v_core',
        'typo3conf/ext/t3v_testing'
    ];

    /**
     * The paths to link in the test instance.
     *
     * @var array
     */
    protected $pathsToLinkInTestInstance = [
    ];

    /**
     * Tests if the template is rendered.
     *
     * @test
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function templateIsRendered(): void
    {
        $response = $this->executeFrontendRequest(
            (new InternalRequest())->withPageId(1)
        );

        if ($response->getStatusCode() === 200) {
            $document = new \DomDocument();
            $document->loadHTML((string)$response->getBody());
            $xpath = new \DOMXPath($document);
            $titleTag = $xpath->query('/html/head/title')->item(0);
            $generatorMetaTag = $xpath->query('/html/head/meta[@name="generator"]')->item(0);

            self::assertEquals('Home | T3v DataMapper', $titleTag->nodeValue);
            self::assertEquals('TYPO3 CMS', $generatorMetaTag->getAttribute('content'));
        }
    }

    /**
     * Setup before running tests.
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws \TYPO3\TestingFramework\Core\Exception
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->importDataSet('EXT:t3v_testing/Tests/Functional/Fixtures/Database/Pages.xml');
        $this->importDataSet('EXT:t3v_testing/Tests/Functional/Fixtures/Database/Content.xml');

        $this->setUpFrontendRootPage(
            1,
            [
                'constants' => [
                    'EXT:t3v_testing/Configuration/TypoScript/constants.typoscript',
                    'EXT:t3v_testing/Tests/Functional/Frontend/Fixtures/TypoScript/constants.typoscript'
                ],
                'setup' => [
                    'EXT:t3v_testing/Configuration/TypoScript/setup.typoscript',
                    'EXT:t3v_testing/Tests/Functional/Frontend/Fixtures/TypoScript/setup.typoscript'
                ]
            ]
        );

        $this->setUpFrontend(1, 'T3v DataMapper');
    }
}
