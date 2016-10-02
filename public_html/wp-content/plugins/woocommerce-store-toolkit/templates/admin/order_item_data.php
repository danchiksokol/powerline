<?php if( $order_items ) { ?>
<table style="font-family:monospace; text-align:left; width:100%;">
	<tbody>

	<?php foreach( $order_items as $order_item ) { ?>
		<tr>
			<th><?php echo $order_item->name; ?></th>
			<th><?php echo $order_item->type; ?></th>
		</tr>

		<?php if( $order_item->meta ) { ?>
			<?php foreach( $order_item->meta as $meta_value ) { ?>
		<tr>
			<th style="width:20%;">&raquo; <?php echo $meta_value->meta_key; ?></th>
			<td><?php echo $meta_value->meta_value; ?></td>
		</tr>
			<?php } ?>
		<?php } ?>

	<?php } ?>
	</tbody>
</table>
<?php } ?>