var sortBy = '';
var sortOrder = '';
var server = window.location.hostname;
if(server == 'localhost')
{
  var apiUrl = location.protocol + "//"+server+"/dyconsol/api/";
}
else
  var apiUrl = location.protocol + "//"+server+"/dyconsol/api/";


function showMsg(id, msg, type)
{
    $(id).html(msg).addClass(type).slideDown('fast').delay(2500).slideUp(1000,function(){$(id).removeClass(type)}); 
}

function login()
{
    var email = $.trim($('#email').val());
    var password = $.trim($('#password').val());    
    var check = true;

    if(email == '')
    {
        $('#email').focus();
        $('#email').addClass('error-class');
        check = false;
    }

    if(password == '')
    {
        $('#password').focus();
        $('#password').addClass('error-class');
        check = false;
    }

    if(check)
    {
        $('#spinner').show();
        $.ajax({
          type: 'POST',
          url: apiUrl + 'login',
          dataType : "JSON",
          data: { username: email, password: password },
          beforeSend:function(){

          },
          success:function(data){
            $('#spinner').hide();
            if(data.status == 'success')
            {
                showMsg('#msg', 'Successfully Logged In. Redirecting ...', 'green')
                window.location = 'contact_queries.php';
            }
          },
          error:function(jqxhr){
            $('#spinner').hide();            
            showMsg('#msg', 'Wrong credentials. Try Again', 'red')
          }
        });

    }
}

function logout()
{
    $.ajax({
      type: 'GET',
      url: apiUrl + 'logout',
      dataType : "JSON",
      data: {},
      beforeSend:function(){

      },
      success:function(data){
        window.location = 'login.php';
      },
      error:function(jqxhr){
      }
    });
}


function sortbyFunc(sort, sortbystr, module, status)
{
  sortBy = sortbystr;
  obj = '.'+sortbystr;
  if(sort == 'all')
  {
    sortOrder = 'asc';
    $('.fa-sort').show();
    $('.fa-sort-asc').hide();
    $('.fa-sort-desc').hide();
    $(obj+'all').hide();
    $(obj+'desc').hide();
    $(obj+'asc').show();
  }
  else if(sort == 'asc')
  {
    sortOrder = 'desc';
    $('.fa-sort').show();
    $(obj+'all').hide();
    $(obj+'asc').hide();
    $(obj+'desc').show();
  }
  else if(sort == 'desc')
  {
    sortOrder = 'asc';
    $('.fa-sort').show();
    $(obj+'all').hide();
    $(obj+'desc').hide();
    $(obj+'asc').show();
  }

  if(module == 'vendors')
    getAllVendors(status)
  else if(module == 'events')
    getAllEvents(status)
  else if(module == 'deals')
    getDeals(status, 1);
  else if(module == 'promo')
    getPromoVendors(status , 1);
  else if(module == 'subscriber')
    getSubscribers(status);  
}

function removeElm(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax= arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}

function adminData()
{
  $.ajax({
           type: "GET",
           url: apiUrl + 'admindata',
           dataType : "JSON",
           beforeSend:function(){


           },
           success:function(data){
           $('#spinner').hide();      
             if(data.status == 'success')
             {

                $('#name').val(data.data.name);
                $('#email').val(data.data.username);
             }
           },
           error:function(jqxhr){
             $('#spinner').hide();      
             showMsg('#msg', 'error.', 'red');
           }
         });
}

function updateAdminData()
{
  var name = $('#name').val();
  var email = $('#email').val();

  var check = true;

   if(name == '')
     {
         $('#name').focus();
         $('#name').addClass('error-class');
         check = false;
     }
     else if(email == '')
     {
         $('#email').focus();
         $('#email').addClass('error-class');
         check = false;
     }

     if(check)
     {
        $.ajax({
           type: "POST",
           url: apiUrl + 'editadmindata',
           dataType : "JSON",
           data:{name:name,email:email},
           beforeSend:function(){


           },
           success:function(data){
           $('#spinner').hide();      
             if(data.status == 'success')
             {
                showMsg('#msg', 'Profile updated successfully.', 'green');
                adminData();
             }
           },
           error:function(jqxhr){
             $('#spinner').hide();      
             showMsg('#msg', 'error.', 'red');
           }
         });
     }
}

