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
  getSubscribers('active');
  getSubscribers('deactive');

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
        <h4 class="modal-title" id="myModalLabel"><span id="mode">Edit </span> Subscriber</h4>
      </div>
      <div class="modal-body">


<div class="container">
  <div class="row clearfix">
    <div class="col-md-10 column">
      <form class="form-horizontal" role="form" onsubmit="return false;">

        <div class="form-group">
           <label for="inputEmail3" class="col-sm-2 control-label">First Name</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="first_name" />
          </div>
        </div>

        <div class="form-group">
           <label for="inputEmail3" class="col-sm-2 control-label">Last Name</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="last_name" />
          </div>
        </div>

        <div class="form-group">
           <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="email" />
          </div>
        </div>
      </form>
    </div>
  </div>
</div>






      </div>
      <div class="modal-footer">
                     <div class="alert alert-warning" id="uploadmsg" role="alert" style="display:none;"></div>                     

        <img src="images/spinner.gif" id="spinner" style="position:absolute; right:150px; display:none;">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onclick="editSubscriber();" class="btn btn-primary">Save</button>
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
              <h1>Subscribers<!--   <button type="button" data-toggle="modal" data-target="#adddeal" onclick="showDealAddPopup();" class="btn btn-primary">Add Deal</button> -->  </h1>

                 <input type="text" id="search" name="search" value="" placeholder="Search Subscriber" onkeyup="searchSubscriber(this.value);" style="float:right; margin-bottom:10px;">

            </div>

          <div class="notification-bar" id="deletemsg" style="display: none;"></div>

          </div><!--col-md-12 end-->


<div class="tab-container">
<input type="hidden" id="cur_subscriber" value="active">
              <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home" onclick="$('#cur_subscriber').val('active');">Active</a></li>
                <li class=""><a data-toggle="tab" href="#profile" onclick="$('#cur_subscriber').val('deactive');">Deactive</a></li>
              </ul>
              <div class="tab-content">
                <div id="home" class="tab-pane cont active" style="height:100%;">
                  <h3>Active Subscribers</h3>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status <i class="fa fa-sort statusall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'status', 'subscriber', 'active');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'status', 'subscriber', 'active');" class="fa fa-sort-asc statusasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'status', 'subscriber', 'active');" class="fa fa-sort-desc statusdesc"></i></th>
                    <th>Date Created <i class="fa fa-sort date_createdall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'date_created', 'subscriber', 'active');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'date_created', 'subscriber', 'active');" class="fa fa-sort-asc date_createdasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'date_created', 'subscriber', 'active');" class="fa fa-sort-desc date_createddesc"></i></th>
                    <th>Verified</th>
                    <th>Consent</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody id="subscriberbodyactive">

                </tbody>
              </table>
              <div id="paginationactive" style="text-align:center;"></div>
                </div>
                <div id="profile" class="tab-pane cont" style="height:100%;">
                  <h3>Deactive Subscribers</h3>

              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status <i class="fa fa-sort statusall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'status', 'subscriber', 'deactive');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'status', 'subscriber', 'deactive');" class="fa fa-sort-asc statusasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'status', 'subscriber', 'deactive');" class="fa fa-sort-desc statusdesc"></i></th>
                    <th>Date Created <i class="fa fa-sort date_createdall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'date_created', 'subscriber', 'deactive');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'date_created', 'subscriber', 'deactive');" class="fa fa-sort-asc date_createdasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'date_created', 'subscriber', 'deactive');" class="fa fa-sort-desc date_createddesc"></i></th>
                    <th>Verified</th>
                    <th>Consent</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody id="subscriberbodydeactive">

                </tbody>
              </table>
              <div id="paginationdeactive" style="text-align:center;"></div>

                </div>

              </div>
            </div>



<!--           <div class="col-sm-6 col-md-12">
            <div class="box-info">


              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status <i class="fa fa-sort statusall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'status', 'subscriber', 'pending');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'status', 'subscriber', 'pending');" class="fa fa-sort-asc statusasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'status', 'subscriber', 'pending');" class="fa fa-sort-desc statusdesc"></i></th>
                    <th>Date Created <i class="fa fa-sort date_createdall" style="float:right;cursor:pointer;" onclick="sortbyFunc('all', 'date_created', 'subscriber', 'pending');"></i> <i style="cursor:pointer;float:right;display:none;"  onclick="sortbyFunc('asc', 'date_created', 'subscriber', 'pending');" class="fa fa-sort-asc date_createdasc"></i>  <i style="cursor:pointer;display:none; float:right;" onclick="sortbyFunc('desc', 'date_created', 'subscriber', 'pending');" class="fa fa-sort-desc date_createddesc"></i></th>
                    <th>Verified</th>
                    <th>Consent</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody id="dealbody">

                </tbody>
              </table>
              <div id="pagination" style="text-align:center;"></div>
            </div>
          </div> -->

        </div><!--row end-->
      </div><!--scrollable wrapper end--> 
    </div><!--margin-container end--> 
  </div><!--main end--> 
</div><!--layout-container end--> 
<script>
</script>

</body>
</html>