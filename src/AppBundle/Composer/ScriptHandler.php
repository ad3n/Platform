<?php

/*
 * This file is part of the Platform package.
 *
 * (c) Muhammad Surya Ihsanuddin <surya.kejawen@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ihsan\AppBundle\Composer;

use Composer\Script\Event;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Sensio\Bundle\DistributionBundle\Composer\ScriptHandler as BaseScriptHandler;
use Symfony\Component\Yaml\Yaml;

/**
 * @author Muhammad Surya Ihsanuddin <surya.kejawen@gmail.com>
 */
class ScriptHandler extends BaseScriptHandler
{
    public static function doctrineCreateDatabase(Event $event)
    {
        $extras = $event->getComposer()->getPackage()->getExtra();
        if (!isset($extras['incenteev-parameters'])) {
            throw new \InvalidArgumentException('The parameter handler needs to be configured through the extra.incenteev-parameters setting.');
        }

        $configs = $extras['incenteev-parameters'];
        if (!file_exists($configs['file'])) {
            return;
        }

        $configParam = Yaml::parse(file_get_contents($configs['file']));

        $config = new Configuration();
        $connectionParams = array(
            'user' => $configParam['parameters']['database_user'],
            'password' => $configParam['parameters']['database_password'],
            'host' => $configParam['parameters']['database_host'],
            'port' => $configParam['parameters']['database_port'],
            'driver' => $configParam['parameters']['database_driver'],
        );

        $connection = DriverManager::getConnection($connectionParams, $config);
        try {
            $connection->getSchemaManager()->createDatabase($configParam['parameters']['database_name']);
        } catch (\Exception $e) {
        }
    }

    public static function doctrineCacheClear(Event $event)
    {
        $options = self::getOptions($event);
        $consoleDir = static::getConsoleDir($event, 'install assets');

        if (null === $consoleDir) {
            return;
        }

        static::executeCommand($event, $consoleDir, 'doctrine:cache:clear-metadata', $options['process-timeout']);
        static::executeCommand($event, $consoleDir, 'doctrine:cache:clear-query', $options['process-timeout']);
        static::executeCommand($event, $consoleDir, 'doctrine:cache:clear-result', $options['process-timeout']);
    }

    public static function generateSecretKey(Event $event)
    {
        $extras = $event->getComposer()->getPackage()->getExtra();

        if (!isset($extras['incenteev-parameters'])) {
            throw new \InvalidArgumentException('The parameter handler needs to be configured through the extra.incenteev-parameters setting.');
        }

        $configs = $extras['incenteev-parameters'];
        if (!is_array($configs)) {
            throw new \InvalidArgumentException('The extra.incenteev-parameters setting must be an array or a configuration object.');
        }
        $configs = self::processConfig($configs);

        if (file_exists($configs['file'])) {
            return;
        }

        $parameter = file_get_contents($configs['dist-file']);

        file_put_contents($configs['dist-file'], str_replace('%changeme%', sha1(date('YmdHis')), $parameter));
    }

    public static function platformSetup(Event $event)
    {
        $options = self::getOptions($event);
        $consoleDir = static::getConsoleDir($event, 'install assets');

        if (null === $consoleDir) {
            return;
        }

        static::executeCommand($event, $consoleDir, 'platform:setup', $options['process-timeout']);
    }

    private static function processConfig(array $config)
    {
        if (empty($config['file'])) {
            throw new \InvalidArgumentException('The extra.incenteev-parameters.file setting is required to use this script handler.');
        }

        if (empty($config['dist-file'])) {
            $config['dist-file'] = $config['file'].'.dist';
        }

        if (!is_file($config['dist-file'])) {
            throw new \InvalidArgumentException(sprintf('The dist file "%s" does not exist. Check your dist-file config or create it.', $config['dist-file']));
        }

        return $config;
    }
}
