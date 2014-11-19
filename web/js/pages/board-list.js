
 $( "body>div.container>div.board-lists" ).sortable();
 
  $( "div.board-lists>a span.card-list" ).sortable({
connectWith: "div.board-lists>a span.card-list",
}).disableSelection();
 
$('#boardlist-add-event').click(function(){
	$(this).find('.pop-up').addClass('active');
});
$('#popup-close-event,a.btn.btn-danger.btn-lg').click(function(){
	$(this).closest('.board-list').find('.pop-up').removeClass('active');
	return false;
});

// BOARD-LIST DELETE
$('.delete-list-event').click(function(){
	deleteBoard($(this).closest('a.list').attr('id').substr(2));
	return false;
});

//BOARD-LIST ADD
$('#new-board-list-event').click(function(){
	addBoard($('#new-board-list-name').val());
});


// CARD ACTIONS
$('span.show-card-add-event').on('click', function(){
	$(this).closest('span.show-card-add-event').addClass('active');
	$(this).closest('span.show-card-add-event').find('input').focus();
});
$buffer = false;
$('span.show-card-add-event input').on('focusout keyup', function(e){
	if(!$buffer){
		$buffer = true;
		if(e.which==13){
			$(this).parent().parent().find('span.card-list').append('<span class="list-element"><span class="list-element-name">'+$(this).val()+'</span></span>');
			$(this).val('');
		}
		if(e.which==13 || e.type=='focusout')
			$(this).parent().removeClass('active');
		$buffer=false;
	}
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
	$ajax['url'] = window.location.pathname+'/board-list/delete/json';
	$ajax['success'] = function(data){
		$('a#id'+$id).hide('slow');
	};
	
	$.ajax($ajax);
	
}

function addBoard($name){
	$ajax['data'] = {name:$name};
	$ajax['url'] = window.location.pathname+'/board-list/new/json';
	$ajax['success'] = function(data){
		$('.container>.board-lists').append('<a class="list" id="id'+data.id+'"><h2 style="float: left;">'+data.name+'<span>+<span><span class="edit-list-event">Edit list</span><span class="delete-list-event">Delete list</span></span></span></h2><span class="card-list"></span><span class="show-card-add-event">Add a card...<input placeholder="The card content"></span></a>');
		$('#app_board_name').val('');
	};
	
	$.ajax($ajax);
}

