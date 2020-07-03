<?php
/**
 * @see \Tms\PackageSetup
 */

namespace plugin\Link2transfer;

use P5\Lang;

/**
 * Application install class.
 */
final class Setup extends \Tms\PackageSetup
{
    /**
     * Current version number.
     */
    const VERSION = "1.0.0";

    /**
     * Object constructor.
     *
     * @param Tms\App $app
     * @param string  $installed_version
     */
    public function __construct(\Tms\App $app, $installed_version)
    {
        $this->app = $app;
        $this->installed_version = $installed_version;
    }

    /**
     * Namespace of this package.
     *
     * @return string
     */
    public static function getNameSpace()
    {
        return __NAMESPACE__;
    }

    /**
     * Description of this package.
     *
     * @see P5\Lang::translate()
     *
     * @return string
     */
    public static function getDescription()
    {
        return Lang::translate('APP_DETAIL', __CLASS__);
    }

    /**
     * Execute install/update package.
     *
     * @param array &$configuration
     *
     * @return bool
     */
    public function update(&$configuration)
    {
        $result = false;
        if (false !== $this->updateDatabase(__DIR__)
         && false !== $this->updateConfiguration($configuration)
        ) {
            $result = true;
        }

        $key = ($result) ? 'SUCCESS_SETUP' : 'FAILED_SETUP';
        $this->message = Lang::translate($key);

        return $result;
    }

    /**
     * Update configuration.
     *
     * @param array &$configuration
     *
     * @return bool
     */
    private function updateConfiguration(&$configuration)
    {
        $class = __NAMESPACE__;
        if (!isset($configuration['plugins'])) {
            $configuration['plugins'] = ['paths' => []];
        }
        $configuration['plugins']['paths'][] = $class;

        return true;
    }
}
