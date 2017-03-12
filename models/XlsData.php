<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: SERG
 * Date: 12.03.2017
 * Time: 11:12
 */
class XlsData extends ActiveRecord
{
    public $level = 0;
    public function getChildren()
    {
        return $this->hasMany(XlsData::className(), ['parent_id' => 'id']);
    }

    public static function createArrayTree()
    {
        $resultArray = [];

        $records = XlsData::findAll([
            'parent_id' => 0,
        ]);

        foreach($records as $record) {
            self::process($record, $resultArray, 0);
        }
        return $resultArray;
    }

    private static function process($record, &$resultArray, $level)
    {
        $record->level = $level;
        $resultArray[] = $record;

        foreach($record->children as $rec) {
            self::process($rec, $resultArray, $level+1);
        }

    }
}