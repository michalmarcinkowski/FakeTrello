 $( "body>div.container>div.boards" ).sortable().disableSelection();


$('#board-add-event').click(function(){
	$(this).find('.pop-up').addClass('active');
});
$('#popup-close-event,a.btn.btn-danger.btn-lg').click(function(){
	$(this).closest('.board').find('.pop-up').removeClass('active');
	return false;
});
$('.board-delete-event').click(function(){
	deleteBoard($(this).closest('a.board').attr('id').substr(2));
	return false;
});

$('#new-board-event').click(function(){
	addBoard($('#app_board_name').val());
});

$ajax = {type: "POST",dataType: "json",cache: false};
$ajax['error'] = function(xhr){
		$txt = $.parseJSON(xhr.responseText);
		$('body>div.container>div.alert:first-child').hide('slow').remove();
		$('body>div.container').prepend('<div class="alert alert-error" style="display:none">'+$txt[0].message+'</div>');
		$('body>div.container>div.alert:first-child').show('slow');
	};

function deleteBoard($id){
	$ajax['data'] = {id:$id};
	$ajax['type'] = 'DELETE';
	$ajax['url'] = 'boards/delete/json';
	$ajax['success'] = function(data){
		$('a#id'+$id).hide('slow');
	};

	$.ajax($ajax);

}

function addBoard($name){
	$ajax['data'] = {name:$name};
	$ajax['url'] = 'boards/new/json';
	$ajax['success'] = function(data){
		$('.container>.boards').append('<a class="board" id="id'+data.id+'" href="/app_dev.php/boards/'+data.id+'"><h2 style="float: left;">'+data.name+'</h2><div class="pull-right"><button type="submit" class="btn btn-danger btn-confirm board-delete-event"><i class="glyphicon glyphicon-trash"></i> <span>Delete</span></button></div></a>');
		$('#app_board_name').val('');
	};

	$.ajax($ajax);
}
