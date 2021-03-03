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
use Joomla\CMS\UserHelper;

abstract class InvalidatecacheHelper
{
  /**
   * This is an Ajax endpoint that will
   * - execute only for admin users
   * - change the params column of the `lib_joomla`
   *   to {"mediaversion":"136e172fe6583c4f7207f11e37835952"}
   *   where the "136e172fe6583c4f7207f11e37835952" is an MD5 of
   *   the current date/time the function was called
   */
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
    }
  }
}
