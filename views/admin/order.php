	<?php if (!empty($entries)): ?>

		<table border="0" class="table-list" cellspacing="0">
			<thead>
				<tr>
					<th>No</th>
					<th><?php echo lang('simple_order:name'); ?></th>
					<th><?php echo lang('simple_order:hp'); ?></th>
					<th><?php echo lang('simple_order:email'); ?></th>
					<th><?php echo lang('simple_order:provinsi'); ?></th>
					<th><?php echo lang('simple_order:sekolah'); ?></th>
					<th><?php echo lang('simple_order:total'); ?></th>
					<th><?php echo lang('simple_order:status'); ?></th>
					<th></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="10">
						<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php if(!empty($entries["entries"])): 
				$i=1; 
				foreach( $entries["entries"] as $item ): ?>
				<tr id="item_<?php echo $item["id"]; ?>">
					<td><?php echo $i; ?></td>
					<td><?php echo $item["user_id"]["first_name"].' '.$item["user_id"]["last_name"]; ?></td>
					<td><?php echo $item["phone"]; ?></td>
					<td><?php echo get_user_email($item["user_id"]['id']); ?></td>
					<td><?php echo $item["province"]; ?></td>
					<td><?php echo $item["user_id"]['sekolah']; ?></td>
					<td><?php echo number_format($item["order_total"], 2, ",", "."); ?></td>
					<td><?php echo $item["order_status"]["value"]; ?></td>
					<td class="actions">
						<?php echo anchor('admin/order/edit/'.$item["id"], lang('simple_order:edit'), array('class'=>'button', 'title'=>lang('simple_order:edit'))); ?>
					</td>
				</tr>
				<?php $i++; endforeach; else: ?> <div class="no_data"><?php echo lang('simple_order:no_items'); ?></div> <?php  endif; ?>
			</tbody>
		</table>
	<?php else: ?>
		<div class="no_data"><?php echo lang('simple_order:no_items'); ?></div>
	<?php endif;?>