<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property int $id
 * @property string $title
 *
 * @property Order[] $orders
 */
class Status extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', "alias"], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['status_id' => 'id']);
    }


    public static function getStatusId($alias)
    {
        return static::findOne(['alias' => $alias])->id;
    }


    public static function getStatus($id)
    {
        return static::findOne($id)->title;
    }

    public static function getStatusAlias($id)
    {
        return static::findOne($id)->alias;
    }

    public static function getStatuses()
    {
        return static::find()
            ->select('title')
            ->indexBy('id')
            ->column()
        ;
    }
}
