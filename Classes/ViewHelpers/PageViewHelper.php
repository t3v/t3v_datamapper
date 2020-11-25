<?php

namespace T3v\T3vDataMapper\ViewHelpers;

use T3v\T3vCore\Service\LocalizationService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use T3v\T3vCore\ViewHelpers\AbstractViewHelper;

use T3v\T3vDataMapper\Service\PageService;

/**
 * The page view helper class.
 *
 * @package T3v\T3vDataMapper\ViewHelpers
 */
class PageViewHelper extends AbstractViewHelper
{


    /**
     * Initializes the arguments.
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();

        $this->registerArgument('uid', 'int', 'The UID of the page', true, null);
        $this->registerArgument('languageUid', 'int', 'The optional language UID', false, null);
    }

    /**
     * The view helper render static function.
     *
     * @param array $arguments The arguments
     * @param \Closure $renderChildrenClosure The render children closure
     * @param RenderingContextInterface $renderingContext The rendering context
     * @return array|null The page object
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $uid = (int)$arguments['uid'];
        $languageUid = isset($arguments['languageUid']) ? (int)$arguments['languageUid'] : self::getLanguageService()->getLanguageUid();

        return self::getPageService()->getPageByUid($uid, $languageUid);
    }

    /**
     * Gets the language service.
     *
     * @return LocalizationService The language service
     */
    protected static function getLanguageService(): LocalizationService
    {
        return GeneralUtility::makeInstance(LocalizationService::class);
    }

    /**
     * Gets the page service.
     *
     * @return \T3v\T3vDataMapper\Service\PageService The page service
     */
    protected static function getPageService(): PageService
    {
        return GeneralUtility::makeInstance(PageService::class);

    }
}
