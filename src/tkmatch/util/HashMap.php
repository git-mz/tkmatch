<?php
/**
 * HashMap处理类
 * User: 盟主 
 * Date: 21/01/28
 */
namespace tkmatch\util;

class HashMap
{
    /**
     * 初始化hashTable
     *
     * @var array|[]
     */
    protected $hashTable = array();

    /**
     * 向HashMap中添加一个键值对
     *
     * @param $key
     * @param $value
     * @return true
     */
    public function put($key, $value)
    {
        $this->hashTable[$key] = $value;
        return true;
    }

    /**
     * 根据key获取对应的value
     *
     * @param $key
     * @return value|false
     */
    public function get($key)
    {
        if (array_key_exists($key, $this->hashTable)) {
            return $this->hashTable[$key];
        }
        return null;
    }

    /**
     * 删除指定key的键值对
     *
     * @param $key
     * @return true|false
     */
    public function remove($key)
    {
        if (array_key_exists($key, $this->hashTable)) {
            unset($this->hashTable[$key]);
            return true;
        }
        return false;
    }

    /**
     * 获取HashMap的所有key
     *
     * @return array
     */
    public function keys()
    {
        return array_keys($this->hashTable);
    }

    /**
     * 获取HashMap的所有value
     *
     * @return array
     */
    public function values()
    {
        return array_values($this->hashTable);
    }

    /**
     * 将一个HashMap的值全部put到当前HashMap中
     *
     * @param \DfaFilter\HashMap $map
     */
    public function putAll($map)
    {
        if (!$map->isEmpty() && $map->size() > 0) {
            $keys = $map->keys();
            foreach ($keys as $key) {
                $this->put($key, $map->get($key));
            }
        }
        return;
    }

    /**
     * 移除HashMap中所有元素
     *
     * @return bool
     */
    public function removeAll()
    {
        $this->hashTable = null;
        return true;
    }

    /**
     * 判断HashMap中是否包含指定的值
     *
     * @param $value
     * @return bool
     */
    public function containsValue($value)
    {
        while ($curValue = current($this->hashTable)) {
            if ($curValue == $value) {
                return true;
            }
            next($this->hashTable);
        }
        return false;
    }

    /**
     * 判断HashMap中是否包含指定的键key
     *
     * @param $key
     * @return bool
     */
    public function containsKey($key)
    {
        if (array_key_exists($key, $this->hashTable)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取HashMap中元素个数
     *
     * @return int
     */
    public function size()
    {
        return count($this->hashTable);
    }

    /**
     * 判断HashMap是否为空
     *
     * @return bool
     */
    public function isEmpty()
    {
        return (count($this->hashTable) == 0);
    }
}
