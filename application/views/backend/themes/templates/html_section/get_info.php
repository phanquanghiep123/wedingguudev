<div id="page-section-info">
	<ul class="nav-list-items list_category ">
		<li ng-click="ChangeSackgroundSection()" class="item" id="section-background">Nền secion <a ng-click="$event.stopPropagation();" href="javascript:;" id="move-action"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a></li>
        <li ng-click="SettingTitle()" class="item" id="setting-title">Cài đặt tiêu đề <a ng-click="$event.stopPropagation();" href="javascript:;" id="move-action"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a></li>
        <li ng-click="SettingLayout()" class="item" id="setting-title">Cài đặt layout <a ng-click="$event.stopPropagation();" href="javascript:;" id="move-action"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a></li>
		 <li>
            <p>Class name</p>
            <input type="text" ng-model="section.class_name" class="form-control">
        </li>
        <li>
            <i class="fa fa-arrows-h" aria-hidden="true"></i> Chiều rộng đầy đủ
            <div class="TriSea-technologies-Switch pull-right">
            	<input id="TriSeaPrimaryis_full" ng-click="changeWidthSection()" ng-checked="section.is_full == 1" name="is_full" type="checkbox"/>
	            <label for="TriSeaPrimaryis_full" class="label-primary"></label>
	        </div>  
        </li>
        <li>
            <i class="fa fa-eye-slash" aria-hidden="true"></i> Hiện tiêu đề
	        <div class="TriSea-technologies-Switch pull-right">
	            <input id="TriSeaPrimaryshow_title" ng-click="changeShowHiddenSection()" ng-checked="section.show_title == 1" name="show_title" type="checkbox"/>
	            <label for="TriSeaPrimaryshow_title" class="label-primary"></label>
	        </div>
        </li>
        <li>
            <p>Layout hiển thị </p>
            <select ng-model ="section.layout_show_block" class="form-control">
                <option value="auto">--chọn một mục--</option>
                <option value="grid">Grids</option>
                <option value="slider">Sliders</option>
            </select>
        </li>
        
        <li>
        	<p>Cho phép hành động</p>
        	<div class="allow-box">
        		<label ng-repeat="action in section.actions"><input ng-model="action.active" id="action-item" ng-true-value="'1'" ng-false-value="'0'" type="checkbox"><span>{{action.name}}</span></label>
        	</div>
        </li>
        <li class="form-group">
        	<p>Block mặt định khi thêm</p>
        	<select ng-model="section.default_block" class="form-control">
        		<option value="0">--chọn một mục--</option>
        		<option ng-repeat="block in SVblocks" value="{{block.id}}">{{block.name}}</option>
        	</select>
        	<div ng-if="section.default_block != 0" class="full-width ncolum_block margin-top-10">
		        <p>Số bài viết trên hàng</p>
				<select ng-model ="section.ncolum_block" class="form-control">
					<option value="0">--chọn một mục--</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="6">6</option>
				</select>
			</div>
			<div ng-if="section.default_block != 0" class="full-width ncolum_show_block margin-top-10">
		        <p>Số bài viết hiển thị</p>
				<select ng-model="section.ncolum_show_block" class="form-control">
		            <option value="0">--select a item--</option>
		            <option value="1">1</option>
		            <option value="2">2</option>
		            <option value="3">3</option>
		            <option value="4">4</option>
		            <option value="5">5</option>
		            <option value="6">6</option>
		            <option value="7">7</option>
		            <option value="8">8</option>
		            <option value="9">9</option>
		            <option value="10">10</option>
		        </select>
			</div>
        </li>	
	</ul>
</div>
<style type="text/css">
    
    #page-section-info .margin-top-10{
    	margin-top: 10px;
    }
    #page-section-info .allow-box label{
    	width: 50%;
    	text-transform: capitalize;
    	font-weight: 600;
    	font-size: 14px;
    }
    #page-section-info .allow-box label span{margin-left: 10px; margin-top: -5px;}
	#page-section-info .setting-bg {
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
	#page-section-info .is_full{
		width: 49%;
		display: inline-block;
	}
	#page-section-info .is_full .btn-group{
		width: 100%;
	}
	#page-section-info .is_full input[type="radio"] {
        display: none;
    }
    #page-section-info .is_full input[type="radio"] + .btn-group > label span:first-child {
        display: none;
    }
    #page-section-info .is_full input[type="radio"] + .btn-group > label span:last-child {
        display: inline-block;   
    }

    #page-section-info .is_full input[type="radio"]:checked + .btn-group > label span:first-child {
        display: inline-block;
    }
    #page-section-info .is_full input[type="radio"]:checked + .btn-group > label span:last-child {
        display: none;   
    }
    #page-section-info .form-group .form-group
    {
        width: 50%;
        margin-bottom: 0;
    }
    #page-section-info .label-left{
        width: 100%;
        border-radius: 0;
    }
    #page-section-info .label-right{
        width: 70%;
    }
    #page-section-info .form-group .form-group .btn-group{
    	width: 100%;
    }
</style>
