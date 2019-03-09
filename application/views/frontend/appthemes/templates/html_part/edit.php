<div class="block-part">
    <div class="row">
      <div class="col-md-12">
        <div class="box-slider box-full">
          <div class="row">
            <div class="col-md-3">
              <p class="lable">Số hàng:</p>
            </div>
            <div class="col-md-9">
               <input id="sliderbootstrap-part" sliderbootstrap data-unit="" ng-model="part.ncolum" data-sliderbootstrap-value="{{part.ncolum}}" ng-attr-data-value ="part.ncolum" data-value="" value="{{part.ncolum}}" type="text" data-sliderbootstrap-min="1" data-sliderbootstrap-max="12" data-sliderbootstrap-step="1">
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="box-action box-full">
            <p class="lable">Hành động: 
              <label ng-repeat="action in part.actions"><input id="action-item" ng-true-value="'1'" ng-false-value="'0'" ng-model="action.active" type="checkbox">{{action.name}}</label>
            </p>
        </div>
      </div>
    </div>
    <div class="box-part box-full">
      <div class="meta-edit-box">
        <div ng-if="part.metas.length == 0" class="info-item">
          <div class="content-meta" compile="FormEditNull()"></div>
        </div>
        <div ng-init="metaInit" ng-repeat="meta in part.metas" class="info-item">
          <div ng-if="$index == 0" class="content-meta" compile="FormEdit(meta)"></div>
          <div ng-if="meta.meta_key == 'value_media'" ng-class="metas.length > 1 ? 'is_list' : ''" class="data-show-value">
            <div compile="ValueForm(meta)" class="item"></div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="input-group input-group-sm">
          <label class="input-group-addon" for="class-name">Class name</label>
          <input type="text" name="class_name" class="form-control" ng-model="part.class_name" value="text" placeholder="Enter class name">
        </div>
      </div>
    </div>
    <div id="box-info-part">
      <input type="hidden" id="valuestring" name="valuestring" value="{{value}}">
    </div>
</div>