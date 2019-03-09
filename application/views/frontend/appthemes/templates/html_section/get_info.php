<div id="page-section-info">
	<ul class="nav-list-items list_category">
		<li ng-click="ChangeSackgroundSection()" class="item" id="section-background"><i class="fa fa-picture-o"></i> Nền thành phần</li>
        <li>
            <i class="fa fa-arrows-h" aria-hidden="true"></i> Chiều rộng đầy đủ
            <div class="TriSea-technologies-Switch pull-right">
	            <input id="TriSeaPrimaryis_full" ng-click="changeWidthSection()" ng-checked="section.is_full == 1" name="is_full" type="checkbox"/>
	            <label for="TriSeaPrimaryis_full" class="label-primary"></label>
	        </div>  
        </li>
        <li ng-click="SettingSectionEffect()">
            <i class="fa fa-snowflake-o"></i> Hiệu ứng pháo hoa
        </li>
        <li>
            <i class="fa fa-eye-slash" aria-hidden="true"></i> Hiện tiêu đề
	        <div class="TriSea-technologies-Switch pull-right">
	            <input id="TriSeaPrimaryshow_title" ng-click="changeShowHiddenSection()"  ng-checked="section.show_title == 1" name="show_title" type="checkbox"/>
	            <label for="TriSeaPrimaryshow_title" class="label-primary"></label>
	        </div>
        </li>
        
        <li ng-if="section.show_title == 1" ng-click="SettingTitle()" class="item">
            <i class="fa fa-font" aria-hidden="true"></i> Cài đặt tiêu đề
        </li>
        <li ng-if="section.default_block != 0" class="form-group">
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