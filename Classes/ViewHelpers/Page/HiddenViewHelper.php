<?php
declare(strict_types=1);

namespace T3v\T3vDataMapper\ViewHelpers\Page;

use T3v\T3vCore\Service\LanguageService;
use T3v\T3vCore\ViewHelpers\AbstractConditionViewHelper;
use T3v\T3vDataMapper\Service\PageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * The hidden view helper class.
 *
 * @package T3v\T3vDataMapper\ViewHelpers\Page
 */
class HiddenViewHelper extends AbstractConditionViewHelper
{
    /**
     * The arguments initialization.
     */
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('uid', 'int', 'The UID of the page', true);
        $this->registerArgument('languageUid', 'int', 'The optional language UID', false, null);
    }

    /**
     * Evaluates the condition.
     *
     * @param array|null $arguments The arguments
     * @return bool Whether the condition is fulfilled
     */
    protected static function evaluateCondition($arguments = null): bool
    {
        $uid = intval($arguments['uid']);
        $languageUid = isset($arguments['languageUid']) ? intval($arguments['languageUid']) : self::getLanguageService()->getLanguageUid();
        $page = self::getPageService()->getPageByUid($uid, $languageUid);
        $hidden = (boolean) $page['hidden'];

        return $hidden;
    }

    /**
     * Gets the language service.
     *
     * @return \T3v\T3vCore\Service\LanguageService The language service
     */
    protected static function getLanguageService(): LanguageService
    {
        $languageService = GeneralUtility::makeInstance(LanguageService::class);

        return $languageService;
    }

    /**
     * Gets the page service.
     *
     * @return \T3v\T3vDataMapper\Service\PageService The page service
     */
    protected static function getPageService(): PageService
    {
        $pageService = GeneralUtility::makeInstance(PageService::class);

        return $pageService;
    }
}
