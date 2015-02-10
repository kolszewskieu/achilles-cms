function setupLabel() {
    if ($('.label_check input').length) {
        $('.label_check').each(function(){ 
            $(this).removeClass('c_on');
        });
        $('.label_check input:checked').each(function(){ 
            $(this).parent('label').addClass('c_on');
        });                
    };
    if ($('.label_radio input').length) {
        $('.label_radio').each(function(){ 
            $(this).removeClass('r_on');
        });
        $('.label_radio input:checked').each(function(){ 
            $(this).parent('label').addClass('r_on');
        });
    };
};

$(window).load(function(){
    $('.slides').each(function(i){
        if($(this).find('li').size() > 1){
            $(this).find('.next, .prev').css({
                    top:$(this).find('> ul').height()/2-10
            });
        }
    });
	$('.slidesFull').each(function(i){
        if($(this).find('li').size() > 1){
            $(this).find('.next, .prev').css({
                    top:$(this).find('> ul').height()/2-10
            });
        }
    });
});

$(function(){
    $('.slides').each(function(i){
        $(this).find('li').not(':eq(0)').hide();
        if($(this).find('li').size() > 1){
            $(this).append('<a href="#" class="prev">poprzednie</a>').append('<a href="#" class="next">następne</a>');
//            $(this).find('.next, .prev').css({
//                    top:$(this).find('> ul').height()/2-10
//            });
            $(this).append('<div class="nav" />');
            for(i=0 ; i<$(this).find('li').size(); i++){
                    $(this).find('.nav').append('<a href="#" class="radio">'+(i+1)+'</a>');
            }
            $(this).find('.nav a:first').addClass('active');
        } 
    }).find('.nav').on('click', 'a', function(e){
        e.preventDefault();
        var num = $(this).prevAll().size();
        var selectedSlide = $(this).parents('.slides').find('li:eq('+num+')');
        selectedSlide.parents('ul').eq(0).css('height', selectedSlide.outerHeight());
        
        if(! selectedSlide.is(':visible')){
            var currentSlide = $(this).parents('.slides').find('li:visible');
            currentSlide.fadeOut(function(){
                selectedSlide.fadeIn();
            });
            
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
        }
    }).end().find('.prev').click(function(e){
            e.preventDefault();
            current = $(this).parents('.slides').find('.nav .active');
            if(current.prev().size()){
                    current.prev().click();
            } else {
                    $(this).parents('.slides').find('.nav a:last').click();
            }
    }).end().find('.next').click(function(e){
            e.preventDefault();
            current = $(this).parents('.slides').find('.nav .active');
            if(current.next().size()){
                    current.next().click();
            } else {
                    $(this).parents('.slides').find('.nav a:first').click();
            }
    });

    $('.slidesFull').each(function(i){
        $(this).find('li').not(':eq(0)').hide();
        if($(this).find('li').size() > 1){
            $(this).append('<a href="#" class="prev">poprzednie</a>').append('<a href="#" class="next">następne</a>');
//            $(this).find('.next, .prev').css({
//                    top:$(this).find('> ul').height()/2-10
//            });
            $(this).append('<div class="nav" />');
            for(i=0 ; i<$(this).find('li').size(); i++){
                    $(this).find('.nav').append('<a href="#" class="radio">'+(i+1)+'</a>');
            }
            $(this).find('.nav a:first').addClass('active');
        } 
    }).find('.nav').on('click', 'a', function(e){
        e.preventDefault();
        var num = $(this).prevAll().size();
        var selectedSlide = $(this).parents('.slidesFull').find('li:eq('+num+')');
        selectedSlide.parents('ul').eq(0).css('height', selectedSlide.outerHeight());
        
        if(! selectedSlide.is(':visible')){
            var currentSlide = $(this).parents('.slidesFull').find('li:visible');
            currentSlide.fadeOut(function(){
                selectedSlide.fadeIn();
            });
            
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
        }
    }).end().find('.prev').click(function(e){
            e.preventDefault();
            current = $(this).parents('.slidesFull').find('.nav .active');
            if(current.prev().size()){
                    current.prev().click();
            } else {
                    $(this).parents('.slidesFull').find('.nav a:last').click();
            }
    }).end().find('.next').click(function(e){
            e.preventDefault();
            current = $(this).parents('.slidesFull').find('.nav .active');
            if(current.next().size()){
                    current.next().click();
            } else {
                    $(this).parents('.slidesFull').find('.nav a:first').click();
            }
    });

    
    $('.tabs:not(.staticUrls)').each(function(){
       $(this).find('a').click(function(e){
           e.preventDefault();
           $(this).parents('.tabs').find('a').removeClass('selected').each(function(i){
               $($(this).attr('href')).hide();
           });
           $(this).addClass('selected');
           $($(this).attr('href')).show();
       }).eq(0).click();
    });
    
    /* if($('select').size()){
        $('select').selectmenu({
			style:'dropdown'/*,
			change: function(e){
				$(this).trigger('chenge');
			}*/
	//	}).filter(':not(.noreload)').on("change", function(e){
		//	window.location = $(this).val();
	//	});
    //}
    $('.label_check, .label_radio').click(function(){
        setupLabel();
    });
    setupLabel(); 
    
    $('[href=#submit]').click(function(e){
        e.preventDefault();
        $('#submit').click();
    });
    $('[href=#newsletter-submit]').click(function(e){
        e.preventDefault();
        $('#newsletter-submit').click();
    });
    
    $('.scrollbar-cont').tinyscrollbar();
});





