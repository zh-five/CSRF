/**
 * CSRF 客户端处理, 依赖jquery 和jquery cookie插件
 * @link https://github.com/zh-five/CSRF
 */

$(function(){
    //所有ajax提交前处理token
    $(document).bind("ajaxSend", copy_csrf_token);
    
    //所有表单提交前处理token
    $('from').submit(copy_csrf_token);
    
/*    
    //点击所有连接是出来token
    $('a').bind('click', function(){
         csrf();
    });
*/
});

//把token从A cookie复制到B cookie
function copy_csrf_token() {
    $.cookie('CSRF_TOKEN_B', $.cookie('CSRF_TOKEN_A'));
}