# CSRF
使用AB cookie防御CSRF攻击. Use two cookies (AB cookies) to defend against CSRF attacks.

# 使用方法
1.全网站加载js文件(可以在公共头尾文件里加载)
如:
```html
<script type="text/javascript" src="/static/admin/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/admin/js/jquery.cookie.js"></script>
<script type="text/javascript" src="/static/admin/js/CSRF.js"></script>
```

2.在入口文件增加CSRF处理. 见example.php
```php
<?php
/**
 * 使用例子
 *
 * @author        肖武 <five@v5ip.com>
 * @datetime      2018/1/11 下午10:08
 */

//假设这是一个controller基类
class Controller{
    
    //初始化方法
    function init() {
        //检查登录
        //$this->checkLogin();

        //csrf处理. 
        $this->dealCsrf();
        
        //... 其它处理 ...
    }

    /**
     * 处理CSRF
     * 
     * @throws Exception
     */
    protected function dealCSRF() {
        $csrf = new \Five\CSRF\CSRF();

        //所有post请求都检查CSRF
        if (!empty($_POST)) {
            $this->checkCSRF($csrf);
        }
        
        //所有ajax方法都检查
        if ('Ajax' == $this->getRequest()->getControllerName()) {
            $this->checkCSRF($csrf);
        }
        
        //更新token
        $csrf->updateToken();
    }

    /**
     * 检查CSRF token, 有错误时抛异常
     * 
     * @param \Five\CSRF\CSRF $csrf
     *
     * @throws Exception
     */
    protected function checkCSRF($csrf) {
        if (!$csrf->checkToken()) {
            //根据自己项目需求, 抛出异常或其它处理
            throw new Exception('非法请求, 拒绝访问');
        }
    }
    
    //... 其它方法 ....
}


```