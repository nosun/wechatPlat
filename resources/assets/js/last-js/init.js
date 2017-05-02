/*
* 此文件仅调用函数,勿写处理任何逻辑。
* */

$(function () {
    setTimeout(function () {
        /**
         * @param {element} el  Feature detection
         * @param {function} fn  Executive function
         */
        function init(el,fn){
            if($(el).length && (typeof fn) === 'function') fn(el);
        }

        //header
        init('header .search-box',cwjs.search.headerSearchBoxInit);

    },1);
});

