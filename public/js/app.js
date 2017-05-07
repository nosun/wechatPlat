;var cwjs=window.cwjs || {};

cwjs.wechatEdit={
    init : function(el){
        $(el).each(function(){
            cwjs.wechatEdit.checkLength($(this));
        });
        $(el).on('keyup keydown keypress propertychange blur',function(){
            cwjs.wechatEdit.checkLength($(this));
        });
    },

    checkLength : function(el){
        var check;
        var lengthLimit = el.data('length');
        var length = el.val().length;
        var messageBox = el.parents('.form-group').children('.input-message');
        if(lengthLimit == null || lengthLimit == 0 || lengthLimit ==''){
            check = true;
        }else{
            check = length > lengthLimit;
            limit = length - lengthLimit;
        }
        if(check == true ){
            messageBox.html("您输入已超出" + limit + "字").removeClass('info').addClass('error').css('display','block');
            return false;
        }else{
            if(limit > -10){
                messageBox.html("您还能输入" + -limit + "字").removeClass('info').addClass('error').css('display','block');
            }else{
                messageBox.html(length + "/" + lengthLimit).removeClass('error').addClass('info').css('display','block');
            }
            return true;
        }
    }

};
