<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Просмотр данных';
?>
<h2><?= Html::encode($this->title) ?></h2>
<?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'header' => 'Идентификатор',
            'attribute' => 'id',
            'format' => 'text'
        ],
        [
            'header' => 'Имя каталога',
            'attribute' => 'name',
            'format' => 'text',

            'content' => function ($model,$key, $index, $column) {
            return "<div style=\"margin-left: ".($model->level*20)."px\">".Html::encode($model->name)."</div>"; }

        ],
        /*[
            'header' => 'Parent income id',
            'attribute' => 'parent_id',
            'format' => 'text'
        ],*/
        [
            'header' => 'Дата создания',
            'attribute' => 'date',
            'format' => ['date', 'php:d.m.Y']
        ],

     ]

]);