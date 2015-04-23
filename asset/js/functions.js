/* ****************** Contact Form Function (dyconsol) ********************** */

function contactUs()
{

	var name 				= $('#name').val();
	var email 				= $('#email').val();
	var number 				= $('#phone_number').val();
	var desc 				= $('#desc').val();
	var country 			= $('#country').val();
	var security_question 	= $('#security_question').val();

	if(security_question == '3')
	{
		$.ajax({
			  method: "POST",
			  url: "api/contactquery",
			  data: { name: name, email: email, number: number, desc: desc, country: country }
			})
			   .done(function( msg ) {
			     alert( "Data Saved: " + msg );
			  });
	}

	else
	{
		alert('error');
	}
}