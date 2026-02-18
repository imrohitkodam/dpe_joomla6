<?php
/**
 * @package    RSTickets! Pro
 *
 * @copyright  (c) 2010 - 2016 RSJoomla!
 * @link       https://www.rsjoomla.com
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl-3.0.en.html
 */

defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;


\Joomla\CMS\Form\FormHelper::loadFieldClass('list');

class JFormFieldRSCheckboxes extends \Joomla\CMS\Form\Field\ListField
{
	protected $type = 'RSCheckboxes';

	public function __construct($form = null) {
		parent::__construct($form);

		static $init;
		if (!$init) {
			HTMLHelper::_('formbehavior.chosen', 'select');
			$init = true;
		}
	}
}
