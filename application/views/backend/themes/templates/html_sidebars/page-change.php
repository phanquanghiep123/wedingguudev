<div id="page-change">
    <ul class="nav-list-sections list_category">
        <li ng-click="changmode(action)" ng-repeat="action in actionschange" class="form-group">
            {{action.name}}
            <div class="action">
                <span ng-class="(action.active == 1) ? 'fa fa-check-circle-o' :'fa fa-circle-thin'" class=""></span>
            </div>
        </li>
    </ul>
    
</div>
<style type="text/css">
    #page-change .setting-bg {
        margin-top: 0;
        float: left;
        width: 100%;
        background: #fff;
        padding: 15px 5px 5px 5px;
        background: #fff; 
        margin-left: 1px;
        text-transform: uppercase;
        font-weight: bold;
        -webkit-box-shadow: 0px 3px 5px -2px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 3px 5px -2px rgba(0,0,0,0.75);
        box-shadow: 0px 3px 5px -2px rgba(0,0,0,0.75);
    }
    #page-change .form-group input[type="radio"] {
        display: none;
    }
    #page-change .form-group input[type="radio"] + .btn-group > label span:first-child {
        display: none;
    }
    #page-change .form-group input[type="radio"] + .btn-group > label span:last-child {
        display: inline-block;   
    }

    #page-change .form-group input[type="radio"]:checked + .btn-group > label span:first-child {
        display: inline-block;
    }
    #page-change .form-group input[type="radio"]:checked + .btn-group > label span:last-child {
        display: none;   
    }
    #page-change .btn-group, 
    #page-change .btn-group-vertical{
        width: 100%;
    }
    #page-change .label-left{
        width: 15%;
    }
    #page-change .label-right{
        width: 85%;
    }
    
</style>