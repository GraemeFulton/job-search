$(document).ready(function(){

	$('.ajax-submit').click(function(e){
		
		//prevent form submitting
		e.preventDefault();
		
		//populate fields
		var opts = populate_ajax_fields();
		var json_data = JSON.stringify(opts, null, 2);
console.log(json_data)

		//async save
		$.ajax({
			type:'post',
			url:ajax_var.url,
			datatype:'json',

			data: {
				'action':'ajax_save',
				'selected':json_data
				},
			success:function(data){
				
				console.log(data);
				
			}
		
			
			
		})
		
		
		
		
		
	});
	
})


function populate_ajax_fields(){
	var selected=[];

	$('.standard-form').each(function(){
		
		var options = $(this).find('.checkbox input:checked').serializeArray()
		options.push({group:$(this).attr('data-group')})
		selected.push(options);
		
	})
	
	return selected;
	
}