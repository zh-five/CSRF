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

        //csrf处理. (调用前须确保已经session_start()了)
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






