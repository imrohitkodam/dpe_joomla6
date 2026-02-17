<?php
/**
 * @package    RSTickets! Pro
 *
 * @copyright  (c) 2010 - 2016 RSJoomla!
 * @link       https://www.rsjoomla.com
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl-3.0.en.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\View\HtmlView;

use Joomla\CMS\Language\Text;

use Joomla\CMS\Factory;

class RsticketsproViewPredefinedsearch extends HtmlView
{
	protected $form;
	protected $item;
	
	public function display($tpl = null)
	{
		Factory::getApplication()->getInput()->set('hidemainmenu', true);

		$this->addToolbar();
		
		$this->form	= $this->get('Form');
		$this->item	= $this->get('Item');
		
		parent::display($tpl);
	}
	
	protected function addToolbar()
	{
		// set title
		\Joomla\CMS\Toolbar\ToolbarHelper::title('RSTickets! Pro', 'rsticketspro');

		RSTicketsProToolbarHelper::addToolbar('tickets');
		
		\Joomla\CMS\Toolbar\ToolbarHelper::apply('predefinedsearch.apply');
		\Joomla\CMS\Toolbar\ToolbarHelper::save('predefinedsearch.save');
		\Joomla\CMS\Toolbar\ToolbarHelper::cancel('predefinedsearch.cancel');
	}

	protected function showField($label, $desc)
	{
		echo '<p><strong>' . $label . '</strong><br>' . $desc . '</p>';
	}
	
	protected function getDepartments($ids)
	{
		$db 	 = Factory::getDbo();
		$results = array();

		if (!is_array($ids))
		{
			$ids = (array) $ids;
		}
		
		if (!$ids)
		{
			return $results;
		}
		
		$filtered_ids = array();
		foreach ($ids as $id)
		{
			$filtered_ids[] = $db->q($id);
		}
		
		// Load departments
		$query = $db->getQuery(true);
		$query->select($db->qn('name'))
			->from($db->qn('#__rsticketspro_departments'))
			->where($db->qn('id') . ' IN ('.implode(',', $filtered_ids).')');
		
		if ($results = $db->setQuery($query)->loadColumn())
		{
			foreach ($results as $k => $result)
			{
				$results[$k] = Text::_($result);
			}
		}
		
		return $results;
	}
	
	protected function getPriorities($ids)
	{
		$db 	 = Factory::getDbo();
		$results = array();

		if (!is_array($ids))
		{
			$ids = (array) $ids;
		}
		
		if (!$ids)
		{
			return $results;
		}
		
		$filtered_ids = array();
		foreach ($ids as $id)
		{
			$filtered_ids[] = $db->q($id);
		}
		
		// Load priorities
		$query = $db->getQuery(true);
		$query->select($db->qn('name'))
			->from($db->qn('#__rsticketspro_priorities'))
			->where($db->qn('id') . ' IN ('.implode(',', $filtered_ids).')');
		
		if ($results = $db->setQuery($query)->loadColumn())
		{
			foreach ($results as $k => $result)
			{
				$results[$k] = Text::_($result);
			}
		}
		
		return $results;
	}
	
	protected function getStatuses($ids)
	{
		$db 	 = Factory::getDbo();
		$results = array();

		if (!is_array($ids))
		{
			$ids = (array) $ids;
		}
		
		if (!$ids)
		{
			return $results;
		}
		
		$filtered_ids = array();
		foreach ($ids as $id)
		{
			$filtered_ids[] = $db->q($id);
		}
		
		// Load statuses
		$query = $db->getQuery(true);
		$query->select($db->qn('name'))
			->from($db->qn('#__rsticketspro_statuses'))
			->where($db->qn('id') . ' IN ('.implode(',', $filtered_ids).')');
		
		if ($results = $db->setQuery($query)->loadColumn())
		{
			foreach ($results as $k => $result)
			{
				$results[$k] = Text::_($result);
			}
		}
		
		return $results;
	}
}