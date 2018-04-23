<?php
namespace T3v\T3vDataMapper\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;

use T3v\T3vCore\Service\LanguageService;

use T3v\T3vDataMapper\Service\PageService;

/**
 * The page view helper class.
 *
 * @package T3v\T3vDataMapper\ViewHelpers
 */
class PageViewHelper extends AbstractViewHelper implements CompilableInterface {
  /**
   * The view helper render function.
   *
   * @param int $uid The UID of the page
   * @param int $languageUid The optional language UID, defaults to the UID of the current system language
   * @return string The rendered output
   */
  public function render(int $uid, int $languageUid = null) {
    return static::renderStatic(
      [
        'uid'         => $uid,
        'languageUid' => $languageUid
      ],
      $this->buildRenderChildrenClosure(),
      $this->renderingContext
    );
  }

  /**
   * The view helper render static function.
   *
   * @param array $arguments The arguments
   * @param callable $renderChildrenClosure The render children closure
   * @param RenderingContextInterface $renderingContext The rendering context
   * @return object The page object
   */
  public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext) {
    $uid         = intval($arguments['uid']);
    $languageUid = isset($arguments['languageUid']) ? intval($arguments['languageUid']) : self::getLanguageService()->getLanguageUid();

    return self::getPageService()->getPageByUid($uid, $languageUid);
  }

  /**
   * Gets the language service.
   *
   * @return \T3v\T3vCore\Service\LanguageService The language service
   */
  protected static function getLanguageService() {
    $objectManager   = GeneralUtility::makeInstance(ObjectManager::class);
    $languageService = $objectManager->get(LanguageService::class);

    return $languageService;
  }

  /**
   * Gets the page service.
   *
   * @return \T3v\T3vDataMapper\Service\PageService The page service
   */
  protected static function getPageService() {
    $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
    $pageService   = $objectManager->get(PageService::class);

    return $pageService;
  }
}