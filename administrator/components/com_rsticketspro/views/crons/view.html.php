<?php
/**
* @version 2.0.0
* @package RSTickets! Pro 2.0.0
* @copyright (C) 2010 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\View\HtmlView;

class RsticketsproViewCrons extends HtmlView
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

		RSTicketsProToolbarHelper::addToolbar('crons');
		
		\Joomla\CMS\Toolbar\ToolbarHelper::addNew('cron.add');
		\Joomla\CMS\Toolbar\ToolbarHelper::editList('cron.edit');
		\Joomla\CMS\Toolbar\ToolbarHelper::divider();
		\Joomla\CMS\Toolbar\ToolbarHelper::publish('crons.publish');
		\Joomla\CMS\Toolbar\ToolbarHelper::unpublish('crons.unpublish');
		\Joomla\CMS\Toolbar\ToolbarHelper::deleteList('RST_CONFIRM_DELETE', 'crons.delete');
	}
}