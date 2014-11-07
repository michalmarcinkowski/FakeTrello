$('#boardlist-add-event').click(function(){
	$(this).find('.pop-up').addClass('active');
});
$('#popup-close-event,a.btn.btn-danger.btn-lg').click(function(){
	$(this).closest('.board-list').find('.pop-up').removeClass('active');
	return false;
});

$ajax = {type: "POST",dataType: "json",cache: false};

// BOARD-LIST DELETE
$('.delete-list-event').click(function(){
	deleteBoard($(this).closest('a.list').attr('id').substr(2));
	return false;
});
function deleteBoard($id){	
	$ajax['data'] = {id:$id};
	$ajax['type'] = 'DELETE';
	$ajax['url'] = 'delete/json';
	$ajax['success'] = function(data){
		$('a#id'+$id).hide('slow');
	};
	$ajax['error'] = function(xhr){
		$txt = $.parseJSON(xhr.responseText);
		$('body>div.container>div.alert:first-child').hide('slow').remove();
		$('body>div.container').prepend('<div class="alert alert-error" style="display:none">'+$txt[0].message+'</div>');
		$('body>div.container>div.alert:first-child').show('slow');
	};
	
	$.ajax($ajax);
	
}