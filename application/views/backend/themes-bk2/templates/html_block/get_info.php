<div class="block-part">
    <div class="row">
        <div class="col-md-12">
            <div class="box-slider box-full">
                <div class="row">
                    <div class="col-md-3">
                        <p class="lable">Số hàng:</p>
                    </div>
                    <div class="col-md-9">
                        <input id="sliderbootstrap-block" sliderbootstrap data-unit="" ng-model="block.ncolum" data-sliderbootstrap-value="{{block.ncolum}}" data-value="{{block.ncolum}}" value="{{block.ncolum}}" type="text" data-sliderbootstrap-min="1" data-sliderbootstrap-max="12" data-sliderbootstrap-step="1">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box-action box-full">
                <p class="lable">Hành động: 
                  <label ng-repeat="action in block.actions"><input id="action-item" ng-true-value="'1'" ng-false-value="'0'" ng-model="action.active" type="checkbox">{{action.name}}</label>
                </p>
            </div>
        </div>
    </div>
    <div class="box-part box-full">
        <div class="form-group">
            <div class="input-group input-group-sm">
                <label class="input-group-addon" for="class-name">Class name</label>
                <input type="text" ng-model="block.class_name" class="form-control" id="class-name" value="" placeholder="Enter class name">
            </div>
        </div>
    </div>
    <div id="part-item" ng-repeat="part in block.parts" ng-class="part.name" ng-attr-data-index="{{$index}}" data-index>
        <div class="box-part box-full">
          <div class="meta-edit-box">
            <div ng-if="part.metas.length == 0" class="info-item">
              <div class="content-meta" compile="FormEditNull()"></div>
            </div>
            <div ng-if="$index == 0" ng-repeat="meta in part.metas" class="info-item">
                <div class="content-meta" compile="FormEdit(meta)"></div>
            </div>
            <ul class="sortablemeta" ng-class="IsList(part) ? 'ul-is-list' : ''" ng-if="part.metas[0].meta_key =='value_media' && part.metas.length > 0">
                <li ng-repeat="meta in part.metas" class="info-item" ramkey="{{meta.ramkey}}">
                  <div ng-class="part.metas.length > 1 ? 'is_list' : ''" class="data-show-value">
                    <div compile="ValueForm(meta)" class="item"></div>
                  </div>
                </li>
            </ul>
          </div>
        </div>
    </div>
</div>