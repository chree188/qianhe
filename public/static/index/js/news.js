$(function(){
	var oFocus=$('#focus'),
		oRight=oFocus.find('.right'),
		oLeft=oFocus.find('.left'),
		aRLi=oRight.find('li'),
		aLLi=oLeft.find('li'),
		index=0,
		timer = null;
	aRLi.click(function(){
		index=$(this).index()
		$(this).addClass('active').siblings().removeClass();
		aLLi.eq(index).addClass('active').siblings().removeClass();
		aLLi.eq(index).stop().animate({'opacity':1},300).siblings().stop().animate({'opacity':0},300);
		stopFoucs();
	})
	oLeft.mouseenter(function(){
		stopFoucs();
	}).mouseleave(function(){		
		startFocus();
	});
	timer = setInterval(function(){
		startFocus();
	},5000);
	function startFocus(){
		index++;
		index = index > aRLi.size()-1 ? 0 :index;

		aLLi.eq(index).addClass('active').siblings().removeClass();
		aLLi.eq(index).stop().animate({'opacity':1},300).siblings().stop().animate({'opacity':0},300);
		aRLi.eq(index).addClass('active').siblings().removeClass();
	}
	function stopFoucs(){
		clearInterval(timer);
	}
})
$(function(){
	var oFocus=$('#focus2'),
		oRight=oFocus.find('.right'),
		oLeft=oFocus.find('.left'),
		aRLi=oRight.find('li'),
		aLLi=oLeft.find('li'),
		index=0,
		timer = null;
	aRLi.click(function(){
		index=$(this).index()
		$(this).addClass('active').siblings().removeClass();
		aLLi.eq(index).addClass('active').siblings().removeClass();
		aLLi.eq(index).stop().animate({'opacity':1},300).siblings().stop().animate({'opacity':0},300);
		stopFoucs();
	})
	oLeft.mouseenter(function(){
		stopFoucs();
	}).mouseleave(function(){		
		startFocus();
	});
	timer = setInterval(function(){
		startFocus();
	},5000);
	function startFocus(){
		index++;
		index = index > aRLi.size()-1 ? 0 :index;

		aLLi.eq(index).addClass('active').siblings().removeClass();
		aLLi.eq(index).stop().animate({'opacity':1},300).siblings().stop().animate({'opacity':0},300);
		aRLi.eq(index).addClass('active').siblings().removeClass();
	}
	function stopFoucs(){
		clearInterval(timer);
	}
})

