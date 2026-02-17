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
use Joomla\CMS\MVC\Model\AdminModel;

class RsticketsproModelStaff extends \Joomla\CMS\MVC\Model\AdminModel
{
	public function getTable($type = 'Staff', $prefix = 'RsticketsproTable', $config = array())
	{
		return parent::getTable($type, $prefix, $config);
	}
	
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_rsticketspro.staff', 'staff', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}

		return $form;
	}
	
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = Factory::getApplication()->getUserState('com_rsticketspro.edit.staff.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}

		if (!empty($data->department_id) && !is_array($data->department_id))
		{
			$data->department_id = explode(',', $data->department_id);
		}

		return $data;
	}

	protected function canDelete($record)
	{
		return Factory::getUser()->authorise('staff.delete', 'com_rsticketspro');
	}
}