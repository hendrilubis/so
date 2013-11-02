<section class="title">
	<!-- We'll use $this->method to switch between faq.create & faq.edit -->
	<h4>Order Settings</h4>
</section>

<section class="item">
	<div class="content">
		<h4>Bank Tujuan Transfer &nbsp; <small><?php echo $settings->bank; ?></small></h4>		
		<h4>No. Rekening &nbsp; <small><?php echo $settings->no_rekening; ?></small></h4>
		<h4>Pemilik Rekening &nbsp; <small><?php echo $settings->owner_rek; ?></small></h4>		
		<h4>No. Telepon Konfirmasi &nbsp; <small><?php echo $settings->telepon_konfirmasi; ?></small></h4>
		<h4>Closing Message</h4>
		<div class="bordered">
			<?php echo $settings->closing_message; ?>
		</div>
    </div>
    <div class="content">
    	<a href="<?php echo site_url('admin/order/settings/edit/1'); ?>" class="button">Edit Settings</a>
    </div>
</section>

<style>
	.bordered {padding: 10px; border-top: 1px solid #ccc; border-left: 1px solid #ccc;}
	blockquote {display: block; width: 100%; }
	blockquote p, blockquote strong {font-family: Courier, Tahoma; font-size: 12px; line-height: 14px;}
	blockquote p {padding: 10px 0 10px 30px; background-color: #eee;}
	p {line-height: 20px;}
</style>