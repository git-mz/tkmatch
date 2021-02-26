<?php
/**
 * 文本-关键词(标签)匹配类库
 * User: 盟主
 * Date: 21/01/28
 */
namespace tkmatch;

use tkmatch\util\HashMap;

class Main
{
    /**
     * 待匹配文本总长度
     *
     * @var int
     */
    protected $contentLength = 0;

    /**
     * 标签单例
     *
     * @var object|null
     */
    private static $_instance = null;

    /**
     * 标签词库树
     *
     * @var HashMap|null
     */
    protected $wordTree = null;

    /**
     * 存放已匹配的标签
     *
     * @var array|null
     */
    protected static $tagWordList = null;

    /**
     * 获取单例
     *
     * @return self
     */
    public static function init()
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * 构建标签词树【数组模式】
     * @param null $sensitiveWords
     *
     * @return $this
     */
    public function setTree($sensitiveWords = null)
    {
        $this->wordTree = new HashMap();
        foreach ($sensitiveWords as $words) {
            $this->buildWordToTree($words['word'], $words['url']);
        }
        return $this;
    }

    /**
     * 检测文本中的标签
     *
     * @param string   $content    待检测内容
     * @param int      $matchType  匹配类型 [默认为最小匹配规则]
     * @param int      $wordNum    需要获取的标签数量 [默认获取全部]
     * @return array
     */
    public function getTagWord($content, $matchType = 1, $wordNum = 0)
    {
        $this->contentLength = mb_strlen($content, 'utf-8');
        $tagWordList         = array();
        for ($start = 0; $start < $this->contentLength; $start++) {
            $matchFlag  = 0;
            $flag       = false;
            $url        = '';
            $tempMap    = $this->wordTree;
            $len = 0;
            for ($i = $start; $i < $this->contentLength; $i++) {
                $keyChar = mb_substr($content, $i, 1, 'utf-8');
                // 获取指定节点树
                $nowMap = $tempMap->get($keyChar);
                // 不存在节点树，直接返回
                if (empty($nowMap)) {
                    break;
                }
                // 存在，则判断是否为最后一个
                $tempMap = $nowMap;
                // 找到相应key，偏移量+1
                $matchFlag++;
                if (false == $tempMap->get('ending')) {
                    continue;
                }
                if (true === $tempMap->get('ending')) {
                    $len = $matchFlag;
                    $flag = true;
                    $url  = $tempMap->get('url');
                    continue;
                }
                // 最小规则，直接退出
                if (1 === $matchType) {
                    break;
                }
            }
            if (!$flag) {
                $len = 0;
            }
            // 找到相应key
            if ($len <= 0) {
                continue;
            }
            $words         = mb_substr($content, $start, $len, 'utf-8');
            $tagWordList[] = ['words' => $words, 'url' => $url, 'len' => mb_strlen($words, 'utf-8')];
            // 有返回数量限制
            if ($wordNum > 0 && count($tagWordList) == $wordNum) {
                return $tagWordList;
            }
            // 需匹配内容标志位往后移
            $start = $start + $matchFlag - 1;
        }
        array_multisort(array_column($tagWordList, 'len'), SORT_DESC, $tagWordList);
        return $tagWordList;
    }

    /**
     * 替换标签字符
     *
     * @param        $content      文本内容
     * @param string $replaceChar  替换字符
     * @param int    $matchType
     *
     * @return mixed
     */
    public function replace($content, $replaceChar = '', $matchType = 1)
    {
        $tagWordList = self::$tagWordList ? self::$tagWordList : $this->getTagWord($content, $matchType);

        // 未检测到标签，直接返回
        if (empty($tagWordList)) {
            return $content;
        }
        foreach ($tagWordList as $tagWord) {
            $words           = implode('-???-', preg_split('/(?<!^)(?!$)/u', $tagWord['words']));
            $hasReplacedChar = '<a href="' . $tagWord['url'] . '">' . $words . '</a>';
            $content = str_replace($tagWord['words'], $hasReplacedChar, $content);
        }
        $content = str_replace('-???-', '', $content);
        return $content;
    }

    // 将单个标签构建成树结构
    protected function buildWordToTree($word = '', $url = '')
    {
        if ('' === $word) {
            return;
        }
        $tree = $this->wordTree;

        $wordLength = mb_strlen($word, 'utf-8');
        for ($i = 0; $i < $wordLength; $i++) {
            $keyChar = mb_substr($word, $i, 1, 'utf-8');

            // 获取子节点树结构
            $tempTree = $tree->get($keyChar);

            if ($tempTree) {
                $tree = $tempTree;
            } else {
                // 设置标志位
                $newTree = new HashMap();
                $newTree->put('ending', false);

                // 添加到集合
                $tree->put($keyChar, $newTree);
                $tree = $newTree;
            }

            // 到达最后一个节点
            if ($i == $wordLength - 1) {
                $tree->put('ending', true);
                $tree->put('url', $url);
            }
        }
        return;
    }

}
