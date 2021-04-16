<?php
/**
 * @copyright   (C) 2021 Dimitris Grammatikogiannis
 * @license     GNU General Public License version 3
 */
namespace Ttc\Module\Invalidatecache\Administrator\Helper;

\defined('_JEXEC') or die;

use Joomla\CMS\Date\Date;
use Joomla\CMS\Factory;

class InvalidatecacheHelper
{
  public static function invalidateAjax()
  {
    $app = Factory::getApplication();
    if (!$app->getSession()->checkToken()) {
      throw new \Exception('Not Allowed');
    }

    if ($app->getIdentity()->authorise('core.admin')) {
      $db           = Factory::getContainer()->get('DatabaseDriver');
      $query        = $db->getQuery(true);
      $newTimestamp = md5((new Date())->toSql());
      $fields       = [$db->quoteName('params') . ' = ' . $db->quote('{"mediaversion":"' . $newTimestamp . '"}')];
      $conditions   = [
        $db->quoteName('name') . ' = ' . $db->quote('lib_joomla'),
        $db->quoteName('type') . ' = ' . $db->quote('library'),
        $db->quoteName('element') . ' = ' . $db->quote('joomla'),
        $db->quoteName('client_id') . ' = 0',
      ];

      $query->update($db->quoteName('#__extensions'))->set($fields)->where($conditions);
      $db->setQuery($query);
      $db->execute();

      foreach (glob(JPATH_ROOT . '/media/**/joomla.asset.json') as $filename) {
        if ($filename === JPATH_ROOT . '/media/vendor/joomla.asset.json') {
          continue;
        }

        try {
          $fileContent = \file_get_contents($filename);
        } catch (\Exception $e) {}

        if ($fileContent) {
          try {
            $json = \json_decode($fileContent);
          } catch (\Exception $e) {}

          if ($json) {
            foreach ($json->assets as $k => $v) {
              if (!empty($v->version)) {
                $v->version = $newTimestamp;
              }
            }
            \file_put_contents($filename, \json_encode($json, JSON_PRETTY_PRINT));
          }
        }
      }
      return true;
    }
  }
}
