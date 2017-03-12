<?php

use app\assets\FileUploadAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Импорт данных из файлов MS Excel';
?>
<h2><?= Html::encode($this->title) ?></h2>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'xlsFile')->label("",['class'=>''])
    ->fileInput(['id' => "fileupload", 'multiple' => true, 'url' => ['site/upload'], /*'data-url' => "index.php?r=site%2Fupload",*/ 'class' => 'btn btn-success']) ?>

<?php ActiveForm::end();
FileUploadAsset::register($this);
?>
<div id="uploaded">
</div>




