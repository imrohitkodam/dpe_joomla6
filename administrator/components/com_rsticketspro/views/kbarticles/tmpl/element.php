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
$listOrder 	= $this->escape($this->state->get('list.ordering'));
$listDirn 	= $this->escape($this->state->get('list.direction')); ?>

<form action="<?php echo Route::_('index.php?option=com_rsticketspro&view=kbarticles&layout=element'); ?>" method="post" name="adminForm" id="adminForm">
	<?php
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
					<th width="20"><?php echo HTMLHelper::_('grid.checkall'); ?></th>
					<th><?php echo HTMLHelper::_('searchtools.sort', 'RST_KB_ARTICLE_NAME', 'a.name', $listDirn, $listOrder); ?></th>
					<th><?php echo HTMLHelper::_('searchtools.sort', 'RST_KB_CATEGORY_NAME', 'c.name', $listDirn, $listOrder); ?></th>
					<th width="1%" class="text-center" align="center"><?php echo HTMLHelper::_('searchtools.sort', 'RST_PRIVATE', 'a.private', $listDirn, $listOrder); ?></th>
					<th width="1%" class="text-center" align="center"><?php echo HTMLHelper::_('searchtools.sort', 'JPUBLISHED', 'a.published', $listDirn, $listOrder); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach ($this->items as $i => $item)
			{
				?>
				<tr>
					<td><?php echo HTMLHelper::_('grid.id', $i, $item->id); ?></td>
					<td><a onclick="window.parent.elSelectEvent('<?php echo $item->id; ?>', this.innerText);" href="javascript: void(0);"><?php echo $item->name != '' ? $this->escape($item->name) : Text::_('RST_NO_TITLE'); ?></a></td>
					<td>
						<?php
						if ($item->category_id)
						{
							echo $item->category_name;
						}
						else
						{
							echo Text::_('RST_KB_NO_PARENT');
						}
						?>
					</td>
					<td class="text-center" align="center"><?php echo $item->private ? Text::_('JYES') : Text::_('JNO'); ?></td>
					<td class="text-center" align="center"><?php echo HTMLHelper::_('jgrid.published', $item->published, $i, 'kbarticles.'); ?></td>
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
	
	<?php echo HTMLHelper::_( 'form.token' ); ?>
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="tmpl" value="component" />
</form>