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

use Joomla\CMS\MVC\Controller\FormController;

class RsticketsproControllerDepartment extends FormController
{
	public function allowAdd($data = array())
	{
		return Factory::getUser()->authorise('department.create', 'com_rsticketspro');
	}

	public function allowEdit($data = array(), $key = 'id')
	{
		return Factory::getUser()->authorise('department.edit', 'com_rsticketspro');
	}
}