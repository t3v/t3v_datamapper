<?php
namespace T3v\T3vDataMapper\ViewHelpers\Page;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

use T3v\T3vCore\Service\LanguageService;
use T3v\T3vCore\ViewHelpers\AbstractConditionViewHelper;

use T3v\T3vDataMapper\Service\PageService;

/**
 * Hidden View Helper Class
 *
 * @package T3v\T3vDataMapper\ViewHelpers\Page
 */
class HiddenViewHelper extends AbstractConditionViewHelper {
  /**
   * The arguments initialization.
   */
  public function initializeArguments() {
    parent::initializeArguments();

    $this->registerArgument('uid', 'int', 'The UID of the page', true);
    $this->registerArgument('languageOverlay', 'boolean', 'If set, the language record (overlay) will be applied', false, null);
    $this->registerArgument('languageUid', 'int', 'The optional language UID, defaults to the UID of the current system language', false, null);
  }

  /**
   * Evaluate the condition.
   *
   * @param array|null $arguments The arguments
   * @return boolean Whether the condition is fulfilled
   */
  static protected function evaluateCondition($arguments = null) {
    $languageService = self::getLanguageService();
    $pageService     = self::getPageService();

    $uid             = intval($arguments['uid']);
    $languageOverlay = isset($arguments['languageOverlay']) ? (boolean) $arguments['languageOverlay'] : null;
    $languageUid     = isset($arguments['languageUid']) ? intval($arguments['languageUid']) : $languageService->getLanguageUid();
    $page            = $pageService->getPageByUid($uid, $languageOverlay, $languageUid);
    $hidden          = (boolean) $page['hidden'];

    return $hidden;
  }

  /**
   * Helper function to get the language service.
   *
   * @return T3v\T3vCore\Service\LanguageService The language service
   */
  static protected function getLanguageService() {
    $objectManager   = GeneralUtility::makeInstance(ObjectManager::class);
    $languageService = $objectManager->get(LanguageService::class);

    return $languageService;
  }

  /**
   * Helper function to get the page service.
   *
   * @return T3v\T3vDataMapper\Service\PageService The page service
   */
  static protected function getPageService() {
    $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
    $pageService   = $objectManager->get(PageService::class);

    return $pageService;
  }
}