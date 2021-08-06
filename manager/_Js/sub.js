$(document).ready(function(){
    var projectInfo = false;
	var userHeight = $('#user-wrap').find('.user-cont').height()
	 $('#project-name').find('#view-btn').on('click',function(){
	   if (projectInfo) {
		   $(this).clearQueue();
		   $('#user-wrap').stop().animate({'height':'0'});	
		   $(this).removeClass('isOver');
		   projectInfo = false;
	   } else {
		   $(this).clearQueue();
		   //$('#user-wrap').stop().animate({'height':userHeight + 30});	
		   $('#user-wrap').stop().animate({'height':132});	
		   $(this).removeClass().addClass('isOver');
		   projectInfo = true;
	   }
	});

	var optionSel = false;
	$('#option-wrap').find('#option-btn').click(function(){
	   if (optionSel) {
		   $(this).clearQueue();
		   $('.option-list').fadeOut();	
		   $(this).removeClass('isOver');
		   optionSel = false;
	   } else {
		   $(this).clearQueue();
		   $('.option-list').fadeIn();	
		   $(this).addClass('isOver');
		   optionSel = true;
	   }
	});


});
