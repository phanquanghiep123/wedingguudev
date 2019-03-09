<div class="block-part">
    <div id="part-item" ng-repeat="part in block.parts" ng-class="part.name" ng-attr-data-index="{{$index}}" data-index>
        <div class="box-part box-full">
          <div class="meta-edit-box">
            <div ng-if="$index == 0" ng-repeat="meta in part.metas" class="info-item">
            	<div class="content-meta">
                <parts class="row list-parts">
                  <part ng-if="part.metas.length > 0" ng-repeat="part in block.parts" class="col-md-{{part.ncolum}} part-item {{part.class_name}}" ramkey={{part.ramkey}} ng-attr-data-index="{{$index}}" data-index>
                    <metadatas class="{{part.name}}" data-is="{{part.name}}">
                      <metadata ng-attr-data-value="{{(part.metas[0].meta_key != 'value_media') ? part.metas[0].value : part.metas[0].thumb}}" data-value="" class="{{part.metas[0].meta_key}}" compile="MetaShow()" ng-attr-data-index="0" data-index></metadata>
                    </metadatas>
                  </part>
                </parts>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>