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

class RsticketsproModelNote extends \Joomla\CMS\MVC\Model\AdminModel
{
	public function getTable($type = 'Ticketnotes', $prefix = 'RsticketsproTable', $config = array())
	{
		return parent::getTable($type, $prefix, $config);
	}
	
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_rsticketspro.note', 'note', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}

		$form->setValue('ticket_id', null, $this->getTicketId());

		return $form;
	}
	
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$app  = Factory::getApplication();
		$data = $app->getUserState('com_rsticketspro.edit.note.data', array());
		
		if (empty($data))
		{
			$data = $this->getItem();
		}

		return $data;
	}
	
	public function getRSFieldset() {
		require_once JPATH_ADMINISTRATOR.'/components/com_rsticketspro/helpers/adapters/fieldset.php';
		
		$fieldset = new RSFieldset();
		return $fieldset;
	}
	
	public function getTicketId() {
		return Factory::getApplication()->getInput()->getInt('ticket_id');
	}
	
	protected function canDelete($record)
	{
		static $permissions;
		static $userId;
		if (is_null($permissions))
		{
			$permissions = RSTicketsProHelper::getCurrentPermissions();
		}
		if (is_null($userId))
		{
			$userId = Factory::getUser()->id;
		}

		return ($permissions->delete_note && $record->user_id == $userId) || ($permissions->delete_note_staff && $record->user_id != $userId);
	}
	
	public function validate($form, $data, $group = null) {
		$validData = parent::validate($form, $data, $group);
		if (!empty($data['id'])) {
			$validData['user_id'] = null;
		} else {
			$validData['user_id'] = Factory::getUser()->id;
		}
		$validData['ticket_id'] = Factory::getApplication()->getInput()->getInt('ticket_id');
		return $validData;
	}
}