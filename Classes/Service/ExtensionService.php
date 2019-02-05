<?php
namespace T3v\T3vDataMapper\Service;

use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

use T3v\T3vCore\Service\AbstractService;

/**
 * The extension service class.
 *
 * @package T3v\T3vDataMapper\Service
 */
class ExtensionService extends AbstractService {
  /**
   * The modes which T3v DataMapper supports.
   */
  const STRICT_MODE   = 'strict';
  const FALLBACK_MODE = 'fallback';

  /**
   * Checks if T3v DataMapper is running in `strict` mode.
   *
   * @return bool If T3v DataMapper is running in `strict` mode
   */
  public function runningInStrictMode(): bool {
    $strictMode = true;
    $settings   = $this->getSettings();

    if (is_array($settings) && !empty($settings)) {
      $mode = $settings['mode'];

      if ($mode != self::STRICT_MODE) {
        $strictMode = false;
      }
    }

    return $strictMode;
  }

  /**
   * Checks if T3v DataMapper is running in `fallback` mode.
   *
   * @return bool If T3v DataMapper is running in `fallback` mode
   */
  public function runningInFallbackMode(): bool {
    $fallbackMode = false;
    $settings     = $this->getSettings();

    if (is_array($settings) && !empty($settings)) {
      $mode = $settings['mode'];

      if ($mode === self::FALLBACK_MODE) {
        $fallbackMode = true;
      }
    }

    return $fallbackMode;
  }

  /**
   * Gets the settings from `plugin.tx_t3vdatamapper.settings`.
   *
   * @return array The settings
   */
  protected function getSettings(): array {
    $configurationManager = $this->objectManager->get(ConfigurationManagerInterface::class);
    $configuration        = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

    return $configuration['plugin.']['tx_t3vdatamapper.']['settings.'];
  }
}
