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

$canEdit  	= Factory::getUser()->authorise('group.edit', 'com_rsticketspro');
$listOrder 	= $this->escape($this->state->get('list.ordering'));
$listDirn 	= $this->escape($this->state->get('list.direction'));
?>
<form action="<?php echo Route::_('index.php?option=com_rsticketspro&view=groups'); ?>" method="post" name="adminForm" id="adminForm">
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
				<th><?php echo HTMLHelper::_('searchtools.sort', 'RST_GROUP', 'name', $listDirn, $listOrder); ?></th>
				<th width="1%"><?php echo HTMLHelper::_('searchtools.sort', 'ID', 'id', $listDirn, $listOrder); ?></th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach ($this->items as $i => $item)
			{
				?>
					<tr>
						<td width="1%" nowrap="nowrap"><?php echo HTMLHelper::_('grid.id', $i, $item->id); ?></td>
						<td>
							<?php
							if ($canEdit)
							{
								echo HTMLHelper::_('link', Route::_('index.php?option=com_rsticketspro&task=group.edit&id='.(int) $item->id), $this->escape($item->name));
							}
							else
							{
								echo $this->escape($item->name);
							}
							?>
						</td>
						<td width="1%"><?php echo $this->escape($item->id); ?></td>
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