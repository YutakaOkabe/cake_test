<?php
// src/Model/Entity/Article.php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Article extends Entity
{
    // 一括代入でどのプロパティーの値の変更を可能にするか
    protected $_accessible = [
        '*' => true,
        'id' => false,
        'slug' => false,
    ];
}