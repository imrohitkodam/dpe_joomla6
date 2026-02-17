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

use Joomla\CMS\Factory;

class RsticketsproViewRsticketspro extends HtmlView
{
	protected $buttons;
	// version info
	protected $code;
	protected $version;
	
	public function display($tpl = null)
	{
		$this->addToolbar();
		
		$this->buttons  	= $this->get('Buttons');
		$this->kbbuttons  	= $this->get('Kbbuttons');
		$this->code			= $this->get('code');
		$this->version		= (string) new RSTicketsProVersion();
		
		parent::display($tpl);
	}
	
	protected function addToolbar()
	{
		if (Factory::getUser()->authorise('core.admin', 'com_rsticketspro'))
		{
			\Joomla\CMS\Toolbar\ToolbarHelper::preferences('com_rsticketspro');
		}

		// set title
		\Joomla\CMS\Toolbar\ToolbarHelper::title('RSTickets! Pro', 'rsticketspro');

		RSTicketsProToolbarHelper::addToolbar('rsticketspro');
	}
}