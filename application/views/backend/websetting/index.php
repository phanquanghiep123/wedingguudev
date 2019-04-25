<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div class="main-page <?php echo @$main_page;?>">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>
			    		<?php echo @$title_page; ?>
			    	</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<?php 
	                    if($this->session->flashdata('message')){
	                        echo $this->session->flashdata('message');
	                    }
	                    if($this->session->flashdata('record') && @$record == null){
                            $record = $this->session->flashdata('record');
                        }
	                ?>
	                <form method="post" action="">
						<!-- tabs left -->
					    <div class="tabbable tabs-left">
					        <ul class="nav nav-tabs">
						        <li class="active"><a href="#header" data-toggle="tab"><i class="fa fa-header" aria-hidden="true"></i> Header</a></li>
						        <li><a href="#footer" data-toggle="tab"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> Footer</a></li>
						        <li><a href="#home" data-toggle="tab"><i class="fa fa-home" aria-hidden="true"></i> Home Page</a></li>
						        <li><a href="#social" data-toggle="tab"><i class="fa fa-paper-plane" aria-hidden="true"></i> Social</a></li>
						        <li><a href="#api" data-toggle="tab"><i class="fa fa-cloud" aria-hidden="true"></i> API</a></li>
								<li><a href="#payment" data-toggle="tab"><i class="fa fa-cloud" aria-hidden="true"></i> Payment API</a></li>
								<li><a href="#phh" data-toggle="tab"><i class="fa fa-gavel" aria-hidden="true"></i> Phí hoa hồng</a></li>
						        <li><a href="#c" data-toggle="tab"><i class="fa fa-cog" aria-hidden="true"></i> Js & Css</a></li>
					        </ul>
					        <div class="tab-content">
						        <div class="tab-pane active" id="header">
							        <div class="panel panel-default">
							        	<div class="panel-heading"><i class="fa fa-header" aria-hidden="true"></i> Header</div>
							        	<div class="panel-body">
							        		<div class="form-group">
					                            <label>Favicon</label>
					                            <div class="featured-image small <?php echo @$record['favicon']!= null ? 'active' : ''; ?>">
					                                <span class="remove-featured-image" onclick="ClearFileCustom(this);" title="Xóa ảnh">
					                                    <i class="fa fa-times" aria-hidden="true"></i>
					                                </span>
					                                <a href="#" onclick="BrowseServerCustom(this);return false;">
					                                    <i class="fa fa-plus" title="Chọn ảnh"></i>
					                                </a>
					                                <img src="<?php echo @$record['favicon']; ?>">
					                                <input name="favicon" value="<?php echo @$record['favicon']; ?>" type="hidden" size="60" class="form-control xImagePath">
					                            </div>
					                        </div>

					                        <div class="form-group">
					                            <label>Logo</label>
					                            <div class="featured-image <?php echo @$record['logo']!= null ? 'active' : ''; ?>">
					                                <span class="remove-featured-image" onclick="ClearFileCustom(this);" title="Xóa ảnh">
					                                    <i class="fa fa-times" aria-hidden="true"></i>
					                                </span>
					                                <a href="#" onclick="BrowseServerCustom(this);return false;">
					                                    <i class="fa fa-plus" title="Chọn ảnh"></i>
					                                </a>
					                                <img src="<?php echo @$record['logo']; ?>">
					                                <input name="logo" value="<?php echo @$record['logo']; ?>" type="hidden" size="60" class="form-control xImagePath">
					                            </div>
					                        </div>

					                        <div class="form-group">
					                        	<label>Tiêu đề website</label>
					                        	<input type="text" name="name" class="form-control" value="<?php echo @$record['name']; ?>">
					                        </div>

					                        <div class="form-group">
					                        	<label>Email Admin</label>
					                        	<input type="email" name="email_admin" class="form-control" value="<?php echo @$record['email_admin']; ?>">
					                        </div>

					                        <div class="form-group">
					                        	<label>Menu</label>
					                        	<select name="menu" class="form-control">
					                        		<option value="">Chọn menu</option>
					                        		<?php if(isset($menu) && $menu != null): ?>
					                        			<?php foreach ($menu as $key => $item): ?>
					                        				<option <?php echo @$item['Group_ID'] == @$record['menu'] ? 'selected' : ''; ?> value="<?php echo @$item['Group_ID']; ?>"><?php echo @$item['Name'] ?></option>
					                        			<?php endforeach; ?>
					                        		<?php endif; ?>
					                        	</select>
					                        </div>

					                        <div class="form-group">
					                        	<label>Số ngày đăng ký miễn phí</label>
					                        	<input type="text" name="num_day" class="form-control" value="<?php echo @$record['num_day']; ?>">
					                        </div>
					                        <div style="height:20px;"></div>
							        	</div>
							        </div> 
						        </div>
						        <div class="tab-pane" id="footer">
							        <div class="panel panel-default">
							        	<div class="panel-heading"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> Footer</div>
							        	<div class="panel-body">
							        		<div class="form-group">
					                            <label>Footer #1</label>
					                            <textarea rows="10" class="form-control" name="footer1"><?php echo @$record['footer1']; ?></textarea>
					                        </div>
					                        <div class="form-group">
					                            <label>Footer #2</label>
					                            <textarea rows="10" class="form-control" name="footer2"><?php echo @$record['footer2']; ?></textarea>
					                        </div>
					                        <div class="form-group">
					                            <label>Footer #3</label>
					                            <textarea rows="10" class="form-control" name="footer3"><?php echo @$record['footer3']; ?></textarea>
					                        </div>
					                        <div class="form-group">
					                            <label>Footer #4</label>
					                            <textarea rows="10" class="form-control" name="footer4"><?php echo @$record['footer4']; ?></textarea>
					                        </div>
							        		<div class="form-group">
					                        	<label>Copyright</label>
					                        	<textarea rows="10" class="form-control" name="copyright"><?php echo @$record['copyright']; ?></textarea>
					                        </div>
					                        <div style="height:20px;"></div>
							        	</div>
							        </div> 
						        </div>
						        <div class="tab-pane" id="social">
							        <div class="panel panel-default">
							        	<div class="panel-heading"><i class="fa fa-paper-plane" aria-hidden="true"></i> Social</div>
							        	<div class="panel-body">
							        		<div class="form-group">
					                        	<label>Facebook</label>
					                        	<input type="text" name="facebook" class="form-control" value="<?php echo @$record['facebook']; ?>">
					                        </div>
					                        <div class="form-group">
					                        	<label>Google</label>
					                        	<input type="text" name="google" class="form-control" value="<?php echo @$record['google']; ?>">
					                        </div>
					                        <div class="form-group">
					                        	<label>Twitter</label>
					                        	<input type="text" name="twitter" class="form-control" value="<?php echo @$record['twitter']; ?>">
					                        </div>
					                        <div class="form-group">
					                        	<label>LinkedIn</label>
					                        	<input type="text" name="linkedin" class="form-control" value="<?php echo @$record['linkedin']; ?>">
					                        </div>
					                        <div class="form-group">
					                        	<label>Instagram</label>
					                        	<input type="text" name="instagram" class="form-control" value="<?php echo @$record['instagram']; ?>">
					                        </div>
					                        <div style="height:20px;"></div>
							        	</div>
							        </div> 
						        </div>
						        <div class="tab-pane" id="api">
							        <div class="panel panel-default">
							        	<div class="panel-heading"><i class="fa fa-cloud" aria-hidden="true"></i> API</div>
							        	<div class="panel-body">
							        		<div class="form-group">
					                        	<label>Facebook App ID</label>
					                        	<input type="text" name="facebook_app_id" class="form-control" value="<?php echo @$record['facebook_app_id']; ?>">
					                        </div>
					                        <div class="form-group">
					                        	<label>Facebook Secret</label>
					                        	<input type="text" name="facebook_secret" class="form-control" value="<?php echo @$record['facebook_secret']; ?>">
					                        </div>
					                        <div class="form-group">
					                        	<label>Google Key</label>
					                        	<input type="text" name="google_key" class="form-control" value="<?php echo @$record['google_key']; ?>">
					                        </div>
					                        <div class="form-group">
					                        	<label>Google Client ID</label>
					                        	<input type="text" name="google_client_id" class="form-control" value="<?php echo @$record['google_client_id']; ?>">
					                        </div>
					                        <div class="form-group">
					                        	<label>Google Secret</label>
					                        	<input type="text" name="google_secret" class="form-control" value="<?php echo @$record['google_secret']; ?>">
					                        </div>
					                        <div class="form-group">
					                        	<label>Yahoo Client ID</label>
					                        	<input type="text" name="yahoo_client_id" class="form-control" value="<?php echo @$record['yahoo_client_id']; ?>">
					                        </div>
					                        <div class="form-group">
					                        	<label>Yahoo Client Secret</label>
					                        	<input type="text" name="yahoo_client_secret" class="form-control" value="<?php echo @$record['yahoo_client_secret']; ?>">
					                        </div>

					                        <div class="form-group">
					                        	<label>Outlook Key</label>
					                        	<input type="text" name="out_key" class="form-control" value="<?php echo @$record['out_key']; ?>">
					                        </div>
					                        <div class="form-group">
					                        	<label>Outlook Secret</label>
					                        	<input type="text" name="out_secret" class="form-control" value="<?php echo @$record['out_secret']; ?>">
					                        </div>
					                        <div style="height:20px;"></div>
							        	</div>
							        </div> 
						        </div>
						        <div class="tab-pane" id="phh">
							        <div class="panel panel-default">
							        	<div class="panel-heading"><i class="fa fa-gavel" aria-hidden="true"></i> Mức phí chia hoa hồng</div>
							        	<div class="panel-body">
							        		<div class="form-group">
					                        	<label>Lần đầu (%)</label>
					                        	<input type="number" name="commission1" class="form-control" value="<?php echo @$record['commission1']; ?>">
					                        </div>
					                        <div class="form-group">
					                        	<label>Các lần khác (%)</label>
					                        	<input type="number" name="commission2" class="form-control" value="<?php echo @$record['commission2']; ?>">
					                        </div>
					                        <div class="form-group">
					                        	<label>Số ngày cộng thêm</label>
					                        	<input type="number" name="plusmember" class="form-control" value="<?php echo @$record['plusmember']; ?>">
					                        </div>
					                        <div style="height:20px;"></div>
							        	</div>
							        </div> 
						        </div>
						        <div class="tab-pane" id="payment">
							        <div class="panel panel-default">
							        	<div class="panel-heading"><i class="fa fa-cloud" aria-hidden="true"></i> Payment API</div>
							        	<div class="panel-body">
							        		<h2>Ngân Lượng</h2><hr/>
							        		<div class="form-group">
					                        	<label>NGANLUONG URL</label>
					                        	<input type="text" name="nganluong_url" class="form-control" value="<?php echo @$record['nganluong_url']; ?>">
					                        </div>
					                        <div class="form-group">
					                        	<label>EMAIL Nhận:</label>
					                        	<input type="text" name="nganluong_receiver" class="form-control" value="<?php echo @$record['nganluong_receiver']; ?>">
					                        </div>
					                        <div class="form-group">
					                        	<label>MERCHANT ID</label>
					                        	<input type="text" name="nganluong_merchant_id" class="form-control" value="<?php echo @$record['nganluong_merchant_id']; ?>">
					                        </div>
					                        <div class="form-group">
					                        	<label>MERCHANT PASSWORD</label>
					                        	<input type="password" name="nganluong_merchant_password" class="form-control" value="<?php echo @$record['nganluong_merchant_password']; ?>">
					                        </div>
					                        <hr/>
					                        <h2>Bảo Kim</h2><hr/>
					                        <div class="form-group">
					                        	<label>BAOKIM SERVER</label>
					                        	<input type="text" name="baokim_server" class="form-control" value="<?php echo @$record['baokim_server']; ?>">
					                        </div>
					                        <div class="form-group">
					                        	<label>BAOKIM BUSINESS:</label>
					                        	<input type="text" name="baokim_business" class="form-control" value="<?php echo @$record['baokim_business']; ?>">
					                        </div>
					                        <div class="form-group">
					                        	<label>MERCHANT ID</label>
					                        	<input type="text" name="baokim_merchant" class="form-control" value="<?php echo @$record['baokim_merchant']; ?>">
					                        </div>
					                        <div class="form-group">
					                        	<label>MERCHANT PASSWORD</label>
					                        	<input type="password" name="baokim_security" class="form-control" value="<?php echo @$record['baokim_security']; ?>">
					                        </div>
					                        <div style="height:20px;"></div>
							        	</div>
							        </div> 
						        </div>
						        <div class="tab-pane" id="c">
							        <div class="panel panel-default">
							        	<div class="panel-heading"><i class="fa fa-cog" aria-hidden="true"></i> js và css</div>
							        	<div class="panel-body">
							        		<div class="form-group">
					                        	<label>Javascript</label>
					                        	<textarea name="javascript" class="form-control" rows="10"><?php echo @$record['javascript']; ?></textarea>
					                        </div>
					                        <div class="form-group">
					                        	<label>Css</label>
					                        	<textarea name="css" class="form-control" rows="10"><?php echo @$record['css']; ?></textarea>
					                        </div>
					                        <div style="height: 20px;"></div>
							        	</div>
							        </div> 
						        </div>
						        <div class="tab-pane" id="home">
							        <div class="panel panel-default">
							        	<div class="panel-heading"><i class="fa fa-home" aria-hidden="true"></i> Home Page</div>
							        	<div class="panel-body">
							        		<div class="section-home-page" id="sortable">
							        			<?php if(@$record['home_list'] != null): ?>
							        				<?php foreach ($record['home_list'] as $key => $item): ?>
							        					<div class="section">
									        				<a href="#" class="remove-section"><i class="fa fa-times" aria-hidden="true"></i></a>
									        				<div class="form-group">
										        				<label>Tiêu đề</label>
										        				<input class="form-control" name="section_title[]" type="text" value="<?php echo @$item['section_title']; ?>"></textarea>
										        			</div>
									        				<div class="form-group">
										        				<label>Nội dung</label>
										        				<textarea class="form-control" name="section_content[]" rows="10"><?php echo @$item['section_content']; ?></textarea>
										        			</div>
									        			</div>
							        				<?php endforeach; ?>
							        			<?php endif; ?>
							        			<div class="section">
							        				<a href="#" class="remove-section"><i class="fa fa-times" aria-hidden="true"></i></a>
							        				<div class="form-group">
								        				<label>Tiêu đề</label>
								        				<input class="form-control" name="section_title[]" type="text"></textarea>
								        			</div>
							        				<div class="form-group">
								        				<label>Nội dung</label>
								        				<textarea class="form-control" name="section_content[]" rows="10"></textarea>
								        			</div>
							        			</div>
							        		</div>
							        		<div class="form-group text-right">
							        			<button type="button" class="btn btn-primary btn-new-section-home">Add new Section</button>
							        		</div>
							        		<div style="height: 20px;"></div>
							        	</div>
							        </div>
							    </div>
					        </div>
					    </div>
					    <!-- /tabs -->
					    <div class="row">
					    	<div class="col-sm-12 text-right">
					    		<?php $this->load->view(@$backend_asset.'/includes/form-submit',array('base_controller' => @$base_controller)); ?>
					    	</div>
					    </div>
				    </form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.btn-new-section-home').click(function(){
			var section = $('.section-home-page .section').first().html();
			$('.section-home-page').append('<div class="section">' + section + '</div>');
			return false;
		});
		$(document).on('click','.section .remove-section',function(){
			$(this).parents('.section').remove();
			return false;
		});

	    $( "#sortable" ).sortable();
	    $( "#sortable" ).disableSelection();
	});
</script>
<style type="text/css">
	.section-home-page .section{position: relative;border-bottom: 2px dotted #ccc;padding-bottom: 20px;margin-bottom: 20px;}
	.section-home-page .section:last-child{border:0;padding: 0;margin: 0;}
	.section-home-page .section:first-child .remove-section,
	.section-home-page .section:last-child .remove-section{display: none;}
	.section-home-page .section .remove-section{position: absolute;right: 0;top: 0;z-index: 100;color: #ff0000;}
</style>