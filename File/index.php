<html lang="en" >
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.12/angular-material.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
  <link rel="stylesheet" href="Style.css">
</head>
<body ng-app="codedrive" ng-cloak ng-controller="codedriveCtrl" layout="column" ng-init="getfiles()">
<!--Header -->
<md-toolbar layout="row" class="md-hue-2">
	<div class="md-toolbar-tools">
        <md-button class="menu" ng-click="toggleSidenav()" hide-gt-sm>
            <md-icon md-font-set="material-icons">menu</md-icon>
        </md-button>
			<h2><span><strong>Code Drive</strong></span></h2>
	</div>	
    <div  hide-sm hide-xs>
        <md-list layout="row" layout-align="end center">
          <md-list-item ng-href="{{item.href}}" ng-repeat="item in navbar">
            {{item.title}}
          </md-list-item>
          </md-list>
    </div> 
    <md-button class="md-icon-button" ng-click="toggleRight('right')" show-sm show-xs hide-md hide-gt-md>
        <md-icon>more_vert</md-icon>
    </md-button>
</md-toolbar>
  
    <!--   Sidenav   -->
<md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="right">
    <md-list>
        <md-list-item ng-href="{{item.href}}" ng-repeat="item in navbar">
        {{item.title}}
        </md-list-item>
        </md-list>
