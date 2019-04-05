<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-04-05
 * Time: 19:38
 */

class SessionHandlerDb implements SessionHandlerInterface
{
    private $link;

    //存放过期时间
    private $lifetime = 180;

    public function open($savePath, $session_name)
    {
        //连接数据库
        $this->link = mysqli_connect('localhost', 'root', 'root');
        mysqli_set_charset($this->link, 'utf8');
        mysqli_select_db($this->link, 'test');
        if ($this->link) {
            return true;
        }
        return false;
    }

    public function close()
    {
        mysqli_close($this->link);
        return true;
    }

    /**
     * 读取session
     */
    public function read($session_id): string
    {
        //安全处理传入的session_id
        $session_id = mysqli_escape_string($this->link, $session_id);

        $sql = "select * from sessions where session_id = '{$session_id}' and session_expires > " . time();
        $result = mysqli_query($this->link, $sql);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            return $row['session_data'];
        } else {
            return '';
        }
    }

    public function write($session_id, $session_data)
    {
        //过期时间
        $new_expires = time() + $this->lifetime;

        //处理传入的session_id
        $session_id = mysqli_escape_string($this->link, $session_id);
        //查询指定session_id是否存在，存在则更新数据；不存在，则写入数据
        $sql = "select * from sessions where session_id = '{$session_id}'";
        $result = mysqli_query($this->link, $sql);

        //判断是否存在
        if (mysqli_num_rows($result) == 1) {
            $sql = "update sessions set session_expires = '{$new_expires}', session_data = '{$session_data}' where session_id = '{$session_id}'";

        } else {
            $sql = "insert into sessions values ( '{$new_expires}', '{$session_data}','{$session_id}')";
        }
        mysqli_query($this->link, $sql);
        if (mysqli_affected_rows($this->link) == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function destroy($session_id)
    {
        $session_id = mysqli_escape_string($this->link, $session_id);
        $sql = "delete from sessions where session_id = '{$session_id}'";
        mysqli_query($this->link, $sql);
        return mysqli_affected_rows($this->link) == 1;
    }

    //垃圾回收
    public function gc($maxlifetime)
    {
        $sql = "delete from sessions where session_expires < " . time();
        mysqli_query($this->link, $sql);
        if (mysqli_affected_rows($this->link) > 0) {
            return true;
        }
        return false;
    }
}