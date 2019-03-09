<div id="page-font">
    <div class="setting-bg">
        <div class="form-group">
            <p>Phông tiêu đề</p>
            <select ng-options="item.name for item in fonts track by item.id" class="form-control" id="font-family" ng-model="theme.font">
              <option value="" class="">-- chọn một mục --</option>
            </select>
        </div> 
        <div class="form-group">
            <p>Size chữ tiêu đề</p>
            <input id="font_title_size" sliderbootstrap data-unit="px" ng-model="theme.size_title"  data-sliderbootstrap-value="{{theme.size_title}}" data-value="{{theme.size_title}}" value="{{theme.size_title}}" type="text" data-sliderbootstrap-min="12" data-sliderbootstrap-max="150" data-sliderbootstrap-step="1">
        </div>
        <div class="form-group">
            <p>Màu chữ tiêu đề</p>
            <input style="background-color:{{theme.color_title}}" class="colorpicker" colorpicker type="text" ng-model="theme.color_title" value="">
        </div>   
        <div class="form-group"> 
            <label for="background-size">Phông trong folder css:</label>
            <textarea name="description" ng-model="theme.user_fonts" class="form-control" placeholder="Nhập vào những font family có thể dùng"></textarea> 
          </div> 
        </div>
</div>
<style type="text/css">
    #page-font .setting-bg {
        margin-top: 0;
        float: left;
        width: 100%;
        background: #fff;
        padding: 15px 5px 5px 5px;
        background: #fff;
        margin-left: 1px;
        cursor: pointer;
        text-transform: uppercase;
        -webkit-box-shadow: 0px 3px 5px -2px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 3px 5px -2px rgba(0,0,0,0.75);
        box-shadow: 0px 3px 5px -2px rgba(0,0,0,0.75);
    }
    #page-font .sliderbootstrap.sliderbootstrap-horizontal {
        width: 100%;
        height: 20px;
        margin-top: 10px;
    }
    #page-font .evo-cp-wrap .colorPicker {
        width: 100%;
        background: #fff;
        border-radius: 0;
        margin-bottom: -1px;
        display: block;
        position: relative;
        height: auto;
        font-size: 20px;
        padding: 5px;
        color: #ccc;
        border: 1px solid #ccc;
    }
    #page-font .evo-cp-wrap .ui-widget-content {
        width: 100%;
    }
    #page-font .evo-color div {
        width: 20px;
        height: 20px;
    }
</style>