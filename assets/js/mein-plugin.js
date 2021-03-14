
jQuery(document).ready(function() {
	let tableValue = jQuery('.stars').html();
	//let top = parseInt($('h1.entry-title').offset().top + $('h1.entry-title').height());
	let labs = "<label>";
	let labe = "</label>";

	jQuery('.stars').delegate('.tabStars', 'click', function() {
		$id = jQuery(this).attr('id');

		jQuery.ajax({
			type: 'get',
			dataType: 'json',
			url: 'https://jsonplaceholder.typicode.com/users/'+$id,
			success: function(data) {

				$text = "<div class='singlestar'>";
				$text += "<span class='close'>close</span>";
				$text += "<table class='users'>";
					$text += "<tr><td>Name: </td><td>"+data.name+"</td>";
					$text += "<td>Username:</td><td>"+data.username+"</td></tr>";
					$text += "<tr><td>Email:</td><td colspan='3'>"+data.email+"</td></tr>";
					$text += "<tr><td>Street:</td><td colspan='3'>"+data.address.street+"</td></tr>";
					$text += "<tr><td>City:</td><td colspan='3'>"+data.address.city+"</td></tr>";
					$text += "<tr><td>Suite:</td><td colspan='3'>"+data.address.suite+"</td></tr>";
					$text += "<tr><td>Phone:</td><td colspan='3'>"+data.phone+"</td></tr>";
					$text += "<tr><td>Website:</td><td colspan='3'>"+data.website+"</td></tr>";
					$text += "<tr><td>Company:</td><td colspan='3'>"+data.company.name+"</td></tr>";
				$text += "</table>";
				$text += "<span class='footers'>&nbsp;</span>";
				$text += "</div>";
				jQuery('.stars').html($text);
				let left = parseInt(jQuery("body").innerWidth()/2-325);
				let topH = parseInt(jQuery('.singlestar').innerHeight()/2);
				let top = parseInt(jQuery("body").innerHeight()/2)-topH;
				jQuery('.dialogs').css({'position':'absolute','top':top+"px",'left':left+"px"});


			}
		});
	});

	jQuery('.stars').delegate('.close', 'click', function(event) {
		jQuery('.stars').html(tableValue);
		jQuery('.dialogs').remove();
	});
});