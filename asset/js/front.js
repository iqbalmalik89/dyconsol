
/* ****************** Contact Form Function (dyconsol) ********************** */

function showMsg(id, msg)
{
    $(id).html(msg).slideDown('fast').delay(2500).slideUp(1000,function(){}); 
}

function contactUs()
{
	$('div').removeClass('has-error');	
	var Regex 				= /^[A-Za-z0-9]+([_\.-][A-Za-z0-9]+)*@[A-Za-z0-9]+([_\.-][A-Za-z0-9]+)*\.([A-Za-z]){2,4}$/i;
	var name 				= $.trim($('#name').val());
	var email 				= $.trim($('#email').val());
	var number 				= $.trim($('#phone_number').val());
	var desc 				= $.trim($('#desc').val());
	var country 			= $.trim($('#country').val());
	var security_question 	= $.trim($('#security_question').val());
	var check 				= Regex.test(email);
	var validationCheck 	= true;

	if(name == "")
	{
		$('#name').parent().addClass('has-error');
		validationCheck = false;
	}
	
	if(email == "" )
	{
		$('#email').parent().addClass('has-error');	
		validationCheck = false;		
	}
	else if(!Regex.test(email))
	{
		$('#email').parent().addClass('has-error');	
		validationCheck = false;
	}
		
	if(number == "")
	{
		$('#phone_number').parent().addClass('has-error');
		validationCheck = false;
	}
	
	if(desc == "")
	{
		$('#desc').parent().addClass('has-error');
		validationCheck = false;		
	}
	
	if(security_question == "" || security_question  != '3')
	{
		$('#security_question').parent().addClass('has-error');
		validationCheck = false;
	}

	if(validationCheck)
	{
		$.ajax({
			  method: "POST",
			  url: "api/contactquery",
			  data: { 'name': name, 'email': email, 'number': number, 'desc': desc, 'country': country },
			success: function(response) 
			{
				if(response.status == 'success')
				{
					showMsg('#contact-success', 'Contact query submitted successfully');
				}
				else
				{
//						$('#message').text('Sorry! Something went wrong.').fadeIn('slow').delay(4000).fadeOut('slow').css('color', '#666666');					
				}
						

			  }
		});
	}

	
}

/************* Subcribe function ****************/
function subscribe()
{
	$('div').removeClass('has-error');	

	var Regex 				= /^[A-Za-z0-9]+([_\.-][A-Za-z0-9]+)*@[A-Za-z0-9]+([_\.-][A-Za-z0-9]+)*\.([A-Za-z]){2,4}$/i;
	var subscriber_email 	= $.trim($('#subscriber_email').val());
	var check 				= Regex.test(email);
	var validationCheck 	= true;

	if(subscriber_email == "" )
	{
		$('#subscriber_email').parent().addClass('has-error');	
		validationCheck = false;		
	}
	else if(!Regex.test(subscriber_email))
	{
		$('#subscriber_email').parent().addClass('has-error');	
		validationCheck = false;
	}

	if(validationCheck)
	{
		$.ajax({
				  method: "POST",
				  url: "api/subscriber",
				  data: { 'subscriber_email': subscriber_email },
				success: function(response) {
					if(response.status == 'success')
					{
						showMsg('#subscriber-success', 'You subscribed successfully.');
						$('#subscriber_email').val('');
					}
					else
					{
						showMsg('#subscriber-error', 'You are already subscribed.');
					}
				  }
			});
	}

}