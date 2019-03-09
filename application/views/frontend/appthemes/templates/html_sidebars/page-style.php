<div id="page-style">
	<ul class="nav-list-items list_category">
		<li openfilemanager href="javascript:;" class="ui-button-text" data-exe="folder" data-action="style_url" data-type="folder" data-max="1" id="openFilemanager">Chọn folder</li>
		<li uploads data-type="image" data-max="1" data-action="background-image">Tải file zip lên</li> 
	</ul>
  	<div ng-if="theme.folder != null" class="setting-bg">
	    <div class="item-cuttent-bg">
	      <label>Folder hiện tại</label>
	      <p>{{theme.folder.path}}</p>
	    </div>
	</div>
</div>
<style type="text/css">
	#page-style .setting-bg {
    margin-top: 0;
    float: left;
    width: 100%;
    background: #fff;
    padding: 15px 5px 5px 5px;
    background: #fff;
    margin-left: 1px;
    cursor: pointer;
    text-transform: uppercase;
    font-weight: bold;
    -webkit-box-shadow: 0px 3px 5px -2px rgba(0,0,0,0.75);
    -moz-box-shadow: 0px 3px 5px -2px rgba(0,0,0,0.75);
    box-shadow: 0px 3px 5px -2px rgba(0,0,0,0.75);
}
</style>