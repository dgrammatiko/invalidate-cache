<?php
/**
 * @copyright   (C) 2021 Dimitris Grammatikogiannis
 * @license     GNU General Public License version 3
 */
defined('_JEXEC') || die('<html><head><script>location.href = location.origin</script></head></html>');

use Joomla\CMS\Extension\Service\Provider\HelperFactory;
use Joomla\CMS\Extension\Service\Provider\Module;
use Joomla\CMS\Extension\Service\Provider\ModuleDispatcherFactory;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

return new class implements ServiceProviderInterface
{
 	public function register(Container $container)
	{
		$container->registerServiceProvider(new ModuleDispatcherFactory('\\Ttc\\Module\\Invalidatecache'));
		$container->registerServiceProvider(new HelperFactory('\\Ttc\\Module\\Invalidatecache\\Administrator\\Helper'));
		$container->registerServiceProvider(new Module);
	}
};
