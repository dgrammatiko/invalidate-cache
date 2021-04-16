<?php
/**
 * @copyright   (C) 2021 Dimitris Grammatikogiannis
 * @license     GNU General Public License version 3
 */
namespace Ttc\Module\Invalidatecache\Administrator\Helper;

\defined('_JEXEC') || die('<html><head><script>location.href = location.origin</script></head></html>');

use Joomla\CMS\Date\Date;
use Joomla\CMS\Factory;
use Joomla\CMS\Session\Session;

class InvalidatecacheHelper
{
  public static function invalidateAjax()
  {
    if (!Session::checkToken()) {
      throw new \Exception('Not Allowed');
    }

    if (Factory::getUser()->authorise('core.admin')) {
      $db           = Factory::getDbo();
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

      return true;
    }
  }
}



//{"mediaversion":"136e172fe6583c4f7207f11e37835952"}
///{"mediaversion":"a7e6ffa782fcc2f893a57ee6fb1bd2a8"}
