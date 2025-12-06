<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $title
 * @property int $amount
 * @property float $price
 * @property int $category_id
 * @property string $description
 *
 * @property CartItem[] $cartItems
 * @property Category $category
 * @property OrderItem[] $orderItems
 * @property ProductImage[] $productImages
 */
class Product extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price'], 'default', 'value' => 0],
            [['like', 'dislike'], 'default', 'value' => 0],
            [['title', 'category_id'], 'required'],
            [['amount', 'category_id', 'like', 'dislike'], 'integer'],
            [['price'], 'number'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg', "on" => static::SCENARIO_CREATE],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', "on" => static::SCENARIO_UPDATE],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Наименование товара',
            'amount' => 'Количество',
            'price' => 'Цена',
            'category_id' => 'Категория',
            'description' => 'Описание',
            'imageFile' => 'Изображение товара',
        ];
    }

    /**
     * Gets query for [[CartItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItem::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['product_id' => 'id']);
    }


    /**
     * Gets query for [[Favourites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavourites()
    {
        return $this->hasMany(Favourite::class, ['product_id' => 'id']);
    }


    /**
     * Gets query for [[UserReactions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserReactions()
    {
        return $this->hasMany(UserReaction::class, ['product_id' => 'id']);
    }


    /**
     * Gets query for [[ProductImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->hasMany(ProductImage::class, ['product_id' => 'id']);
    }


    public function upload()
    {
        if ($this->validate()) {
            $fileName = Yii::$app->user->id
                . "_"
                . time() . "_"
                . Yii::$app->security->generateRandomString()
                . "." .  $this->imageFile->extension;


            $this->imageFile->saveAs('img/' . $fileName);
            return $fileName;
        } else {
            return false;
        }
    }
}
