<?php
/**
* @version 2.0.0
* @package RSTickets! Pro 2.0.0
* @copyright (C) 2010 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\View\HtmlView;

use Joomla\CMS\Language\Text;

use Joomla\CMS\Factory;

class RsticketsproViewCron extends HtmlView
{
	protected $form;
	protected $item;
	protected $tabs;
	
	public function display($tpl = null)
	{
		Factory::getApplication()->getInput()->set('hidemainmenu', true);

		// form
		$this->form	= $this->get('Form');
		$this->item	= $this->get('Item');
		$this->tabs	= $this->get('RSTabs');
		
		$this->addToolbar();

		parent::display($tpl);
	}
	
	protected function addToolbar()
	{
        Factory::getApplication()->enqueueMessage(Text::_('RST_CRON_WARNING'), 'notice');
		\Joomla\CMS\Toolbar\ToolbarHelper::title('RSTickets! Pro <small>['.Text::_('RST_EDIT_ACCOUNT').']</small>','rsticketspro');

		RSTicketsProToolbarHelper::addToolbar('crons');

		\Joomla\CMS\Toolbar\ToolbarHelper::apply('cron.apply');
		\Joomla\CMS\Toolbar\ToolbarHelper::save('cron.save');
		\Joomla\CMS\Toolbar\ToolbarHelper::cancel('cron.cancel');

		if (!empty($this->item->id))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::modal('rsticketsproCronModal', 'icon-refresh', Text::_('RST_ACCOUNT_TEST_CONNECTION'));
		}
	}
}