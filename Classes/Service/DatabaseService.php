<?php
namespace T3v\T3vDataMapper\Service;

use Illuminate\Database\Capsule\Manager as Capsule;

use T3v\T3vCore\Service\AbstractService;

/**
 * The database service class.
 *
 * @package T3v\T3vDataMapper\Service
 */
class DatabaseService extends AbstractService {
  /**
   * Setup the Eloquent ORM.
   */
  public static function setup() {
    // First, create a new `Capsule` manager instance. Capsule aims to make configuring the library for usage outside of
    // the Laravel framework as easy as possible.
    $capsule = new Capsule();

    // Add connection to Capsule.
    $capsule->addConnection(self::getConnection());

    // Make this Capsule instance available globally via static methods.
    $capsule->setAsGlobal();

    // Setup the Eloquent ORM.
    $capsule->bootEloquent();
  }

  /**
   * Returns the connection configuration from the Global TYPO3 configuration options.
   *
   * @return array The connection configuration
   * @link https://laravel.com/docs/master/database#configuration The Laravel Database Configuration
   * @link https://docs.typo3.org/typo3cms/CoreApiReference/stable/ApiOverview/GlobalValues/GlobalVariables The TYPO3 Global variables
   */
  protected static function getConnection(): array {
    $extensionConfiguration = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['t3v_datamapper'];

    if (is_string($extensionConfiguration)) {
      $extensionConfiguration = @unserialize($extensionConfiguration);
    }

    $connection = [
      'driver'    => $extensionConfiguration['driver'] ?: 'mysql',
      'host'      => $GLOBALS['TYPO3_CONF_VARS']['DB']['host'],
      'username'  => $GLOBALS['TYPO3_CONF_VARS']['DB']['username'],
      'password'  => $GLOBALS['TYPO3_CONF_VARS']['DB']['password'],
      'database'  => $GLOBALS['TYPO3_CONF_VARS']['DB']['database'],
      'charset'   => $GLOBALS['TYPO3_CONF_VARS']['DB']['charset'] ?: 'utf8',
      'collation' => $GLOBALS['TYPO3_CONF_VARS']['DB']['collation'] ?: 'utf8_general_ci',
      'prefix'    => $GLOBALS['TYPO3_CONF_VARS']['DB']['prefix'] ?: ''
    ];

    return $connection;
  }
}
