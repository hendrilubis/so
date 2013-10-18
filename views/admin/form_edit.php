

<section class="title">
	<!-- We'll use $this->method to switch between faq.create & faq.edit -->
	<h4><?php echo lang('simple_order:edit'); ?> Product</h4>
</section>

<section class="item">
	<div class="content">
		<table>
        	<thead>
            	<tr class="title">
	            	<th width="150px">Username</th>
	                <th width="150px">Alamat Kirim</th>
	                <th width="150px">Email</th>
	                <th>Status</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                	<td><?php echo $data->created_by_username; ?></td>
                    <td><?php echo $data->alamat_kirim; ?></td> 
                    <td><?php echo $data->created_by_email; ?></td>
                    <td><?php echo $form; ?></td>
                </tr>
            </tbody>
        </table>
        <!-- <?php //dump($orderproduct);?> -->

        <br>
    	
    	<table>
        	<thead>
	            <tr>
	            	<th colspan="5" class="title"><em>Order Items</em></th>
	            </tr>
	            <tr>
	            	<th>Product Code</th>
	                <th>Description</th>
	                <th>Price</th>
	                <th>Qty</th>
	                <th>Total</th>
	            </tr>
        	</thead>

	        <tbody>
	            <?php if(!empty($orderproduct)): foreach($orderproduct as $items):?>
	                <tr>
		                <td><?php echo $items->product_code; ?></td>
		                <td><?php echo $items->description; ?></td>
		                <td><?php echo $items->current_price; ?></td>
		                <td><?php echo $items->qty; ?></td>
		                <td><?php echo $items->sub_total; ?></td>
		            </tr>
				<?php endforeach; endif; ?>	
					<tr>
						<td colspan="4" style="text-align:right"><strong>Total Bayar</strong></td>
	                	<td><strong><?php echo $data->harga;?></strong></td>
	            	</tr>
	        </tbody>
    	</table>
    </div>
</section>