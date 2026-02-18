<?php
/**
 * @package    RSTickets! Pro
 *
 * @copyright  (c) 2010 - 2016 RSJoomla!
 * @link       https://www.rsjoomla.com
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl-3.0.en.html
 */

defined('JPATH_PLATFORM') or die;

\Joomla\CMS\Form\FormHelper::loadFieldClass('color');

class JFormFieldColors extends \Joomla\CMS\Form\FormFieldColor 
{
	/**
	* Element name
	*
	* @access       protected
	* @var          string
	*/
	protected $type = 'Colors';

	protected function getInput() {
		return parent::getInput();
	}
}