function confirmPassword()
{
  var password = $('#password').val();
  var confirm_password = $('#confirm_password').val();
  var check = true;

  if(password == '')
     {
         $('#password').focus();
         $('#password').addClass('error-class');
         check = false;
     }
     else if(confirm_password == '')
     {
         $('#confirm_password').focus();
         $('#confirm_password').addClass('error-class');
         check = false;
     }

     if(password == confirm_password)
     {
        check = true;
        $.ajax({
           type: "POST",
           url: apiUrl + 'editadminpassword',
           dataType : "JSON",
           data:{password:password},
           beforeSend:function(){

           },
           success:function(data){
           $('#spinner').hide();      
             if(data.status == 'success')
             {
              showMsg('#msg', 'Password updated successfully.', 'green');
             }
           },
           error:function(jqxhr){
             $('#spinner').hide();      
             showMsg('#msg', 'error.', 'red');
           }
         });
     }
     else
     {
         $('#password').focus();
         $('#password').addClass('error-class');
         $('#confirm_password').focus();
         $('#confirm_password').addClass('error-class');

         check = false;
     }


}

function forgotPassword()
{
    var email = $('#email').val();

    if(email == '')
    {
      $('#email').focus();
      $('#email').addClass('error-class');
      check = false;
    }

    $.ajax({
           type: "GET",
           url: apiUrl + 'forgotpassword',
           dataType : "JSON",
           data:{email:email},
           beforeSend:function(){

           },
           success:function(data){
           $('#spinner').hide();      
             if(data.status == 'success')
             {
              showMsg('#msg', 'Email have been sent.', 'green');
             }
           },
           error:function(jqxhr){
             $('#spinner').hide();      
             showMsg('#msg', 'error.', 'red');
           }
         });

}

function resetPassword()
{
  var password = $('#password').val();
  var confirmPassword = $('#confirmpassword').val();
  var email = $('#email').val();
  var code = $('#code').val();
  var check = true;

  if(password == '')
  {
    $('#password').focus();
    $('#password').addClass('error-class');
    check = false;
  }
  if(confirmPassword == '')
  {
    $('#confirmpassword').focus();
    $('#confirmpassword').addClass('error-class');
    check = false;
  }
  else if(password != confirmPassword)
  {
    $('#password').focus();
    $('#password').addClass('error-class');
    $('#confirmpassword').focus();
    $('#confirmpassword').addClass('error-class');
    check = false;
  }
  else
  {
    $.ajax({
           type: "GET",
           url: apiUrl + 'resetpassword',
           dataType : "JSON",
           data:{email:email,code:code,password:password},
           beforeSend:function(){

           },
           success:function(data){
           $('#spinner').hide();      
             if(data.status == 'success')
             {
              showMsg('#msg', 'Password updated successfully.', 'green');
             }
           },
           error:function(jqxhr){
             $('#spinner').hide();      
             showMsg('#msg', 'error.', 'red');
           }
         });
  }
}


  /**********************************************************************************/
  /****************************** Dyconsol Functions ********************************/
  /**********************************************************************************/


function getContactQueries()
{
  // if(edit)
  //   sync = false;
  // else
  //   sync = true;

    $.ajax({
      type: 'GET',
      url: apiUrl + 'contactquery',
      dataType : "JSON",
      data: {},
      //async:sync,
      beforeSend:function(){

      },
      success:function(data){
        var html = '';
        var options = '';
        if(data.data.length > 0)
        {
            $.each(data.data, function( index, value ) {

                //options += '<option value="'+value.id+'">'+value.name+' </option>';
                html += '<tr>\
                            <td>'+value.name+'</td>\
                            <td>'+value.email+'</td>\
                            <td>'+value.number+'</td>\
                            <td>'+value.desc+'</td>\
                            <td>'+value.country+'</td>\
                            <td><a href="javascript:void(0);" onclick="deleteQuery('+value.id+');">Delete</a></td>\
                         </tr>';

            });            
        }
        else
        {
            html += '<tr>\
                        <td colspan="6" align="center">Contact Queries not found</td>\
                     </tr>';            
        }



        $('#contactquerybody').html(html);
       // $('#cat_id').append(options);

      },
      error:function(jqxhr){
      }
    });
}

