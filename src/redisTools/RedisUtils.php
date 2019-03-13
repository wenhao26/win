<?php
// +----------------------------------------------------------------------
// | Redis 工具扩展类
// +----------------------------------------------------------------------
// | Author: CongCao
// +----------------------------------------------------------------------
// | Date: 2018/7/12
// +----------------------------------------------------------------------

class RedisUtils
{
    /**
     * @var string 服务地址
     */
    private $host = '127.0.0.1';

    /**
     * @var int 端口号
     */
    private $port = 6379;

    /**
     * @var string hash表名称，默认是存储授权体系的token
     */
    private $hash = 'apm_custom_goods';

    /**
     * @var object redis对象
     */
    private $redis;

    public function __construct($options = [])
    {
        if (is_array($options)) {
            // TODO 根据实际情况，初始化对应属性
            $this->hash = isset($options['hash']) ? $options['hash'] : $this->hash;
        }

        $this->redis = new redis();
        $this->redis->connect($this->host, $this->port);
    }

    /**
     * 增加一个或多个元素，如果该元素已经存在，更新它的socre值
     *
     * @param string $key   键名
     * @param int    $socre socre值
     * @param string $value 数据值
     */
    public function zAdd($key, $socre, $value)
    {
        $this->redis->zAdd($key, $socre, $value);
    }

    /**
     * 取得特定范围内的排序元素,0代表第一个元素,1代表第二个以此类推
     *
     * @param string $key        键名
     * @param int    $start      开始位置
     * @param int    $end        结束位置
     * @param bool   $withscores 是否输出socre的值，默认false
     * @return array
     */
    public function zRange($key, $start = 0, $end = -1, $withscores = true)
    {
        return $this->redis->zRange($key, $start, $end, $withscores);
    }

    /**
     * 添加一个字符串值到LIST容器的顶部（左侧）
     *
     * @param string $key   键名
     * @param string $value 数据值
     */
    public function lPush($key, $value)
    {
        $this->redis->lPush($key, $value);
    }

    /**
     * 返回LIST顶部（左侧）的VALUE，并且从LIST中把该VALUE弹出
     *
     * @param string $key 键名
     * @return string
     */
    public function lPop($key)
    {
        return $this->redis->lPop($key);
    }

    /**
     * 根据KEY返回该KEY代表的LIST的长度
     *
     * @param string $key 键名
     */
    public function lSize($key)
    {
        return $this->redis->lSize($key);
    }

    /**
     * hash设置数据
     *
     * @param string $key   键名
     * @param string $value 数据值
     */
    public function hSet($key, $value)
    {
        if ($key && $value) $this->redis->hSet($this->hash, $key, $value);
    }

    /**
     * 通过key值获取对应hash表中的数据
     *
     * @param string $key 键名
     * @return string
     */
    public function hGet($key)
    {
        return $this->redis->hGet($this->hash, $key);
    }

    /**
     * 返回所有hash表数据
     *
     * @return array
     */
    public function hGetAll()
    {
        return $this->redis->hGetAll($this->hash);
    }

    /**
     * 获取hash表存储长度
     *
     * @return int
     */
    public function hLen()
    {
        return $this->redis->hLen($this->hash);
    }

    /**
     * 删除hash表指定的元素
     *
     * @param string $key 键名
     * @return bool|int
     */
    public function hDel($key)
    {
        if ($key) return $this->redis->hDel($this->hash, $key);
    }

    /**
     * 获取hash表中的keys，并且以数组返回
     *
     * @return array
     */
    public function hKeys()
    {
        return $this->redis->hKeys($this->hash);
    }

    /**
     * 获取hash表中的values，并且以数组返回
     *
     * @return array
     */
    public function hVals()
    {
        return $this->redis->hVals($this->hash);
    }

    /**
     * 验证hash表，是否存在指定的KEY-VALUE
     *
     * @param string $key 键名
     * @return bool
     */
    public function hExists($key)
    {
        return $this->redis->hExists($this->hash, $key);
    }

    /**
     * 设置一个值到KEY
     *
     * @param string $key     键名
     * @param string $value   键值
     * @param int    $expires 过期时间，默认永不过期
     */
    public function set($key, $value, $expires = 0)
    {
        if (intval($expires) == 0) {
            $this->redis->set($key, $value);
        } else {
            $this->redis->set($key, $value, $expires);
        }
    }

    /**
     * 取得与指定的键值相关联的值
     *
     * @param string $key 键名
     * @return bool|string
     */
    public function get($key)
    {
        return $this->redis->get($key);
    }

    /**
     * 删除指定的元素
     *
     * @param string $key 键名
     * @return int
     */
    public function delete($key)
    {
        return $this->redis->delete($key);
    }


}