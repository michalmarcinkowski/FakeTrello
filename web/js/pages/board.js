 $( "body>div.container>#section0>div.boards" ).sortable().disableSelection();


$('.board-add-event').click(function(){
	$(this).find('.pop-up').addClass('active');
});
$('#popup-close-event,a.btn.btn-danger.btn-lg').click(function(){
	$(this).closest('.board').find('.pop-up').removeClass('active');
	return false;
});
$('div.boards').on('click','.board-delete-event',function(){
	deleteBoard($(this).closest('a.board').attr('id').substr(2));
	return false;
});

$('.new-board-event').click(function(){
	$section = $(this).parents('.boards-section');
	addBoard($section.find('input.app_board_name').val(), $section.attr('id').replace(/\D/g,''));
});


$('div.boards').on('click','span.icon-cog,span.icon-share-alt',function(){
	window.location = $(this).attr('data-href');
	return false;
});

$('div.boards').on('click','span.star, span.icon-cog',function(){
	if($(this).hasClass('icon-star'))
		unstarBoard($(this).closest('a.board').attr('id').substr(2));
	else
		starBoard($(this).closest('a.board').attr('id').substr(2));
	return false;
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

function addBoard($name,$organization_id){
	$ajax['data'] = {name:$name};
	if($organization_id>0) $ajax['data']['organization'] = $organization_id;
	$ajax['type'] = 'POST';
	$ajax['url'] = 'boards/new/json';
	$ajax['success'] = function(data){
		$('#section'+$organization_id+'>.boards').append('<a class="board" id="id'+data.id+'" href="boards/'+data.id+'"><h2 style="float: left;">'+data.name+'<span class="icon-star-empty star icon" data-href="boards/'+data.id+'/star"></span><span class="icon-cog icon" data-href="boards/'+data.id+'/edit"></span><span class="icon-trash board-delete-event icon"></span><span class="line"></span></h2></a>');
		//$('#app_board_name').val('');
	};

	$.ajax($ajax);
}

function starBoard($id){
	$ajax['dataType'] = 'html';
	$ajax['type'] = 'GET';
	$ajax['url'] = 'boards/'+$id+'/star';
	$ajax['success'] = function(data){
		$('a#id'+$id+' span.star').removeClass('icon-star-empty').addClass('icon-star');
	};

	$.ajax($ajax);
}

function unstarBoard($id){
	$ajax['dataType'] = 'html';
	$ajax['type'] = 'GET';
	$ajax['url'] = 'boards/'+$id+'/unstar';
	$ajax['success'] = function(data){
			$('a#id'+$id+' span.star').removeClass('icon-star').addClass('icon-star-empty');
	};

	$.ajax($ajax);
}
