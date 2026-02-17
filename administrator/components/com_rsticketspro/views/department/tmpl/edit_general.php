<?php
/**
 * @package    RSTickets! Pro
 *
 * @copyright  (c) 2010 - 2016 RSJoomla!
 * @link       https://www.rsjoomla.com
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl-3.0.en.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Language\Text;

// set description if required
if (isset($this->fieldset->description) && !empty($this->fieldset->description)) { ?>
	<?php echo Text::_($this->fieldset->description); ?>
<?php } ?>
<?php
$legend = $this->item->id ? Text::_('RST_EDIT_DEPARTMENT') : Text::_('RST_ADD_NEW_DEPARTMENT');
$this->field->startFieldset($legend);
foreach ($this->fields as $field) {
	$this->field->showField($field->hidden ? '' : $field->label, $field->input);
}
$this->field->endFieldset();