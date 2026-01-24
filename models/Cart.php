<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cart".
 *
 * @property int $id
 * @property int $user_id
 * @property int $amount
 * @property float $total
 *
 * @property CartItem[] $cartItems
 * @property User $user
 */
class Cart extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['total'], 'default', 'value' => 0],
            [['user_id'], 'required'],
            [['user_id', 'amount'], 'integer'],
            [['total'], 'number'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'amount' => 'Amount',
            'total' => 'Total',
        ];
    }

    /**
     * Gets query for [[CartItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItem::class, ['cart_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }


    public static function getCount()
    {
        $cart = static::findOne(["user_id" => Yii::$app->user->id]);
        return $cart
            ? $cart->amount
            : 0;
    }

    public static function clear()
    {
        $cart = static::findOne(["user_id" => Yii::$app->user->id]);
        return $cart->delete();
    }
}
