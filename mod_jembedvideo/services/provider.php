<?php
defined('_JEXEC') or die;

use Joomla\CMS\Extension\Service\Provider\ModuleDispatcherFactory;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

return new class implements ServiceProviderInterface
{
	/**
	 * Регистрирует сервис-провайдер в DI контейнере.
	 *
	 * @param   Container  $container  DI контейнер.
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	public function register(Container $container)
	{
		$container->registerServiceProvider(new ModuleDispatcherFactory('mod_jembedvideo'));
	}
};
