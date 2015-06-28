$(document).ready(function(){
	
	$('.ajax-submit').click(function(e){
		
		//prevent form submitting
		e.preventDefault();
		
		//async save
		
		$.ajax({
			type:'post',
			url:ajax_var.url,
			data: {
				'action':'ajax_save'
				},
			success:function(data){
				
				console.log(data);
				
			}
		
			
			
		})
		
		
		
		
	});
	
})