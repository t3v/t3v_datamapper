<?php
namespace T3v\T3vDataMapper\Command;

use TYPO3\CMS\Core\Database\QueryGenerator;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use LucidFrame\Console\ConsoleTable;

use T3v\T3vCore\Command\AbstractCommandController;
use T3v\T3vCore\Utility\StringUtility;

use T3v\T3vDataMapper\Domain\Model\Page;
use T3v\T3vDataMapper\Domain\Model\Page\LanguageOverlay;
use T3v\T3vDataMapper\Service\DatabaseService;

/**
 * The page language overlay command controller class.
 *
 * @package T3v\T3vDataMapper\Command
 */
class PageLanguageOverlayCommandController extends AbstractCommandController {
  /**
   * The query generator.
   *
   * @var \TYPO3\CMS\Core\Database\QueryGenerator
   * @inject
   */
  protected $queryGenerator;

  /**
   * The database service.
   *
   * @var \T3v\T3vDataMapper\Service\DatabaseService
   * @inject
   */
  protected $databaseService;

  /**
   * Lists page language overlays.
   *
   * @param int $sysLanguageUid The system language UID of the page language overlays to list
   * @param int $pid The optional PID of the page to search from, defaults to `1`
   * @param int $recursion The optional recursion, defaults to `99`
   * @param string $exclude The optional UIDs of pages to exclude from as string, seperated by `,`, empty by default
   */
  public function listCommand(int $sysLanguageUid, int $pid = 1, int $recursion = 99, string $exclude = '') {
    $this->beforeCommand();

    $table = new ConsoleTable();
    $table->setHeaders(['UID', 'Title', 'Page ID', 'Status']);

    foreach ($this->getPageUids($pid, $recursion, $exclude) as $pageUid) {
      $languageOverlay = LanguageOverlay::where([['pid', '=', $pageUid], ['sys_language_uid', '=', $sysLanguageUid]])->first();

      if ($languageOverlay) {
        $uid    = $languageOverlay->uid;
        $title  = StringUtility::asciify($languageOverlay->title);
        $status = $languageOverlay->hidden ? 'hidden' : 'visible';

        $table->addRow([$uid, $title, $pageUid, $status]);
      }
    }

    $table->display();
  }

  /**
   * Initializes page language overlays.
   *
   * @param int $sysLanguageUid The system language UID of the page language overlays to initialize
   * @param int $pid The optional PID of the page to search from, defaults to `1`
   * @param int $recursion The optional recursion, defaults to `99`
   * @param string $exclude The optional UIDs of pages to exclude from as string, seperated by `,`, empty by default
   * @param bool $verbose The optional verbosity, defaults to `false`
   */
  public function initializeCommand(int $sysLanguageUid, int $pid = 1, int $recursion = 99, string $exclude = '', bool $verbose = false) {
    $this->beforeCommand();

    foreach ($this->getPageUids($pid, $recursion, $exclude) as $pageUid) {
      $languageOverlay = LanguageOverlay::where([['pid', '=', $pageUid], ['sys_language_uid', '=', $sysLanguageUid]])->first();

      if ($languageOverlay) {
        $uid   = $languageOverlay->uid;
        $title = $languageOverlay->title;

        $this->log("Language overlay `{$title}` ({$uid}) for the page with UID {$pageUid} already exists, skipping...", 'warning', $verbose);
      } else {
        $page = Page::where([['uid', '=', $pageUid]])->first();

        $languageOverlay                     = new LanguageOverlay;
        $languageOverlay->pid                = $pageUid;
        $languageOverlay->sys_language_uid   = $sysLanguageUid;
        $languageOverlay->doktype            = $page->doktype;
        $languageOverlay->title              = $page->title;
        $languageOverlay->nav_title          = $page->nav_title;
        $languageOverlay->title              = $page->title;
        $languageOverlay->keywords           = $page->keywords;
        $languageOverlay->description        = $page->description;
        $languageOverlay->abstract           = $page->abstract;
        $languageOverlay->author             = $page->author;
        $languageOverlay->author_email       = $page->author_email;
        $languageOverlay->tx_t3vpage_summary = $page->tx_t3vpage_summary;
        $languageOverlay->tx_t3vpage_claim   = $page->tx_t3vpage_claim;
        $languageOverlay->tx_t3vpage_outline = $page->tx_t3vpage_outline;
        $languageOverlay->save();

        $this->log("New page language overlay for the page with UID {$pageUid} initialized.", 'ok', $verbose);
      }
    }
  }

