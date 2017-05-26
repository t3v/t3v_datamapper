<?php
namespace T3v\T3vDataMapper\ViewHelpers\Page;

use \T3v\T3vDataMapper\ViewHelpers\Page\HiddenViewHelper;

/**
 * Visible View Helper Class
 *
 * @package T3v\T3vDataMapper\ViewHelpers\Page
 */
class VisibleViewHelper extends HiddenViewHelper {
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

    return !$hidden;
  }
}