<?php
/**
 * @package    RSTickets! Pro
 *
 * @copyright  (c) 2010 - 2016 RSJoomla!
 * @link       https://www.rsjoomla.com
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl-3.0.en.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

class RsticketsproControllerEmail extends \Joomla\CMS\MVC\Controller\FormController
{
	public function allowEdit($data = array(), $key = 'id')
	{
		return Factory::getUser()->authorise('email.edit', 'com_rsticketspro');
	}
}