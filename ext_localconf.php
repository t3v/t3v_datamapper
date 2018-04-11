<?php
defined('TYPO3_MODE') or die();

// === Variables ===

$extensionKey = $_EXTKEY;

// === Backend ===

// Avoid that this block is loaded in the Frontend
if (TYPO3_MODE === 'BE') {
  // --- Extbase Command Controllers ---

  $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][$extensionKey] = \T3v\T3vDataMapper\Command\PageLanguageOverlayCommandController::class;
}