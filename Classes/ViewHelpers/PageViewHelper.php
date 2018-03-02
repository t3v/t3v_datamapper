<?php
namespace T3v\T3vDataMapper\ViewHelpers;

use T3v\T3vCore\ViewHelpers\AbstractViewHelper;

use T3v\T3vDataMapper\Service\PageService;

/**
 * The page view helper class.
 *
 * @package T3v\T3vDataMapper\ViewHelpers
 */
class PageViewHelper extends AbstractViewHelper {
  /**
   * The page service.
   *
   * @var \T3v\T3vDataMapper\Service\PageService
   * @inject
   */
  protected $pageService;

  /**
   * The view helper render function.
   *
   * @param int $uid The UID of the page
   * @param boolean $languageOverlay If set, the language record (overlay) will be applied
   * @param int $languageUid The optional language UID, defaults to the UID of the current system language
   * @return object The page object
   */
  public function render($uid, $languageOverlay = null, $languageUid = null) {
    $uid             = intval($uid);
    $languageOverlay = isset($languageOverlay) ? (boolean) $languageOverlay : null;
    $languageUid     = isset($languageUid) ? intval($languageUid) : $this->languageService->getLanguageUid();

    return $this->pageService->getPageByUid($uid, $languageOverlay, $languageUid);
  }
}