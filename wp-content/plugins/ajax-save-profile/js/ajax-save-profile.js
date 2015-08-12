$(document).ready(function(){
    
    $('.profile .item-container').css('visibility', 'visible');

 
	$(':checkbox:not(:checked)').attr('value', 'blank');
	
	$(':checkbox').change(function() {

		    $(this).val($.trim($(this).parent().text()))
		    $(':checkbox:not(:checked)').attr('value', 'blank');
		    
			//async save
                        $bottomleft = $(this).parents('#profile-edit-form').find('.bottom-left');
                        $bottomleft.fadeIn()
                        $bottomleft.empty().append('Saving')		    
			//populate fields
			var opts = populate_ajax_fields();
			var json_data = JSON.stringify(opts, null, 2);
		    
			$.ajax({
				type:'post',
				url:ajax_var.url,
				datatype:'json',
		
				data: {
					'action':'ajax_save',
					'selected':json_data
					},
				success:function(data){
					
					 $bottomleft.empty().append('Saved').delay(2000).queue(function(next){
                                                $bottomleft.fadeOut();
                                                next();
                                            });
					
				}
			
				
				
			})
	
	}); 
	
	$('.ajax-submit').click(function(e){
		
                $button = $(this);
                $button.val('Saving')
		//prevent form submitting
		e.preventDefault();
		
		//populate fields
		var opts = populate_ajax_fields();
		var json_data = JSON.stringify(opts, null, 2);

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
				console.log($button)
                                $button.val('Saved').delay(2000).queue(function(next){
                                    $button.val("Save Changes");
                                    next();
                                });
			}
		
			
			
		})
		
		
		
		
		
	});
	
})


function populate_ajax_fields(){
	var selected=[];

//	$('.standard-form').each(function(){
//		var checkbox= $(this).find('.checkbox')
//		if(checkbox[0] != null){
//		var options = $(this).find('.checkbox input').serializeArray();
//		}
//		else{
//			var options = $(this).find('input[type="text"]').serializeArray();
//		}
//		options.unshift({group:$(this).attr('data-group')})
//		selected.push(options);
//		
//	})
	
	$('.standard-form').each(function(){
		var checkbox= $(this).find('.checkbox')
		if(checkbox[0] != null){
			$(this).find('.checkbox input').each(function(){
				var field_id =$(this).attr('id');
				var val = $(this).val(); 
				var grp = $(this).parents('.editfield').attr('class');
				
				selected.push({id:field_id,value:val, group:grp });
				
			})
		}
		else{
			 $(this).find('input[type="text"]').each(function(){
				 var text= $(this).val();
				 var field_id = $(this).attr('id');
				 var grp = field_id;
				 
					selected.push({id:field_id, value:text, group:grp})

			})
			

		}
		
	})
	
	
	return selected;
	
}