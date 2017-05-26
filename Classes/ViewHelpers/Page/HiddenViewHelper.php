<?php
namespace T3v\T3vDataMapper\ViewHelpers\Page;

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Extbase\Object\ObjectManager;

use \T3v\T3vCore\ViewHelpers\AbstractConditionViewHelper;

use \T3v\T3vDataMapper\Service\PageService;

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
  }

  /**
   * Evaluate the condition.
   *
   * @param array|null $arguments The arguments
   * @return boolean Whether the condition is fulfilled
   */
  static protected function evaluateCondition($arguments = null) {
    $uid             = intval($arguments['uid']);
    $languageOverlay = isset($arguments['languageOverlay']) ? (boolean) $arguments['languageOverlay'] : null;
    $pageService     = self::getPageService();
    $page            = $pageService->getPageByUid($uid, $languageOverlay);
    $hidden          = (boolean) $page['hidden'];

    return $hidden;
  }

  /**
   * Helper function to get the page service.
   *
   * @return \T3v\T3vDataMapper\Service\PageService The page service
   */
  static protected function getPageService() {
    $objectManager = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
    $pageService   = $objectManager->get('T3v\T3vDataMapper\Service\PageService');

    return $pageService;
  }
}