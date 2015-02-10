$(function()
{
	// Variable to store your files
	var files;

$('.delete').click(function() {
        var fileid = $(this).closest('a').attr('id');
        var parent = $(this).closest('tr');
        if(confirm("Are you sure you want to delete this?")) {
        $.ajax({
            type: 'post',
            url: 'delete_attachment.php', // <- replace this with your url here
            data: 'id=' + fileid,
            beforeSend: function() {
                parent.animate({'backgroundColor':'#fb6c6c'},300);
                
            },
            success: function() {
                parent.fadeOut(300,function() {
                    parent.remove();
                });
            }
        });
        }         
    });
       
	// Add events
	$('input[type=file]').on('change', prepareUpload);
	$('form#form_upload').on('submit', uploadFiles);
	var pliki = $('#pliki');
    var modal = $('#basicModal');
	// Grab the files and set them to our variable
	function prepareUpload(event)
	{
		files = event.target.files;
		
		console.log("Pliki: ", files[0].size);
	}

	// Catch the form submit and upload the files
	function uploadFiles(event)
	{
	    
		event.stopPropagation(); // Stop stuff happening
        event.preventDefault(); // Totally stop stuff happening
        $form = $(event.target);
        
        // Serialize the form data
        var formData = $form.serialize();
        
        // START A LOADING SPINNER HERE

        // Create a formdata object and add the files
		var data = new FormData();
		$.each(files, function(key, value)
		{
			data.append(key, value);
			
		});
        
        $.ajax({
            url: 'submit.php?'+formData+'&files',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            success: function(data, textStatus, jqXHR)
            {
            	if(typeof data.error === 'undefined')
            	{
            		// Success so call function to process the form
            		submitForm(event, data);
            		var resultFile = 'uploads/'+files[0].name;
         
            		pliki.append('<a href='+resultFile+' >'+files[0].name+'</a> <br/>');
            		modal.modal('hide');
         }
            	else
            	{
            		// Handle errors here
            		console.log('ERRORS: ' + data.error);
            	}
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
            	// Handle errors here
            	console.log('ERRORS: ' + textStatus);
            	// STOP LOADING SPINNER
            }
        });
       
    }

    function submitForm(event, data)
	{
		// Create a jQuery object from the form
		$form = $(event.target);
		
		// Serialize the form data
		var formData = $form.serialize();
		//console.log('data form : ' + formData);
		// You should sterilise the file names
		$.each(data.files, function(key, value)
		{
			formData = formData + '&filenames[]=' + value;
			
		});
         console.log('data form : ' + formData);   //formData = formData + '&wycena_id=' +;
		$.ajax({
			url: 'submit.php',
            type: 'POST',
            data: formData,
            cache: false,
            dataType: 'json',
            success: function(data, textStatus, jqXHR)
            {
            	if(typeof data.error === 'undefined')
            	{
            		// Success so call function to process the form
            		console.log('SUCCESS: ' + data.success);
            	}
            	else
            	{
            		// Handle errors here
            		console.log('ERRORS: ' + data.error);
            	}
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
            	// Handle errors here
            	console.log('ERRORS: ' + textStatus);
            },
            complete: function()
            {
            	// STOP LOADING SPINNER
            	//return true; 
            }
		});
	}
});