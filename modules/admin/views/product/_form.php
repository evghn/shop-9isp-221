<?php

use app\models\Category;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <div class="d-flex gap-3">
        <?= $form->field($model, 'amount')->textInput(["type" => "number"]) ?>

        <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
    </div>


    <?= $form->field($model, 'category_id')->dropDownList(Category::getCategories(), ['prompt' => "Выберете категорию"]) ?>

    <?= $form->field($model, 'description')->widget(CKEditor::class, [
        'editorOptions' => ElFinder::ckeditorOptions([
            'elfinder',
        ], [

            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
            'inline' => false, //по умолчанию false

        ]),

    ]) ?>
    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <?php
    if ($model?->productImages) {
        echo "<div class='mb-5 d-flex flex-column'> Текущее изображение:"

            . Html::img("/img/{$model->productImages[0]->photo}", ["class" => "w-25"])
            . "</div>";
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-outline-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>