</md-sidenav>
    <!-- Right Side Side Nav -->
    <div layout="row" flex>
    <md-sidenav md-component-id="left"  md-is-locked-open="$mdMedia('gt-sm')" class="md-whiteframe-z2" layout="column">
    	<md-list>
    		<md-list-item layout="row">
    			<md-button>
            <md-icon md-font-set="material-icons">home</md-icon>
    			Home 
    			</md-button>
    		</md-list-item>
  			
  			<md-list-item layout="row">
    			<md-button>
            <md-icon md-font-set="material-icons">accessibility</md-icon>
            Your Tasks
    			</md-button>
    		</md-list-item>
    </md-sidenav>
    <!-- Folder Sub Header -->
		<div flex layout="column">
        <md-list  layout="row" class="md-whiteframe-z2 overflow">
          <md-button class="md-secondary" ng-click="createfolder($event);">
               <md-icon  md-font-set="material-icons">create_new_folder</md-icon>New Folder
          </md-button>
          <md-button class="md-secondary" ng-click="createfile();">
                <md-icon  md-font-set="material-icons">add</md-icon>new file
          </md-button>
          <md-button class="md-secondary" ng-click="fileupload();">
              <md-icon  md-font-set="material-icons">file_upload</md-icon>upload
          </md-button>
           <md-button class="md-secondary" ng-click="SimpleToast('Copied Successfully');">
              <md-icon  md-font-set="material-icons">file_copy</md-icon>copy
          </md-button>
           <md-button class="md-secondary" ng-click="SimpleToast('Cut Successfully');">
              <md-icon  md-font-set="material-icons">content_cut</md-icon>cut
          </md-button>
           <md-button class="md-secondary" ng-click="SimpleToast('Pasted Successfully');">
              <md-icon  md-font-set="material-icons">content_paste</md-icon>paste
          </md-button>
          <md-button class="md-secondary" ng-click="getfiles();">
             <md-icon  md-font-set="material-icons">delete</md-icon>delete
          </md-button>
          </md-list>
          <div class="table-responsive container">
          <div layout="row" layout-padding style="padding:20px;background-color:" > 
                <table class="table table-hover" >
                    <thead >
                            <th>Name</th>
                            <th>Size</th>
                            <th>Type</th>
                            <th>Last Modified Date</th>
                            <th>Permission</th>
                            <th>Download</th>
                    </thead>
                    <tbody ng-repeat="file in files">

                            <td><md-icon ng-show="{{file.type}}==file" md-font-set="material-icons">description</md-icon>
                            <md-icon ng-show="{{file.type}}==dir" md-font-set="material-icons">folder</md-icon>
                            <a ng-href="{{file.path}}" ng-click="fileclicked(file.path)" style="text-decoration:none">{{file.basename}}</a></td>
                            <td>{{file.size}}</td>
                            <td>{{file.extension}}</td>
                            <td>{{file.ltime}}</td>
                            <td>{{file.permission}}</td>
                            <td><a ng-href="{{file.path}}" ng-disabled="{{file.type}}==dir" Download>
                                <md-button class="md-primary md-hue-2"><md-icon ng-show="{{file.type}}==file" md-font-set="material-icons">file_download</md-icon>
                                <md-button</a></td>
                    </tbody>
                </table>
            </div>
          </div>
    </div>
    <!-- Model For Folder Creation -->
    <div style="visibility: hidden">
        <div class="md-dialog-container"  id="createfolder">
             <md-dialog layout-padding="">
             <md-toolbar style="width:500px">
                 <div class="md-toolbar-tools">Create New Folder</div>
             </md-toolbar>
                 <div layout-margin="">
                     <md-input-container  class="md-block" flex-sm-gt>
                        <label>Folder Name</label>
                        <input ng-model="foldername">
                    </md-input-container>
                </div>
                <div layout="row" >
                        <md-button ng-click="dircancel();" style="background-color:red;color:white">Cancel</md-button>
                        <div flex=""></div>
                            <md-button class="md-primary" ng-disabled="foldername.$invalid"  >Create</md-button>
                        </div>
             </md-dialog>
        </div>
  </div>
  <!-- Model For File Creation -->
  <div style="visibility: hidden">
        <div class="md-dialog-container"  id="createfile">
             <md-dialog layout-padding="">
             <md-toolbar style="width:500px">
                 <div class="md-toolbar-tools">Create New File</div>
             </md-toolbar>
                 <div layout-margin="">
                     <md-input-container  class="md-block" flex-sm-gt>
                        <label>File Name</label>
                        <input ng-model="filename">
                    </md-input-container>
                </div>
                <div layout="row" >
                        <md-button ng-click="dircancel();" style="background-color:red;color:white">Cancel</md-button>
                        <div flex=""></div>
                             <md-button class="md-primary" ng-disabled="foldername"  >Create</md-button>
                        </div>
             </md-dialog>
        </div>
  </div>
  <!-- Model For File Upload -->
  <div style="visibility: hidden">
    <div class="md-dialog-container" id="fileupload">
      <md-dialog layout-padding layout-fill="" style="min-height:100px">
        <md-toolbar>
            <div class="md-toolbar-tools">Upload File
            <div flex=""></div>
            <md-button ng-click="dircancel();" style="background-color:red;color:white">Cancel</md-button>
            </div>
        </md-toolbar>
        <div layout="row" layout-align="space-between center">
            <span>Select File Upload Option</span>
            <md-select ng-model="option" placeholder="Select Option" class="md-no-underline" required md-no-asterisk="false">
            <md-option value="draganddrop">Drag And Drop</md-option>
            <md-option value="selectfile">Choose File</md-option>
            </md-select>
        </div>
        <div ng-show="option=='selectfile'" layout="column">
            <label class="md-primary">Please Browse The File</label>
            <input class="ng-hide" nv-file-select="" uploader="uploader" multiple id="input-file-id" multiple type="file" />
            <label for="input-file-id" class="md-button md-raised md-primary">Choose Files</label>
        </div>
      </md-dialog>
    </div>
  </div>
    <!-- Angular Material requires Angular.js Libraries -->
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.6/angular.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.6/angular-animate.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.6/angular-aria.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.6/angular-messages.min.js"></script>
  <!-- Angular Material Library -->
  <script src="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.12/angular-material.min.js"></script>
  <!-- Your application bootstrap  -->
  <!-- <script type="text/javascript" src="angular-file-upload.js"></script> -->

  <script type="text/javascript" src="Main.js"></script>
</body>
</html>