function deleteQuery(id)
{
    $.ajax({
      type: 'POST',
      url: apiUrl + 'deletecontactquery',
      dataType : "JSON",
      data: {id:id},
      beforeSend:function(){

      },
      success:function(data){
        getContactQueries();
        showMsg('#msg', 'Contact query deleted successfully.', 'green');
      },
      error:function(jqxhr){
      }
    });
}


function getDSubscribers(page)
{
  // if(edit)
  //   sync = false;
  // else
  //   sync = true;

  curpage = page;
    if(page > 0)
      page -= 1;

    $.ajax({
      type: 'GET',
      url: apiUrl + 'subscriber',
      dataType : "JSON",
      data: {},
      //async:sync,
      beforeSend:function(){

      },
      success:function(data){
        var html = '';
        var options = '';
        if(data.data.length > 0)
        {
            $.each(data.data, function( index, value ) {

                //options += '<option value="'+value.id+'">'+value.name+' </option>';
                html += '<tr>\
                            <td>'+value.subscriber_email+'</td>\
                            <td>'+value.date_created+'</td>\
                            <td><a href="javascript:void(0);" onclick="deleteDSubscriber('+value.id+');">Delete</a></td>\
                         </tr>';

            });            
        }
        else
        {
            html += '<tr>\
                        <td colspan="4" align="center">Subscribers not found</td>\
                     </tr>';            
        }

        $('#subscriberbody').html(html);
       // $('#cat_id').append(options);

       $('#pagination').bootpag({
            total: data.total_pages,          // total pages
            page: page,            // default page
            maxVisible: 5,     // visible pagination
            leaps: true         // next/prev leaps through maxVisible
        }).on("page", function(event, num){

          getDSubscribers(num);
           }); 

      },
      error:function(jqxhr){
      }
    });
}

function deleteDSubscriber(id)
{
    $.ajax({
      type: 'POST',
      url: apiUrl + 'deletesubscriber',
      dataType : "JSON",
      data: {id:id},
      beforeSend:function(){

      },
      success:function(data){

        showMsg('#deletemsg', 'Subscriber deleted successfully.', 'green')

        getDSubscribers(1);
      },
      error:function(jqxhr){
      }
    });
}

function getJobs()
{
  // if(edit)
  //   sync = false;
  // else
  //   sync = true;
    $.ajax({
      type: 'GET',
      url: apiUrl + 'job',
      dataType : "JSON",
      data: {},
      //async:sync,
      beforeSend:function(){

      },
      success:function(data){
        var html = '';
        var options = '';
        if(data.data.length > 0)
        {        

            $.each(data.data, function( index, value ) {
              if(value.status == 0)
                var status = '<i class="fa fa-times-circle"></i> ';
              else
                var status = '<i class="fa fa-check-circle"></i> ';

                //options += '<option value="'+value.id+'">'+value.name+' </option>';
                html += '<tr>\
                            <td>'+ status+value.title+'</td>\
                            <td>'+value.desc+'</td>\
                            <td><a href="javascript:void(0);" data-toggle="modal"  onclick="getSingleJob('+value.id+');" data-target="#addjob">Edit</a> |<a href="javascript:void(0);" onclick="deleteJob('+value.id+');">Delete</a></td>\
                         </tr>';

            });            
        }
        else
        { 
            html += '<tr>\
                        <td colspan="4" align="center">Jobs not found</td>\
                     </tr>';            
        }



        $('#jobsbody').html(html);
       // $('#cat_id').append(options);

      },
      error:function(jqxhr){
      }
    });
}

function deleteJob(id)
{
    $.ajax({
      type: 'POST',
      url: apiUrl + 'deletejob',
      dataType : "JSON",
      data: {id:id},
      beforeSend:function(){

      },
      success:function(data){
        showMsg('#jobmsg', 'Job deleted successfully.', 'green');
        getJobs();
      },
      error:function(jqxhr){
      }
    });
}

