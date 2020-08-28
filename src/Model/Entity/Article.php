<?php
// src/Model/Entity/Article.php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Collection\Collection;

class Article extends Entity
{
    // 一括代入でどのプロパティーの値の変更を可能にするか
    protected $_accessible = [
        '*' => true, // 全て
        'id' => false,
        'slug' => false,
    ];

    protected function _getTagString()
    {
        if (isset($this->_fields['tag_string'])) {
            return $this->_fields['tag_string'];
        }
        if (empty($this->tags)) {
            return '';
        }
        $tags = new Collection($this->tags);
        $str = $tags->reduce(function ($string, $tag) {
            return $string . $tag->title . ', ';
        }, '');
        return trim($str, ', ');
    }
}
