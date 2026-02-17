<?php
/**
 * @package    RSTickets! Pro
 *
 * @copyright  (c) 2010 - 2016 RSJoomla!
 * @link       https://www.rsjoomla.com
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl-3.0.en.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\Controller\BaseController;

use Joomla\CMS\Router\Route;

use Joomla\CMS\Language\Text;

use Joomla\CMS\Factory;

class RsticketsproControllerKbtemplate extends BaseController
{
    public function __construct($config = array())
	{
		parent::__construct($config);
		
		$this->registerTask('apply', 'save');
	}
	
	public function cancel() {
		JSession::checkToken() or jexit(Text::_('JINVALID_TOKEN'));
		
		$this->setRedirect(Route::_('index.php?option=com_rsticketspro&view=knowledgebase', false));
	}
	
	public function save() {
		JSession::checkToken() or jexit(Text::_('JINVALID_TOKEN'));
		
		$input = Factory::getApplication()->input;
		$data  = $input->get('jform', array(), 'array');
		$model = $this->getModel('kbtemplate');
		
		if (!$model->save($data)) {
			$this->setMessage($model->getError(), 'error');
		} else {
			$this->setMessage(Text::_('RST_KB_TEMPLATE_SAVED_OK', 'info'));
		}
		
		$task = $this->getTask();
		if ($task == 'save') {
			$this->setRedirect(Route::_('index.php?option=com_rsticketspro&view=knowledgebase', false));
		} elseif ($task == 'apply') {
			$this->setRedirect(Route::_('index.php?option=com_rsticketspro&view=kbtemplate', false));
		}
	}
}