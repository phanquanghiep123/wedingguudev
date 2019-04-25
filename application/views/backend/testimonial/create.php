<div class="main-page <?php echo @$main_page;?>">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Add new</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
			    <?php if(@$this->input->get("create") == "success"):?>
				    <div class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
					    <strong>Add new successful!</strong> You can update the data here
					</div>
				<?php endif;?>
				<?php if(@$this->input->get("edit") == "success"):?>
				    <div class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
					    <strong>Update successful!</strong> You can update the data here
					</div>
				<?php endif;?>
				<?php if(@$this->input->get("delete") == "success"):?>
				    <div class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
					    <strong>Delete successful!</strong>
					</div>
				<?php endif;?>
				<?php if(@$post["status"] == "error"):?>
				    <div class="alert alert-danger fade in alert-dismissable">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
					    <strong>Error updates!</strong> Please check the input data
					    <?php echo @$post["error"];?>
					</div>
				<?php endif;?>
				<form class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
					<div class="item form-group"> 
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Name">Name <span class="required">*</span></label>
						<div class="col-md-8 col-sm-8 col-xs-12"> <input value="<?php echo @$this->input->post("Name");?>" id="Name" class="form-control col-md-7 col-xs-12" name="Name" placeholder="Name " required="required" type="text"> </div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Content">Summary <span class="required">*</span></label>
						<div class="col-md-8 col-sm-8 col-xs-12"> 
							<?php echo $this->ckeditor->editor('Summary',@$this->input->post("Summary"));?>
						</div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Content">Content <span class="required">*</span></label>
						<div class="col-md-8 col-sm-8 col-xs-12"> 
							<?php echo $this->ckeditor->editor('Content',@$this->input->post("Content"));?>
						</div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Category_ID">Category</label>
						<div class="col-md-8 col-sm-8 col-xs-12"> 
						    <select id="Category_ID" class="form-control col-md-7 col-xs-12" name="Category_ID">   
						    	<option value="0">---Category---</option>
						    	<?php echo @$listcat;?>
							</select> 
						</div>
					</div>
					<div class="item form-group"> 
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Media">Media</label>
						<div class="col-md-8 col-sm-8 col-xs-12"> 
						    <input id="xImagePath" name="Media" value="<?php echo $this->input->post('Media'); ?>" type="text" size="60" class="form-control" />
	                        <input type="button" value="Browse Server" onclick="BrowseServer( 'xImagePath' );" />
	                        <input type="button" value="Remove File" onclick="ClearFile( 'xImagePath' );" />
						</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-6 col-md-offset-3"><a href="<?php echo backend_url(@$base_controller) . "?post_type=".$post_type;?>" class="btn btn-primary">Back</a><button id="send" type="submit" class="btn btn-success">Add new</button> </div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).on("click",".list-box-icon .fa-hover a",function(){
		var text = $(this).find("i").attr("class");
		$("input[name='Icon']").val(text);
		return false;
	});
</script>
<script type="text/javascript" src="<?php echo skin_url('js/ckfinder/ckfinder_v1.js'); ?>"></script>
<script type="text/javascript">
	function BrowseServer( inputId )
	{
	    var finder = new CKFinder() ;
	    finder.BasePath = '<?php echo skin_url('js/ckfinder/'); ?>';
	    finder.SelectFunction = SetFileField ;
	    finder.SelectFunctionData = inputId ;
	    finder.Popup() ;
	}

	function ClearFile( inputId )
	{
	    document.getElementById( inputId ).value = '' ;
	}

	function SetFileField( fileUrl, data )
	{
	    document.getElementById( data["selectActionData"] ).value = fileUrl ;
	}
</script>