<?php
/**
 * @package    RSTickets! Pro
 *
 * @copyright  (c) 2010 - 2016 RSJoomla!
 * @link       https://www.rsjoomla.com
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl-3.0.en.html
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Router\Route;

use Joomla\CMS\HTML\HTMLHelper;

use Joomla\CMS\Language\Text;

use Joomla\CMS\Factory;

$canEdit   = Factory::getUser()->authorise('email.edit', 'com_rsticketspro');
$canChange = Factory::getUser()->authorise('email.edit.state', 'com_rsticketspro');
$listOrder 	= $this->escape($this->state->get('list.ordering'));
$listDirn 	= $this->escape($this->state->get('list.direction'));
?>
<form action="<?php echo Route::_('index.php?option=com_rsticketspro&view=emails'); ?>" method="post" name="adminForm" id="adminForm">
	<?php
	echo RsticketsproAdapterGrid::sidebar();

	echo \Joomla\CMS\Layout\LayoutHelper::render('joomla.searchtools.default', array('view' => $this));

	if (empty($this->items))
	{
		?>
		<div class="alert alert-info">
			<span class="fa fa-info-circle" aria-hidden="true"></span><span class="sr-only"><?php echo Text::_('INFO'); ?></span>
			<?php echo Text::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
		</div>
		<?php
	}
	else
	{
		?>
		<table class="table table-striped">
			<thead>
			<tr>
				<th width="1%" nowrap="nowrap"><?php echo HTMLHelper::_('grid.checkall'); ?></th>
				<th><?php echo HTMLHelper::_('searchtools.sort', 'RST_EMAIL_LANGUAGE', 'lang', $listDirn, $listOrder); ?></th>
				<th><?php echo HTMLHelper::_('searchtools.sort', 'RST_EMAIL_TYPE', 'type', $listDirn, $listOrder); ?></th>
				<th><?php echo HTMLHelper::_('searchtools.sort', 'RST_EMAIL_SUBJECT', 'subject', $listDirn, $listOrder); ?></th>
				<th width="1%" nowrap="nowrap"><?php echo HTMLHelper::_('searchtools.sort', 'JPUBLISHED', 'published', $listDirn, $listOrder); ?></th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach ($this->items as $i => $item)
			{
				?>
				<tr>
					<td width="1%" nowrap="nowrap"><?php echo HTMLHelper::_('grid.id', $i, $item->id); ?></td>
					<td width="1%" nowrap="nowrap"><?php echo $this->escape($item->lang); ?></td>
					<td><?php echo Text::_('RST_'.$item->type); ?></td>
					<td>
						<?php
						$text = strlen($item->subject) ? $this->escape($item->subject) : '<em>' . Text::_('RST_NO_TITLE') . '</em>';
						if ($canEdit)
						{
							echo HTMLHelper::_('link', Route::_('index.php?option=com_rsticketspro&task=email.edit&id='.(int) $item->id), $text);
						}
						else
						{
							echo $text;
						}
						?>
					</td>
					<td width="1%" nowrap="nowrap" align="center"><?php echo HTMLHelper::_('jgrid.published', $item->published, $i, 'emails.', $canChange); ?></td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
		<?php
		echo $this->pagination->getListFooter();

	}
	?>
	
	<div>
		<?php echo HTMLHelper::_( 'form.token' ); ?>
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="task" value="" />
	</div>
	</div>
</form>