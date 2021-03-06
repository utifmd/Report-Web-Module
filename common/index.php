<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/1.0.0/angular-material.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://rawgit.com/daniel-nagy/md-data-table/master/dist/md-data-table.css">
    
  </head>

  <body layout="column">
    
    <md-toolbar class="md-whiteframe-1dp">
      <div class="md-toolbar-tools">
        <div class="md-title">Material Design Data Table</div>
      </div>
    </md-toolbar>
    
    <md-content laout="column" flex ng-controller="nutritionController">
      
      <md-card>
        <div layout="row" layout-wrap class="checkboxes">
          <md-checkbox ng-model="options.rowSelection">Row Selection</md-checkbox>
          <md-checkbox ng-model="options.multiSelect">Multiple Selection</md-checkbox>
          <md-checkbox ng-model="options.autoSelect">Auto Selection</md-checkbox>
          <md-checkbox ng-model="options.decapitate">Decapitate</md-checkbox>
          <md-checkbox ng-model="options.largeEditDialog">Lard Edit Dialogs</md-checkbox>
          <md-checkbox ng-model="options.boundaryLinks">Pagination Boundary Links</md-checkbox>
          <md-checkbox ng-model="options.limitSelect" ng-click="toggleLimitOptions()">Pagination Limit Select</md-checkbox>
          <md-checkbox ng-model="options.pageSelect">Pagination Page Select</md-checkbox>
        </div>
      </md-card>
      
      <md-card>
        
        <md-toolbar class="md-table-toolbar md-default" ng-hide="options.rowSelection && selected.length">
          <div class="md-toolbar-tools">
            <span>Nutrition</span>
            <div flex></div>
            <md-button class="md-icon-button" ng-click="loadStuff()">
              <md-icon>refresh</md-icon>
            </md-button>
          </div>
        </md-toolbar>
        
        <md-toolbar class="md-table-toolbar alternate" ng-show="options.rowSelection && selected.length">
          <div class="md-toolbar-tools">
            <span>{{selected.length}} {{selected.length > 1 ? 'items' : 'item'}} selected</span>
          </div>
        </md-toolbar>
        
        <md-table-container>
          <table md-table md-row-select="options.rowSelection" multiple="{{options.multiSelect}}" ng-model="selected" md-progress="promise">
            <thead ng-if="!options.decapitate" md-head md-order="query.order" md-on-reorder="logOrder">
              <tr md-row>
                <th md-column md-order-by="name"><span>Dessert (100g serving)</span></th>
                <th md-column md-order-by="type"><span>Type</span></th>
                <th md-column md-numeric md-order-by="calories.value" md-desc><span>Calories</span></th>
                <th md-column md-numeric md-order-by="fat.value" class="width-override"><span>Fat (g)</span></th>
                <th md-column md-numeric md-order-by="carbs.value"><span>Carbs (g)</span></th>
                <th md-column md-numeric md-order-by="protein.value"><span>Protein (g)</span></th>
                <th md-column md-numeric md-order-by="sodium.value" hide-gt-xs show-gt-md><span>Sodium (mg)</span></th>
                <th md-column md-numeric md-order-by="calcium.value" hide-gt-xs show-gt-lg><span>Calcium (%)</span></th>
                <th md-column md-numeric md-order-by="iron.value" hide-gt-xs show-gt-lg><span>Iron (%)</span></th>
                <th md-column md-order-by="comment">
                  <md-icon>comments</md-icon>
                  <span>Comments</span>
                </th>
              </tr>
            </thead>
            <tbody md-body>
              <tr md-row md-select="dessert" md-on-select="logItem" md-auto-select="options.autoSelect" ng-disabled="dessert.calories.value > 400" ng-repeat="dessert in desserts.data | filter: filter.search | orderBy: query.order | limitTo: query.limit : (query.page -1) * query.limit">
                <td md-cell>{{dessert.name}}</td>
                <td md-cell>
                  <md-select ng-model="dessert.type" placeholder="Other">
                    <md-option ng-value="type" ng-repeat="type in getTypes()">{{type}}</md-option>
                  </md-select>
                </td>
                <td md-cell>{{dessert.calories.value}}</td>
                <td md-cell class="width-override">{{dessert.fat.value | number: 2}}</td>
                <td md-cell>{{dessert.carbs.value}}</td>
                <td md-cell>{{dessert.protein.value | number: 2}}</td>
                <td md-cell hide-gt-xs show-gt-md>{{dessert.sodium.value}}</td>
                <td md-cell hide-gt-xs show-gt-lg>{{dessert.calcium.value}}%</td>
                <td md-cell hide-gt-xs show-gt-lg>{{dessert.iron.value}}%</td>
                <td md-cell ng-click="editComment($event, dessert)" ng-class="{'md-placeholder': !dessert.comment}">
                  {{dessert.comment || 'Add a comment'}}
                </td>
              </tr>
            </tbody>
          </table>
        </md-table-container>

        <md-table-pagination md-limit="query.limit" md-limit-options="limitOptions" md-page="query.page" md-total="{{desserts.count}}" md-page-select="options.pageSelect" md-boundary-links="options.boundaryLinks" md-on-paginate="logPagination"></md-table-pagination>
      </md-card>
    </md-content>
    
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-animate.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-aria.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angular_material/1.0.0/angular-material.min.js"></script>
    <script src="https://rawgit.com/daniel-nagy/md-data-table/master/dist/md-data-table.js"></script>
    
  </body>
</html>