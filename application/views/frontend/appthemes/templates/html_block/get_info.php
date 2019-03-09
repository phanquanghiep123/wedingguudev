<div class="block-part">
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