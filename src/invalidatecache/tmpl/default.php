<?php
/**
 * @copyright   (C) 2021 Dimitris Grammatikogiannis
 * @license     GNU General Public License version 3
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Session\Session;

defined('_JEXEC') || die('<html><head><script>location.href = location.origin</script></head></html>');

Factory::getApplication()
  ->getDocument()
  ->getWebAssetManager()
  ->registerAndUseScript(
    'mod_invalidatecache.default',
    'mod_invalidatecache/default.js',
    [],
    ['type' => 'module'],
    ['core']
  );

$icon = <<<SVG
<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 297 297" style="width: 1.5rem; height:1.5rem; fill: currentColor"><title>Bin</title><defs/>
  <path d="M216.979 150.445c-24.601 0-44.615 20.014-44.615 44.615s20.014 44.615 44.615 44.615c24.6 0 44.615-20.014 44.615-44.615s-20.014-44.615-44.615-44.615zm21.889 56.965a6.747 6.747 0 010 9.539 6.729 6.729 0 01-4.769 1.975 6.729 6.729 0 01-4.769-1.975l-12.35-12.35-12.35 12.35c-1.317 1.316-3.044 1.975-4.769 1.975s-3.452-.659-4.769-1.975a6.747 6.747 0 010-9.539l12.35-12.35-12.352-12.35a6.747 6.747 0 010-9.539 6.749 6.749 0 019.539 0l12.35 12.35 12.35-12.35a6.749 6.749 0 019.539 0 6.747 6.747 0 010 9.539l-12.35 12.35 12.35 12.35zM227.354 59.832c-.001-10.822-8.806-19.626-19.628-19.626H55.033c-10.822 0-19.626 8.804-19.626 19.626v18.244h191.948V59.832zM216.979 136.957c1.233 0 2.454.052 3.668.128l2.716-45.521h-47.368v62.351c10.515-10.473 25.004-16.958 40.984-16.958zM103.885 13.488h54.99v13.229h13.488V6.744A6.743 6.743 0 00165.619 0H97.14a6.743 6.743 0 00-6.744 6.744v19.973h13.488V13.488z"/><path d="M175.994 273.748c0 5.393-4.372 9.764-9.764 9.764a9.763 9.763 0 01-9.764-9.764V91.564h-50.173v182.184c0 5.393-4.372 9.764-9.764 9.764a9.763 9.763 0 01-9.764-9.764V91.564H39.398l11.881 199.094A6.744 6.744 0 0058.01 297h146.739a6.744 6.744 0 006.732-6.342l2.243-37.591c-14.686-.815-27.934-7.104-37.73-16.862v37.543z"/>
</svg>
SVG;

echo
'<div class="header-item-content">',
  '<button class="js_modInvalidatecach d-flex align-items-stretch" style="border: 0; background-color:inherit" title="Invalidate Cache" data-token="', Session::getFormToken(), '" disabled>',
    '<div class="d-flex align-items-end mx-auto">', $icon, '</div>',
    '<div class="tiny">Invalidate Cache</div>',
  '</button>',
'</div>';
