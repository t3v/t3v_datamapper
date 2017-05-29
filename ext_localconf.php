<?php
defined('TYPO3_MODE') or die('Access denied.');

call_user_func(function ($namespace, $extkey) {
  $extensionSignature = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($namespace . '.' . $extkey);

  // === Commands ===

  if (TYPO3_MODE === 'BE') {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][$extkey] = \T3v\T3vDataMapper\Command\Page\LanguageOverlayCommandController::class;
  }
}, 't3v', $_EXTKEY);