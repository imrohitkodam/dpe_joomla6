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

class RsticketsproViewArticle extends HtmlView
{
	protected $item;
	
	public function display($tpl = null)
	{
		// set the JSON headers
		header('Content-Type: application/json; charset=utf-8');
		
		$this->item	= $this->get('article');

		if (!$this->item->id || !$this->item->published || (!RSTicketsProHelper::isStaff() && $this->item->private))
		{
			throw new Exception(Text::_('RST_CANNOT_VIEW_ARTICLE'));
		}
		
		if (!RSTicketsProHelper::getConfig('allow_rich_editor'))
		{
			$this->item->text = strip_tags($this->item->text);
		}
		
		// display the result
		echo json_encode(array('text' => $this->item->text));
		
		// end application
		Factory::getApplication()->close();
	}
}