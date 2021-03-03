<?php
/**
 * @copyright   (C) 2021 Dimitris Grammatikogiannis
 * @license     GNU General Public License version 3
 */
defined('_JEXEC') || die('<html><head><script>location.href = location.origin</script></head></html>');

use Joomla\CMS\Helper\ModuleHelper;
use Ttc\Module\Invalidatecache\Administrator\Helper\InvalidatecacheHelper;

require ModuleHelper::getLayoutPath('mod_invalidatecache', $params->get('layout', 'default'));
