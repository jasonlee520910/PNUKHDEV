
var subNavi= {
	mnObj : null,Timer:null,subTimer:null,isOver:false,initNum:[],
	
	_init:function(){
		var this_s = this;
		this.mnObj =$("#leftmenu");

		$("li",$(this.mnObj)).each(function(){

			var sLI = $("ul",$(this));

			if(sLI.length>0){
				$(this).addClass("has-sub");
				$(this).addClass("is-close");

				if($(this).hasClass("over")){
					$(this).addClass("is-open");
				}
			}


		});


		this.setEvt();
	},
	_set:function(){},
	_unset:function(){
		this.closeMenu();
	},
	_retset:function(){
		this.setEvt();
	},
	clearEvt:function(){
		$("a",$(this.mnObj)).unbind("mousedown mouseover focus click mouseout blur");
		$("button",$(this.mnObj)).unbind("mousedown mouseover focus click mouseout blur");
	},
	setEvt:function(){
		var this_s = this;
		this.clearEvt();
		
		$("a",$(this.mnObj)).bind("focus", function(){	 
			this_s.isOver = true;	
		});
		

		$(".lm_l2 > a",$(this.mnObj)).bind("click", function(){	

			if($(this).parent().hasClass("has-sub")){	
				var selLI = $(this).parent();
				if($(this).parent().hasClass("is-open")){
					this_s.toggleSubMenu($(this).parent());
					return false;
				
				}else{
					this_s.toggleSubMenu($(this).parent());
				}
				
				$(".lm_l2.has-sub",$(this).parent().parent()).not(selLI).each(function(){
					this_s.closeSubMenu($(this));
				});
				return false;
			}

		});
	
	},
	openSubMenu:function(li){
		var this_s = this;
		li.addClass("is-open");
		$(" > ul",li).slideDown("fast",function(){  this_s.setContentHeight(); });
	},
	closeSubMenu:function(li){
		var this_s = this;
		li.removeClass("is-open");
		$(" > ul",li).slideUp("fast",function(){  this_s.setContentHeight(); });
		
	},
	toggleSubMenu:function(li){
		var this_s = this;
		if(li.hasClass("is-open")){
			this.closeSubMenu(li);
		}else{
			this.openSubMenu(li);
		}
	},
	setContentHeight:function(){
		this.clearTimer();
		this.subTimer = setTimeout(function(){
			try{setLayoutMinHeight();}catch(e){}
		},300);
	},

	clearTimer:function(){
		try{clearTimeout(this.Timer);clearTimeout(this.subTimer);}catch(e){}
	}
}

