<!-- page content -->
<div class="main-page">
    <div class="x_content">
    	<div class="row">
    		<?php if (isset($collections)): ?>
	        	<?php foreach ($collections as $key => $item) : ?>
					<div class="col-sm-<?php echo @$item["num_column"]; ?>">
						<h2><?php echo $item["title"]; ?></h2>
						<?php 
							$file = realpath(APPPATH . 'views/' . $backend_asset . $item["path_feature"] . ".php");
							if (file_exists($file)) {
								$ci=&get_instance();
								$ci->load->model('Common_model');
								$this->load->view($backend_asset.$item["path_feature"],['collection_child' => $ci->Common_model->get_result($item["table_name"])]); 
							}
						?>
					</div>
		    	<?php endforeach; ?>
		    <?php endif; ?>
		</div>
	</div>
</div>
<!-- /page content -->