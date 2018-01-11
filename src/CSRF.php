<?php
/**
 * CSRF 服务端处理
 *
 * @author        肖武 <five@v5ip.com>
 * @datetime      2018/1/11 下午9:39
 * @link          https://github.com/zh-five/CSRF
 */

namespace Five\CSRF;


class CSRF {
    protected $a_cookie_name = 'CSRF_TOKEN_A';
    protected $b_cookie_name = 'CSRF_TOKEN_B';
    protected $session_name  = 'CSRF_TOKEN';


    public function __construct($a_cookie_name = 'CSRF_TOKEN_A', $b_cookie_name = 'CSRF_TOKEN_B', $session_name = 'CSRF_TOKEN') {
        $this->a_cookie_name = $a_cookie_name;
        $this->b_cookie_name = $b_cookie_name;
        $this->session_name  = $session_name;
    }

    /**
     * 检查token
     *
     * @return bool token相等是返回true, 否则为false(可能是CSRF攻击)
     */
    public function checkToken() {
        return (
            isset($_COOKIE[$this->b_cookie_name])
            && $_COOKIE[$this->b_cookie_name] != $_SESSION[$this->session_name]
        );
    }
    
    /**
     * 更新token
     * 
     * @param string $token  token字符串, 为空是会自动生成
     * @param int    $expire cookie过期时间, 默认为关闭浏览器后失效
     * @param string $path   Cookie 有效的服务器路径
     * @param string $domain Cookie 的有效域名/子域名
     * @param bool   $secure 是否仅仅通过安全的 HTTPS 连接传给客户端
     */
    public function updateToken($token = '', $expire = 0, $path = '/', $domain = '', $secure = false) {
        !$token && $token = uniqid();
        $httponly = false; //一定要设为false, 以便js读取
        setcookie($this->a_cookie_name, $token, $expire, $path, $domain, $secure, $httponly);
    }

}
