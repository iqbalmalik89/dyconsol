<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Atom-Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include('inc/js.php') ;?>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

<script>
$( document ).ready(function() {
  getDeals('activated');
  getDeals('pending');
  getDeals('deactivated');
  getDeals('expired');

    var checkout = $('#start_date').datepicker({
            format: 'yyyy-mm-dd'
        }).on('changeDate', function(ev) {
          checkout.hide();
        }).data('datepicker');;

    var checkout2 = $('#end_date').datepicker({
            format: 'yyyy-mm-dd'
        }).on('changeDate', function(ev) {
          checkout2.hide();
        }).data('datepicker');;

    $("#deals_images").fileinput({
        uploadUrl: 'index.php', // you must set a valid URL here else you will get an error
        allowedFileExtensions : ['jpg', 'png','gif'],
        overwriteInitial: false,
        maxFileSize: 1000,
        maxFilesNum: 10,
        //allowedFileTypes: ['image', 'video', 'flash'],
        slugCallback: function(filename) {
            return filename.replace('(', '_').replace(']', '_');
        }
  });
});
</script>
</head>
<body>
<!--layout-container start-->
<div id="layout-container"> 
  <!--Left navbar start-->
  
<?php
  include('inc/left.php');
?>
  <!--main start-->
<!-- Modal -->
<div class="modal fade" id="adddeal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<input type="hidden" id="deal_id" value="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <div class="notification-bar" id="msg" style="display: none;"></div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="mode">Add </span> Deal</h4>
      </div>
      <div class="modal-body">


<div class="container">
  <div class="row clearfix">
    <div class="col-md-10 column">
      <form class="form-horizontal" role="form" onsubmit="return false;">
        <div class="form-group">
           <label for="inputEmail3" class="col-sm-2 control-label">Deal Name</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="deal_name" />
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="container">
  <div class="row clearfix">
    <div class="col-md-10 column">
      <form class="form-horizontal" role="form" onsubmit="return false;">
        <div class="form-group">
           <label for="inputEmail3" class="col-sm-2 control-label">Start Date</label>
          <div class="col-sm-4">
            <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="start_date" />
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="container">
  <div class="row clearfix">
    <div class="col-md-10 column">
      <form class="form-horizontal" role="form" onsubmit="return false;">
        <div class="form-group">
           <label for="inputEmail3" class="col-sm-2 control-label">End Date</label>
          <div class="col-sm-4">
            <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="end_date" />
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="container">
  <div class="row clearfix">
    <div class="col-md-10 column">
      <form class="form-horizontal" role="form" onsubmit="return false;">
        <div class="form-group">
           <label for="inputEmail3" class="col-sm-2 control-label">Description</label>
          <div class="col-sm-4">
          <textarea class="form-control" rows="2" id="desc"></textarea>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

  <div class="row clearfix">
    <div class="col-md-10 column" id="existing_images">

    </div>
  </div>


  <div class="row clearfix">
    <div class="col-md-10 column">
      <form enctype="multipart/form-data">
           <div class="form-group">
                  <input id="deals_images" class="file" type="file" multiple="true" data-upload-url="../slim.php/api/upload_images?path=deals_images">
          </div>

      </form>
    </div>
  </div>




      </div>
      <div class="modal-footer">
                     <div class="alert alert-warning" id="uploadmsg" role="alert" style="display:none;"></div>                     

        <img src="images/spinner.gif" id="spinner" style="position:absolute; right:150px; display:none;">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onclick="addUpdateDeal();" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

  <div id="main">





  <?php
    include('inc/nav.php');
  ?>
    <!--margin-container start-->
    <div class="margin-container">
    <!--scrollable wrapper start-->
      <div class="scrollable wrapper">
      <!--row start-->
        <div class="row">
         <!--col-md-12 start-->
          <div class="col-md-12">
            <div class="page-heading">
              <h1>Deals <span id="deal_count" style="display:none;">(0)</span>  <button type="button" data-toggle="modal" data-target="#adddeal" onclick="showDealAddPopup();" class="btn btn-primary">Add Deal</button>  </h1>


                 <img src="images/spinner.gif" style="position:absolute; left:81%; display:none;" id="search_spinner">       
                 <input type="text" id="search" name="search" value="" placeholder="Search Deal" onkeyup="searchDeal(this.value);" style="float:right; margin-bottom:10px;">


