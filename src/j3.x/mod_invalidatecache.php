<?php
/**
 * @copyright   (C) 2021 Dimitris Grammatikogiannis
 * @license     GNU General Public License version 3
 */
defined('_JEXEC') || die('<html><head><script>location.href = location.origin</script></head></html>');

// Include dependencies.
JLoader::register('ModInvalidatecacheHelper', __DIR__ . '/helper.php');

require JModuleHelper::getLayoutPath('mod_invalidatecache', $params->get('layout', 'default'));
