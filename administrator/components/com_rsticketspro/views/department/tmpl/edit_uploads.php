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
$this->field->startFieldset();
foreach ($this->fields as $field) {
	$this->field->showField($field->hidden ? '' : $field->label, $field->input);
	
	if ($field->fieldname == 'upload_size') {
		$label = '';
		$input = '<div class="rst_text">'.Text::sprintf('RST_UPLOADS_MAX_FILESIZE', $this->php_values['upload_max_filesize']).'<br />'.Text::sprintf('RST_UPLOADS_POST_MAX_SIZE', $this->php_values['post_max_size']).'</div>';
		
		$this->field->showField($label, $input);
	}
	if ($field->fieldname == 'upload_files') {
		$label = '';
		$input = '<div class="rst_text">'.Text::sprintf('RST_UPLOADS_MAX_FILES', $this->php_values['max_file_uploads']).'</div>';
		
		$this->field->showField($label, $input);
	}
}
$this->field->endFieldset();