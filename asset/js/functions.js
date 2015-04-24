/* ****************** Contact Form Function (dyconsol) ********************** */

function contactUs()
{
	var Regex 				= /^[A-Za-z0-9]+([_\.-][A-Za-z0-9]+)*@[A-Za-z0-9]+([_\.-][A-Za-z0-9]+)*\.([A-Za-z]){2,4}$/i;
	var name 				= $('#name').val();
	var email 				= $('#email').val();
	var number 				= $('#phone_number').val();
	var desc 				= $('#desc').val();
	var country 			= $('#country').val();
	var security_question 	= $('#security_question').val();
	var check 				= Regex.test(email);
	

	if(name == "")
	{
		$('#name').parent().addClass('has-error');
	}
	else if(email == "" )
	{
		$('#email').parent().addClass('has-error');	
	}
	else if(check == "false" )
	{
		$('#email').parent().addClass('has-error');	
	}
	else if(number == "")
	{
		$('#number').parent().addClass('has-error');
	}
	else if(desc == "")
	{
		$('#desc').parent().addClass('has-error');
	}
	else if(country == "0")
	{
		$('#country').parent().addClass('has-error');
	}
	else if(security_question == "")
	{
		$('#security_question').parent().addClass('has-error');
	}
	else if(security_question == '3')
	{
		$.ajax({
			  method: "POST",
			  url: "api/contactquery",
			  data: { 'name': name, 'email': email, 'number': number, 'desc': desc, 'country': country }
			success: function(response) {
				if(response.status == 'success')
				{
						$('#message').text('Your query is successfullt submitted.').fadeIn('slow').delay(4000).fadeOut('slow').css('color', '#666666');
				}
				else
						$('#message').text('Sorry! Something went wrong.').fadeIn('slow').delay(4000).fadeOut('slow').css('color', '#666666');
						
				}
			  }
		});
	}

	
}