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
	addBoard($('#new-board-name').val());
});

$ajax = {type: "POST",dataType: "json",cache: false};

function deleteBoard($id){	
	$ajax['data'] = {id:$id};
	$ajax['url'] = 'some.php';
	
	/*$.ajax($ajax).done(function( msg ) {
		alert( "Data Saved: " + msg );
	});*/
	
	msg = 'Test message';
	//on success:
	$('a#id'+$id).hide('slow');
	$('body>div.container>div.alert:first-child').hide('slow').remove();
	$('body>div.container').prepend('<div class="alert alert-success" style="display:none">'+msg+'</div>');
	$('body>div.container>div.alert:first-child').show('slow');
	
	//on failure:
	/*$('body>div.container>div.alert:first-child').hide('slow').remove();
	$('body>div.container').prepend('<div class="alert alert-error" style="display:none">'+msg+'</div>');
	$('body>div.container>div.alert:first-child').show('slow');*/
	
}

function addBoard($name){
	$ajax['data'] = {name:$name};
	$ajax['url'] = 'some.php';
	
	/*$.ajax($ajax).done(function( msg ) {
		alert( "Data Saved: " + msg );
	});*/
	
	msg = 'Test message';$id = 5;
	//on success:
	$('body>div.container>div.board.new').before('<a class="board" id="id'+$id+'" href="#"><h2 style="float: left;">'+$name+'</h2><div class="pull-right"><button type="submit" class="btn btn-danger btn-confirm board-delete-event"><i class="glyphicon glyphicon-trash"></i> <span>Delete</span></button></div></a>');
	$('body>div.container>div.alert:first-child').hide('slow').remove();
	$('body>div.container').prepend('<div class="alert alert-success" style="display:none">'+msg+'</div>');
	$('body>div.container>div.alert:first-child').show('slow');
	$('#new-board-name').val('');
	
	//on failure:
	/*$('body>div.container>div.alert:first-child').hide('slow').remove();
	$('body>div.container').prepend('<div class="alert alert-error" style="display:none">'+msg+'</div>');
	$('body>div.container>div.alert:first-child').show('slow');*/
	
}
