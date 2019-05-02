<section class="page-head banner-page">
  	<div class="page-head-opacity">
      	<div class="page-head-content">
          	<div class="container">
              	<div class="row">
                  	<div class="col-md-12">
                      	<h1 class="title text-center" style="padding-top: 10px;">[{]PAYMENT[}]</h1>
                  	</div>
              	</div>
          	</div>
      	</div>
  	</div>
</section>
<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                	<div class="col-sm-2 col-md-3"></div>
                	<div class="col-sm-8 col-md-6">
                		<form action="" method="post">
	                		<div class="panel panel-default">
	                            <div class="panel-heading"><h4 class="mb-0"><?php echo @$package['name'].' '.number_format(@$package['price'],0,",","."); ?>VND</h4></div>
                                <div class="panel-body">
		                			<?php 
		                                if($this->session->flashdata('message')){
		                                    echo  $this->session->flashdata('message');
		                                }
		                                if($this->session->flashdata('record')){
		                                    $record = $this->session->flashdata('record');
		                                }
		                            ?>
		                            <div class="row">
		                            	<div class="col-sm-12">	
		                            		<p><strong>[{]PAYMENT_STEP_01[}]:</strong></p>	
				                		    <div class="row form-group">
				                                <label class="col-sm-12">[{]PAYMENT_FULL_NAME[}] <sup>*</sup></label>
				                                <div class="col-sm-12">
				                                    <input class="required form-control" maxlength="255" type="text" name="name" value="<?php echo @$record['name']; ?>" required>  
				                                </div>
				                            </div>
				                            <div class="row form-group">
				                                <label class="col-sm-12">[{]PAYMENT_EMAIL[}] <sup>*</sup></label>
				                                <div class="col-sm-12">
				                                    <input class="required form-control" maxlength="255" type="email" name="email" value="<?php echo @$record['email']; ?>" required>  
				                                </div>
				                            </div>
				                            <div class="row form-group">
				                                <label class="col-sm-12">[{]PAYMENT_PHONE[}] <sup>*</sup></label>
				                                <div class="col-sm-12">
				                                    <input class="required form-control" maxlength="255" type="text" name="phone" value="<?php echo @$record['phone']; ?>" required>  
				                                </div>
				                            </div>
				                            <div class="row form-group">
				                                <label class="col-sm-12">[{]PAYMENT_NOTE[}] </label>
				                                <div class="col-sm-12">
				                                    <textarea class="required form-control" maxlength="500" name="comment" rows="4"><?php echo @$record['comment']; ?></textarea>  
				                                </div>
				                            </div>
		                            	</div>
		                            	<div class="col-sm-12">
		                            		<div class="row form-group">
				                                <!--<label class="col-sm-4 col-md-3 sm-text-right">Phương thức <sup>*</sup></label>-->
				                                <div class="col-sm-12 col-md-12">
				                                    <?php if(@$payment_method != null): ?>
				                                        <?php foreach ($payment_method as $key => $item): ?>
				                                            <div class="form-group">
				                                            	<?php if(@$item['id'] == $method['bank'] && false): ?>
		                                                            <div class="form-group">
		                                                                <label>Chủ Tài Khoản <sup>*</sup></label>
		                                                                <input type="text" maxlength="255" class="form-control" name="name_cart" value="<?php echo @$record['name_cart']; ?>">
		                                                            </div>
		                                                            <div class="form-group">
		                                                                <label>Tên ngân hàng <sup>*</sup></label>
		                                                                <input type="text" maxlength="255" class="form-control" name="name_bank" value="<?php echo @$record['name_bank']; ?>">
		                                                            </div>
		                                                            <div class="form-group">
		                                                                <label>Số Tài Khoản <sup>*</sup></label>
		                                                                <input type="text" maxlength="255" class="form-control" name="trading_code" value="<?php echo @$record['trading_code']; ?>">
		                                                            </div>
		                                                            <div class="form-group">
		                                                                <label>Ghi chú</label>
		                                                                <textarea maxlength="500" class="form-control" rows="3" name="trading_comment"><?php echo @$record['trading_comment']; ?></textarea>
		                                                            </div>
				                                                <?php endif; ?>
				                                                <div class="checkbox" style="padding-left: 0;display: none;">
				                                                    <input id="method-<?php echo $key; ?>" <?php echo @$record['method'] == @$item['id'] ? 'checked' : ''; ?> checked type="radio" name="method" value="<?php echo @$item['id']; ?>">
				                                                    <label for="method-<?php echo $key; ?>"><?php echo @$item['name']; ?></label>
				                                                </div>
				                                                <?php echo @$item['description']; ?>
				                                            </div>
				                                        <?php endforeach; ?>
				                                    <?php endif; ?>
				                                </div>
				                            </div>
		                            	</div>
		                            </div>
		                            <div class="row">
		                                <div class="col-sm-12 text-right">
		                                    <a class="btn btn-back" href="<?php echo base_url('/pricing'); ?>">← [{]PAYMENT_BACK[}]</a>
		                                    <button class="btn btn-primary" id="payment-success" type="submit" style="cursor: pointer;">[{]PAYMENT_SUBMIT[}]</button>
		                                	<input type="hidden" name="<?php echo @$this->security->get_csrf_token_name(); ?>" value="<?php echo @$this->security->get_csrf_hash(); ?>" />
		                                </div>
		                            </div>
			                    </div>
				            </div>
				        </form>
				    </div>   
               	</div>
			</div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var payment = $('input[type="radio"][name="method"]:checked').val();
        if(payment == '<?php echo $method['bank']; ?>'){
            $('.panel-info').hide();
            $('input[type="radio"][name="method"]:checked').parent().parent().find('.panel-info').show();
        }    
        $('input[type="radio"][name="method"]').click(function(){
            $('.panel-info').hide();
            var current = $(this);
            if(current.is(':checked')){
                current.parent().parent().find('.panel-info').show();
            }
        });
    });
</script>