function getSingleJob(id)
{
    $('#job_id').val(id);

    jobReset();  
    $.ajax({
      type: 'GET',
      url: apiUrl + 'job',
      dataType : "JSON",
      data: {id:id},
      beforeSend:function(){

      },

      success:function(data){

        $('#job_id').val(data.data[0].id);
        $('#title').val(data.data[0].title);
        $('#status').val(data.data[0].status);

//        $('#desc').val(data.data[0].desc);

  var editor =     $('#desc').data("wysihtml5").editor

editor.setValue(data.data[0].desc, true);

      },
      error:function(jqxhr){
      }
    });

}

function showAddJobPopup()
{
    jobReset();
}

function jobReset()
{
    $('#job_id').val('');
    $('#title').val('');
    var editor =     $('#desc').data("wysihtml5").editor
    editor.setValue('', true);
}

function addUpdateJob()
{
    var id = $('#job_id').val();
    var title = $('#title').val();
    var desc = $('#desc').val();
    var status = $('#status').val();    
    var check  = true;

    if(title == '')
    {
        $('#title').focus();
        $('#title').addClass('error-class');
        check = false;
    }
    if(desc == '')
    {
        $('#desc').focus();
        $('#desc').addClass('error-class');
        check = false;
    }

    if(check)
    {
         if(id == '')
          {          
              $('#spinner').show();      
              $.ajax({
                type: 'POST',
                url: apiUrl + 'job',
                dataType : "JSON",
                data: {title:title, desc:desc, status:status},
                beforeSend:function(){

                },
                success:function(data){
                $('#spinner').hide();   
                $('#addjob').modal('hide');
                  if(data.status == 'success')
                  {
                      showMsg('#jobmsg', 'Job added successfully.', 'green');                    
                      getJobs();
                      $('#addjob').modal('hide');
                  }
                },
                error:function(jqxhr){
                  $('#spinner').hide();      
                  showMsg('#msg', 'Job already exists with this name.', 'red');
                }
              });
            }
            else
            {

                $('#spinner').show();      
              $.ajax({
                type: 'POST',
                url: apiUrl + 'editjob',
                dataType : "JSON",
                data: {id:id, title:title, desc:desc, status:status},
                beforeSend:function(){

                },
                success:function(data){
                $('#addjob').modal('hide');  
                $('#spinner').hide();      
                  if(data.status == 'success')
                  {
                      showMsg('#jobmsg', 'Job updated successfully.', 'green');                    
                      getJobs();                
                      $('#addjob').modal('hide');
                  }
                },
                error:function(jqxhr){
                  $('#spinner').hide();      
                  showMsg('#jobmsg', 'Job already exists with this name.', 'red');
                }
              });
            }
    }
}

function getClients()
{
  // if(edit)
  //   sync = false;
  // else
  //   sync = true;
    $.ajax({
      type: 'GET',
      url: apiUrl + 'client',
      dataType : "JSON",
      data: {},
      //async:sync,
      beforeSend:function(){

      },
      success:function(data){
        var html = '';
        var options = '';
        if(data.data.length > 0)
        {        

            $.each(data.data, function( index, value ) {
              // if(value.status == 0)
              //   var status = '<i class="fa fa-times-circle"></i> ';
              // else
              //   var status = '<i class="fa fa-check-circle"></i> ';

                //options += '<option value="'+value.id+'">'+value.name+' </option>';
                html += '<tr>\
                            <td>'+value.client_name+'</td>\
                            <td>'+value.person_name+'</td>\
                            <td>'+value.testimonial+'</td>\
                            <td>'+value.picture+'</td>\
                            <td>'+value.status+'</td>\
                            <td><a href="javascript:void(0);" data-toggle="modal"  onclick="getSingleClient('+value.id+');" data-target="#addclient">Edit</a> |<a href="javascript:void(0);" onclick="deleteClient('+value.id+');">Delete</a></td>\
                         </tr>';

            });            
        }
        else
        { 
            html += '<tr>\
                        <td colspan="6" align="center">Clients not found</td>\
                     </tr>';            
        }



        $('#clientsbody').html(html);
       // $('#cat_id').append(options);

      },
      error:function(jqxhr){
      }
    });
}