<input type="hidden" value="activated" id="deal_filter">


            </div>

          <div class="notification-bar" id="statusmsg" style="display: none;"></div>

          </div><!--col-md-12 end-->

    <div class="tab-container">
              <ul class="nav nav-tabs">
                <li onclick="$('#deal_filter').val('activated')" class="active"><a data-toggle="tab" href="#activeevent">Active</a></li>
                <li onclick="$('#deal_filter').val('pending')" class=""><a data-toggle="tab" href="#pendingevent">Pending</a></li>                
                <li onclick="$('#deal_filter').val('deactivated')" class=""><a data-toggle="tab" href="#deactiveevent">Deactive</a></li>
                <li onclick="$('#deal_filter').val('expired')" class=""><a data-toggle="tab" href="#expiredevent">Expired</a></li>
              </ul>
              <div class="tab-content">
                <div id="activeevent" class="tab-pane cont active" style="height:100%;">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Deal Name</th>
                    <th>Vendors</th>
                    <th>Start Date <i class="fa fa-sort start_dateall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'start_date', 'deals', 'activated');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'start_date', 'deals', 'activated');" class="fa fa-sort-asc start_dateasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'start_date', 'deals', 'activated');" class="fa fa-sort-desc start_datedesc"></i></th>
                    <th>End Date <i class="fa fa-sort end_dateall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'end_date', 'deals', 'activated');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'end_date', 'deals', 'activated');" class="fa fa-sort-asc end_dateasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'end_date', 'deals', 'activated');" class="fa fa-sort-desc end_datedesc"></i></th>
                    <th>Description</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody id="activateddealbody">

                </tbody>
              </table>
              <div id="activatedpagination" style="text-align:center;"></div>

                </div>
                <div id="pendingevent" class="tab-pane cont" style="height:100%;">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Deal Name</th>
                        <th>Vendors</th>
                        <th>Start Date <i class="fa fa-sort start_dateall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'start_date', 'deals', 'pending');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'start_date', 'deals', 'pending');" class="fa fa-sort-asc start_dateasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'start_date', 'deals', 'pending');" class="fa fa-sort-desc start_datedesc"></i></th>
                        <th>End Date <i class="fa fa-sort end_dateall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'end_date', 'deals', 'pending');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'end_date', 'deals', 'pending');" class="fa fa-sort-asc end_dateasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'end_date', 'deals', 'pending');" class="fa fa-sort-desc end_datedesc"></i></th>
                        <th>Description</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody id="pendingdealbody">

                    </tbody>
                  </table>
                  <div id="pendingpagination" style="text-align:center;"></div>
                </div>
                <div id="deactiveevent" class="tab-pane cont" style="height:100%;">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Deal Name</th>
                        <th>Vendors</th>
                        <th>Start Date <i class="fa fa-sort start_dateall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'start_date', 'deals', 'deactivated');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'start_date', 'deals', 'deactivated');" class="fa fa-sort-asc start_dateasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'start_date', 'deals', 'deactivated');" class="fa fa-sort-desc start_datedesc"></i></th>
                        <th>End Date <i class="fa fa-sort end_dateall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'end_date', 'deals', 'deactivated');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'end_date', 'deals', 'deactivated');" class="fa fa-sort-asc end_dateasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'end_date', 'deals', 'deactivated');" class="fa fa-sort-desc end_datedesc"></i></th>
                        <th>Description</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody id="deactivateddealbody">

                    </tbody>
                  </table>
                  <div id="deactivatedpagination" style="text-align:center;"></div>
                </div>
                <div id="expiredevent" class="tab-pane cont" style="height:100%;">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Deal Name</th>
                        <th>Vendors</th>
                        <th>Start Date <i class="fa fa-sort start_dateall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'start_date', 'deals', 'expired');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'start_date', 'deals', 'expired');" class="fa fa-sort-asc start_dateasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'start_date', 'deals', 'expired');" class="fa fa-sort-desc start_datedesc"></i></th>
                        <th>End Date <i class="fa fa-sort end_dateall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'end_date', 'deals', 'expired');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'end_date', 'deals', 'expired');" class="fa fa-sort-asc end_dateasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'end_date', 'deals', 'expired');" class="fa fa-sort-desc end_datedesc"></i></th>
                        <th>Description</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody id="expireddealbody">

                    </tbody>
                  </table>
                  <div id="expiredpagination" style="text-align:center;"></div>
                </div>                
              </div>
            </div>






        </div><!--row end-->
      </div><!--scrollable wrapper end--> 
    </div><!--margin-container end--> 
  </div><!--main end--> 
</div><!--layout-container end--> 
<script>
</script>

</body>
</html>