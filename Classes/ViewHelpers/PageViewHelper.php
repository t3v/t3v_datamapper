<?php
namespace T3v\T3vDataMapper\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

use T3v\T3vCore\Service\LanguageService;
use T3v\T3vCore\ViewHelpers\AbstractViewHelper;

use T3v\T3vDataMapper\Service\PageService;

/**
 * The page view helper class.
 *
 * @package T3v\T3vDataMapper\ViewHelpers
 */
class PageViewHelper extends AbstractViewHelper implements CompilableInterface {
  /**
   * Use the compile with render static trait.
   */
  use CompileWithRenderStatic;

  /**
   * Initializes the arguments.
   */
  public function initializeArguments(): void {
    parent::initializeArguments();

    $this->registerArgument('uid', 'int', 'The UID of the page', true, null);
    $this->registerArgument('languageUid', 'int', 'The optional language UID', false, null);
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
  protected static function getLanguageService(): LanguageService {
    $languageService = GeneralUtility::makeInstance(LanguageService::class);

    return $languageService;
  }

  /**
   * Gets the page service.
   *
   * @return \T3v\T3vDataMapper\Service\PageService The page service
   */
  protected static function getPageService(): PageService {
    $pageService = GeneralUtility::makeInstance(PageService::class);

    return $pageService;
  }
}
