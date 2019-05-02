<div id="page-lang">
     <?php 
        $get_result = $this->Common_model->get_result("languages");
     ?>
    <ul class="nav-list-items list_category">
        <li class="item not-after">
            <select id="background-repeat" class="form-control" ng-model="theme.lang">
                <option value="">-- chọn một ngôn ngữ --</option>
                <?php 
                    foreach ($get_result as $key => $value) {
                        echo '<option value="'.$value["id"].'">'.$value["name"].'</option>';
                    }
                ?> 
            </select>
        </li>
    </ul>
</div>
<style type="text/css">
	#page-lang .setting-bg {
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