  /**
   * Hides page language overlays.
   *
   * @param int $sysLanguageUid The system language UID of the page language overlays to hide
   * @param int $pid The optional PID of the page to search from, defaults to `1`
   * @param int $recursion The optional recursion, defaults to `99`
   * @param string $exclude The optional UIDs of pages to exclude from as string, seperated by `,`, empty by default
   * @param bool $verbose The optional verbosity, defaults to `false`
   */
  public function hideCommand(int $sysLanguageUid, int $pid = 1, int $recursion = 99, string $exclude = '', bool $verbose = false) {
    $this->beforeCommand();

    foreach ($this->getPageUids($pid, $recursion, $exclude) as $pageUid) {
      $languageOverlay = LanguageOverlay::where([['pid', '=', $pageUid], ['sys_language_uid', '=', $sysLanguageUid]])->first();

      if ($languageOverlay) {
        $uid    = $languageOverlay->uid;
        $title  = $languageOverlay->title;
        $hidden = $languageOverlay->hidden;

        if (!$hidden) {
          $languageOverlay->hidden = true;
          $languageOverlay->save();

          $this->log("Language overlay `{$title}` ({$uid}) of the page with UID {$pageUid} is now hidden.", 'ok', $verbose);
        } else {
          $this->log("Language overlay `{$title}` ({$uid}) of the page with UID {$pageUid} is already hidden, skipping...", 'warning', $verbose);
        }
      }
    }
  }

  /**
   * Unhides page language overlays.
   *
   * @param int $sysLanguageUid The system language UID of the page language overlays to unhide
   * @param int $pid The optional PID of the page to search from, defaults to `1`
   * @param int $recursion The optional recursion, defaults to `99`
   * @param string $exclude The optional UIDs of pages to exclude from as string, seperated by `,`, empty by default
   * @param bool $verbose The optional verbosity, defaults to `false`
   */
  public function unhideCommand(int $sysLanguageUid, int $pid = 1, int $recursion = 99, string $exclude = '', bool $verbose = false) {
    $this->beforeCommand();

    foreach ($this->getPageUids($pid, $recursion, $exclude) as $pageUid) {
      $languageOverlay = LanguageOverlay::where([['pid', '=', $pageUid], ['sys_language_uid', '=', $sysLanguageUid]])->first();

      if ($languageOverlay) {
        $uid    = $languageOverlay->uid;
        $title  = $languageOverlay->title;
        $hidden = $languageOverlay->hidden;

        if ($hidden) {
          $languageOverlay->hidden = false;
          $languageOverlay->save();

          $this->log("Language overlay `{$title}` ({$uid}) of the page with UID {$pageUid} is now visible.", 'ok', $verbose);
        } else {
          $this->log("Language overlay `{$title}` ({$uid}) of the page with UID {$pageUid} is already visible, skipping...", 'warning', $verbose);
        }
      }
    }
  }

  /**
   * Gets executed before a command.
   */
  protected function beforeCommand() {
    $this->databaseService->setup();
  }

  /**
   * Gets page UIDs.
   *
   * @param int $pid The optional PID of the page to search from, defaults to `1`
   * @param int $recursion The optional recursion, defaults to `99`
   * @param string $exclude The optional UIDs of pages to exclude from as string, seperated by `,`, empty by default
   */
  protected function getPageUids(int $pid = 1, int $recursion = 99, string $exclude = '') {
    $exclude       = $exclude === '-' ? '' : $exclude;
    $exclude       = GeneralUtility::intExplode(',', $exclude, true);
    $pagesTreeList = $this->queryGenerator->getTreeList($pid, $recursion, 0, 1);
    $pageUids      = GeneralUtility::intExplode(',', $pagesTreeList, true);
    $pageUids      = array_diff($pageUids, $exclude);

    return $pageUids;
  }
}