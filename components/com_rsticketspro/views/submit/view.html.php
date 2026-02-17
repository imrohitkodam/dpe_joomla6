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

use Joomla\CMS\Language\Text;

use Joomla\CMS\Factory;

class RsticketsproViewSubmit extends HtmlView
{
	public function display($tpl = null)
	{
		$app = Factory::getApplication();

		if (!$this->canView())
		{
			$app->enqueueMessage(Text::_('RST_CANNOT_SUBMIT_TICKET'), 'warning');
			$app->redirect(RSTicketsProHelper::route('index.php?option=com_users&view=login&return=' . base64_encode((string) Uri::getInstance()), false));
		}

		$this->globalMessage			= Text::_(RSTicketsProHelper::getConfig('global_message'));
		$this->globalMessagePosition	= RSTicketsProHelper::getConfig('global_message_position');
		$this->submitMessage			= Text::_(RSTicketsProHelper::getConfig('submit_message'));
		$this->submitMessagePosition	= RSTicketsProHelper::getConfig('submit_message_position');
		$this->form						= $this->get('Form');
		$this->field       = $this->get('RSFieldset');// DPE Hack
		$this->departments				= $this->get('Departments');
		$this->customFields        		= $this->get('CustomFields');
		$this->user						= Factory::getUser();
		$this->permissions				= $this->get('Permissions');
		$this->isStaff					= RSTicketsProHelper::isStaff();
		$this->canChangeSubmitType		= $this->isStaff && $this->permissions && ($this->permissions->add_ticket_customers || $this->permissions->add_ticket_staff);
		$this->hasCaptcha				= $this->get('HasCaptcha');
		$this->captchaType				= RSTicketsProHelper::getConfig('captcha_enabled');
		$this->hasConsent				= RSTicketsProHelper::getConfig('forms_consent') && (!$this->isStaff || !RSTicketsProHelper::getConfig('forms_consent_staff_skip'));
		$this->showAltEmail				= RSTicketsProHelper::getConfig('show_alternative_email');
		$this->params					= $app->getParams();
		$this->showFormHeadings			= (int) $this->params->get('show_form_headings', 0);

		$this->prepareDocument();

		parent::display($tpl);
	}

	protected function prepareDocument()
	{
		$app   = Factory::getApplication();
		$menus = $app->getMenu();
		$title = null;

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();
		if ($menu)
		{
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		}
		else
		{
			$this->params->def('page_heading', Text::_('RST_ADD_NEW_TICKET'));
		}

		$title = $this->params->get('page_title', '');
		if (empty($title))
		{
			$title = $app->get('sitename');
		}
		elseif ($app->get('sitename_pagetitles', 0) == 1)
		{
			$title = Text::sprintf('JPAGETITLE', $app->get('sitename'), $title);
		}
		elseif ($app->get('sitename_pagetitles', 0) == 2)
		{
			$title = Text::sprintf('JPAGETITLE', $title, $app->get('sitename'));
		}
		$this->document->setTitle($title);

		if ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
	}

	protected function canView()
	{
		$canAddTickets = RSTicketsProHelper::getConfig('rsticketspro_add_tickets');
		$guest         = Factory::getUser()->get('guest');

		if (!$canAddTickets && $guest)
		{
			return false;
		}

		return true;
	}
}