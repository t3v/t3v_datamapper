<?php
namespace T3v\T3vDataMapper\ViewHelpers\Page;

use T3v\T3vDataMapper\ViewHelpers\Page\HiddenViewHelper;

/**
 * The visible view helper class.
 *
 * @package T3v\T3vDataMapper\ViewHelpers\Page
 */
class VisibleViewHelper extends HiddenViewHelper {
  /**
   * Evaluates the condition.
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

    return !$hidden;
  }
}