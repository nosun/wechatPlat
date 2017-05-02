
var cwjs=window.cwjs || {};

cwjs.common={
    recommendListInit: function () {
        var $slider=$('.recommend-list .flexslider');
        var str='1/'+$slider.find('.slides').find('li').length;
        $slider.find('.arrow').find('span').text(str);


        $slider.flexslider({
            slideshow:true,
            animationLoop:true,
            controlNav: false,
            directionNav: false,
            before: function (e) {
                console.log(e);
                var str=(Number(e.animatingTo)+1)+'/'+ e.count;
                $slider.find('.arrow').find('span').text(str);
            }
        });

        $slider.find('.arrow-l').on('click', function () {
            $slider.flexslider('prev');
        });

        $slider.find('.arrow-r').on('click', function () {
            $slider.flexslider('next');
        });
    }

    ,backTop: function () {
        var $btn=$('.btn-back-top');
        var winW=$(window).width();

        if(winW-120<1200){
            $btn.css({right:10});
        }else{
            $btn.css({right:(winW-1200-120)/2})
        }

        $btn.on('click', function () {
            $('html,body').animate({scrollTop:0},400);
        });

        $(window).on('scroll', function () {
            var scrollTop=$(window).scrollTop();
            var limit=300;

            if(scrollTop>limit && !$btn.is(':visible') ){
                $btn.removeClass('hide');
                return;
            }

            if(scrollTop<=limit && $btn.is(':visible') ){
                $btn.addClass('hide');
            }
        }).on('resize', function () {
            var winW=$(window).width();
            if(winW-120<1200){
                $btn.css({right:10});
            }else{
                $btn.css({right:(winW-1200-120)/2})
            }
        });
    }

    ,fixedFooter: function () {
        initFooter();
        function initFooter(){
            var winH=$(window).height();
            var bodyH=$(document.body).height();
            var footerH=$('footer').height();

            if(winH>=bodyH+footerH || !$('footer').hasClass('fixed-footer') && winH>=bodyH){
                $('footer').css({position:'fixed',width:'100%',left:0,bottom:0}).addClass('fixed-footer');
            }else if($('footer').hasClass('fixed-footer') && winH<bodyH+footerH){
                $('footer').css({position:'static',left:'auto',bottom:'auto'}).removeClass('fixed-footer');
            }
        }

        $(window).on('resize', function () {
            initFooter();
        })
    }

};