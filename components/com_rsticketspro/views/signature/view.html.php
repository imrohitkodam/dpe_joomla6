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

use Joomla\CMS\Uri\Uri;

use Joomla\CMS\Router\Route;

use Joomla\CMS\Language\Text;

use Joomla\CMS\Factory;

class RsticketsproViewSignature extends HtmlView
{
	public function display($tpl = null)
	{
		$this->canAccess();
		
		$this->form			= $this->get('Form');
		$this->params		= Factory::getApplication()->getParams('com_rsticketspro');
		$this->show_footer	= RSTicketsProHelper::getConfig('rsticketspro_link');
		$this->footer		= RSTicketsProHelper::getFooter();
		$this->globalMessage 		    = Text::_(RSTicketsProHelper::getConfig('global_message'));
		$this->globalMessagePosition	= RSTicketsProHelper::getConfig('global_message_position');
		
		$this->prepareDocument();

		parent::display($tpl);
	}
	
	protected function prepareDocument()
	{
		// Description
		if ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		// Keywords
		if ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		// Robots
		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
	}
	
	protected function canAccess()
	{
		$app	= Factory::getApplication();
		$user	= Factory::getUser();
		
		if ($user->get('guest'))
		{
			$app->redirect(Route::_('index.php?option=com_users&view=login&return=' . base64_encode((string) Uri::getInstance()), false));
		}
		
		if (!RSTicketsProHelper::isStaff())
		{
            $app->enqueueMessage(Text::_('RST_CANNOT_CHANGE_SIGNATURE'), 'warning');
			$app->redirect(RSTicketsProHelper::route('index.php?option=com_rsticketspro&view=tickets', false));
		}
		
		if (!$this->get('isAssigned'))
		{
            $app->enqueueMessage(Text::_('RST_CANNOT_CHANGE_SIGNATURE_MUST_BE_STAFF'), 'warning');
            $referer = $app->input->server->get('HTTP_REFERER', '', 'raw');

			if (empty($referer))
			{
				$app->redirect(RSTicketsProHelper::route('index.php?option=com_rsticketspro&view=tickets', false));
			}
			else
			{
				$app->redirect($referer);
			}
		}
	}
}