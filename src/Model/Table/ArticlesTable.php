<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;

class ArticlesTable extends Table
{
    public function initialize(array $config) : void
    {
        // created や modified カラムを自動的に更新
        $this->addBehavior('Timestamp');
    }
}