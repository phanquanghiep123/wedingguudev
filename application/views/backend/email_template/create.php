<div class="main-page <?php echo @$main_page;?>">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Create</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<?php if(@$post["status"] == "error"):?>
				    <div class="alert alert-danger fade in alert-dismissable">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
					    <?php echo @$post["error"];?>
					</div>
				<?php endif;?>
				<form class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Key Identify</label>
                        <?php $data = array('name' => 'Key_Identify', 'value' => isset($record)?$record['Key_Identify']:'', 'class'=>'form-control','id' => 'Key_Identify', 'placeholder'=> 'Key Identify');
                        echo form_input($data); ?>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <?php $data = array('name' => 'Title', 'value' => isset($record)?$record['Title']:'', 'class'=>'form-control','id' => 'Title','placeholder'=> 'Title');
                        echo form_input($data); ?>
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <?php echo $this->ckeditor->editor('Content',@$record['Content']);?>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <?php 
                        $options = array(
                            'yes'   => 'Display',
                            'no'  => 'Draft',
                        );
                        echo form_dropdown('Status', $options, @$record['Status'], 'class="form-control" id="Status"'); 
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-right">
                            <?php $data = array('name' => 'Cancel','id' => 'Cancel','value' =>'Close','class' => 'btn btn-close');
                                echo form_button($data, 'Close', 'onClick="document.location.href=\''.backend_url(@$base_controller).'\';"'); ?>
                            <?php $data = array('name' => 'Submit','id' => 'Submit','value' =>'Save','class' => 'btn btn-primary');
                                echo form_submit($data); ?>
                        </div>
                    </div>
				</form>
			</div>
		</div>
	</div>
</div>
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