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
   * @return bool Whether the condition is fulfilled
   */
  protected static function evaluateCondition($arguments = null): bool {
    $uid         = intval($arguments['uid']);
    $languageUid = isset($arguments['languageUid']) ? intval($arguments['languageUid']) : self::getLanguageService()->getLanguageUid();
    $page        = self::getPageService()->getPageByUid($uid, $languageUid);
    $hidden      = (boolean) $page['hidden'];

    return !$hidden;
  }
}