function deleteClient(id)
{
    $.ajax({
      type: 'POST',
      url: apiUrl + 'deleteclient',
      dataType : "JSON",
      data: {id:id},
      beforeSend:function(){

      },
      success:function(data){
        showMsg('#jobmsg', 'Client deleted successfully.', 'green');
        getClients();
      },
      error:function(jqxhr){
      }
    });
}

function getSingleClient(id)
{
    $('#client_id').val(id);

    clientReset();  
    $.ajax({
      type: 'GET',
      url: apiUrl + 'client',
      dataType : "JSON",
      data: {id:id},
      beforeSend:function(){

      },

      success:function(data){
        
        $('#client_id').val(data.data[0].id);
        $('#client_name').val(data.data[0].client_name);
        $('#person_name').val(data.data[0].person_name);
        $('#status').val(data.data[0].status);

      // $('#testimonial').val(data.data[0].testimonial);

  var editor =     $('#testimonial').data("wysihtml5").editor

editor.setValue(data.data[0].testimonial, true);

      },
      error:function(jqxhr){
      }
    });

}

function addUpdateClient()
{
    var id            = $('#client_id').val();
    var client_name   = $('#client_name').val();
    var person_name   = $('#person_name').val();
    var testimonial   = $('#testimonial').val();
    var status        = $('#status').val();    
    var picture       = $('#picture').val();
    var check         = true;

    if(client_name == '')
    {
        $('#client_name').focus();
        $('#client_name').addClass('error-class');
        check = false;
    }
    if(person_name == '')
    {
        $('#person_name').focus();
        $('#person_name').addClass('error-class');
        check = false;
    }
    if(testimonial == '')
    {
        $('#testimonial').focus();
        $('#testimonial').addClass('error-class');
        check = false;
    }
    if(status == '')
    {
        $('#status').focus();
        $('#status').addClass('error-class');
        check = false;
    }

    if(check)
    {
         if(id == '')
          {          
              $('#spinner').show();      
              $.ajax({
                type: 'POST',
                url: apiUrl + 'client',
                dataType : "JSON",
                data: {client_name:client_name, person_name:person_name,testimonial: testimonial,picture:picture, status:status},
                beforeSend:function(){

                },
                success:function(data){
                $('#spinner').hide();   
                $('#addclient').modal('hide');
                  if(data.status == 'success')
                  {
                      showMsg('#jobmsg', 'Client added successfully.', 'green');                    
                      getClients();
                      $('#addclient').modal('hide');
                  }
                },
                error:function(jqxhr){
                  $('#spinner').hide();      
                  showMsg('#msg', 'Client already exists with this name.', 'red');
                }
              });
            }
            else
            {
                $('#spinner').show();      
              $.ajax({
                type: 'POST',
                url: apiUrl + 'editclient',
                dataType : "JSON",
                data: {id:id, client_name:client_name, person_name:person_name,testimonial: testimonial,picture:picture, status:status},
                beforeSend:function(){

                },
                success:function(data){
                $('#addclient').modal('hide');  
                $('#spinner').hide();      
                  if(data.status == 'success')
                  {
                      showMsg('#jobmsg', 'Client updated successfully.', 'green');                    
                      getClients();                
                      $('#addclient').modal('hide');
                  }
                },
                error:function(jqxhr){
                  $('#spinner').hide();      
                  showMsg('#jobmsg', 'Client already exists with this name.', 'red');
                }
              });
            }
    }
}

function showAddClientPopup()
{
    clientReset();
}

function clientReset()
{
    $('#client_id').val('');
    $('#client_name').val('');
    $('#person_name').val('');
    $('#testimonial').val('');
   // $('#client_id').val('');
    //$('#title').val('');
    var editor =     $('#testimonial').data("wysihtml5").editor
    editor.setValue('', true);
}
