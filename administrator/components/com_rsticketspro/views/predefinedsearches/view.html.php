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

class RsticketsproViewPredefinedsearches extends HtmlView
{
	protected $items;
	protected $pagination;
	protected $state;
	
	public function display($tpl = null)
	{
		$this->addToolbar();

		$this->items 		 = $this->get('Items');
		$this->pagination 	 = $this->get('Pagination');
		$this->state 		 = $this->get('State');
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');
		
		parent::display($tpl);
	}
	
	protected function addToolbar()
	{
		// set title
		\Joomla\CMS\Toolbar\ToolbarHelper::title('RSTickets! Pro', 'rsticketspro');

		RSTicketsProToolbarHelper::addToolbar('tickets');
		
		\Joomla\CMS\Toolbar\ToolbarHelper::addNew('predefinedsearch.add');
		\Joomla\CMS\Toolbar\ToolbarHelper::editList('predefinedsearch.edit');
		\Joomla\CMS\Toolbar\ToolbarHelper::divider();
		\Joomla\CMS\Toolbar\ToolbarHelper::publish('predefinedsearches.publish', 'JTOOLBAR_PUBLISH', true);
		\Joomla\CMS\Toolbar\ToolbarHelper::unpublish('predefinedsearches.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		\Joomla\CMS\Toolbar\ToolbarHelper::divider();
		\Joomla\CMS\Toolbar\ToolbarHelper::deleteList('RST_CONFIRM_DELETE', 'predefinedsearches.delete');
		\Joomla\CMS\Toolbar\ToolbarHelper::cancel('predefinedsearches.cancel');
	}
}