<div id="page-screen">
    <div class="setting-bg">
        <ul class="nav-list-items list_category">
            <li ng-class="screen.size == currentScreen.size ? 'active' : ''" ng-click="setScreen(screen)" ng-repeat="screen in screens" class="form-group">
                <i class="fa fa fa-tablet"></i> Màn hình {{screen.label}}
            </li>
        </ul>
    </div>
</div>
<style type="text/css">
    #page-screen .setting-bg {
        float: left;
        width: 100%;
        background: #fff;
    }
    #page-screen .sliderbootstrap.sliderbootstrap-horizontal {
        width: 100%;
        height: 20px;
        margin-top: 10px;
    }
    #page-screen .evo-cp-wrap .colorPicker {
        width: 100%;
        background: #fff;
        border-radius: 0;
        margin-bottom: -1px;
        display: block;
        position: relative;
        height: auto;
        screen-size: 20px;
        padding: 5px;
        color: #ccc;
        border: 1px solid #ccc;
    }
    #page-screen .evo-cp-wrap .ui-widget-content {
        width: 100%;
    }
    #page-screen .evo-color div {
        width: 20px;
        height: 20px;
    }
</style>