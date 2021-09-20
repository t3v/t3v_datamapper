<?php
declare(strict_types=1);

namespace T3v\T3vDataMapper\Service;

use Illuminate\Database\Capsule\Manager as Capsule;
use T3v\T3vCore\Service\AbstractService;

/**
 * The database service class.
 *
 * @package T3v\T3vDataMapper\Service
 */
class DatabaseService extends AbstractService
{
    /**
     * Setup the Eloquent ORM.
     *
     * @param string $connection The optional connection, defaults to `Default`
     */
    public static function setup(string $connection = 'Default'): void
    {
        // First, create a new `Capsule` manager instance. Capsule aims to make configuring the library for usage outside of the Laravel
        // framework as easy as possible.
        $capsule = new Capsule();

        // Add connection to Capsule:
        $capsule->addConnection(self::getConnection($connection));

        // Make this Capsule instance available globally via static methods:
        $capsule->setAsGlobal();

        // Setup the Eloquent ORM:
        $capsule->bootEloquent();
    }

    /**
     * Returns the connection configuration from the Global TYPO3 configuration options.
     *
     * @param string $connection The optional connection, defaults to `Default`
     * @return array The connection configuration
     * @link https://laravel.com/docs/master/database#configuration The Laravel Database Configuration
     * @link https://docs.typo3.org/typo3cms/CoreApiReference/stable/ApiOverview/GlobalValues/GlobalVariables The TYPO3 Global variables
     */
    protected static function getConnection(string $connection = 'Default'): array
    {
        $configuration = [];

        if (is_array($GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][$connection])) {
            $extensionConfiguration = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['t3v_datamapper'];

            // TODO TYPO3 10 compatibility
            // $extensionConfiguration = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            //     \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class
            // )->get('t3v_datamapper');

            if (is_string($extensionConfiguration)) {
                $extensionConfiguration = @unserialize($extensionConfiguration, false);
            }

            $configuration = [
                'driver' => $extensionConfiguration['driver'] ?: 'mysql',
                'host' => $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][$connection]['host'],
                'username' => $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][$connection]['user'],
                'password' => $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][$connection]['password'],
                'database' => $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][$connection]['dbname'],
                'charset' => $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][$connection]['charset'] ?: 'utf8',
                'collation' => $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][$connection]['collation'] ?: 'utf8_general_ci',
                'prefix' => $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][$connection]['prefix'] ?: ''
            ];
        }

        return $configuration;
    }
}
