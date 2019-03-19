<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $model app\models\DocumentType */

$this->title = Yii::t('app', 'Document Type') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Document Types', 'url' => ['document-type-index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<?php \yii\bootstrap\Modal::begin([
    'id' => 'mdl-add-doc-field',
    'size' => \yii\bootstrap\Modal::SIZE_LARGE,
    'header' => '<h3>'.Yii::t('app', 'Add Document-Field').'</h3>'
])?>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
            	  <div class="panel-heading">
            			<h3 class="panel-title"><?= Yii::t('app', 'existing Document-Field')?></h3>
            	  </div>
            	  <div class="panel-body">
                      <?php $form = \kartik\form\ActiveForm::begin([
                          'action' => \yii\helpers\Url::to([
                              'document-field-add-to-type',
                              'documenttype' => $model->id
                          ])
                      ]);
                      $dthf = new \app\models\DocumentTypeHasField();
                      ?>
                      <?= Html::activeHiddenInput($dthf, 'document_type_id',['value'=>$model->id]) ?>
                      <div class="row">
                              <?= $form->field($dthf, 'field_id')->widget(\kartik\select2\Select2::class,[
                                  'data' => \yii\helpers\ArrayHelper::map(
                                      \app\models\DocumentField::find()
                                          ->where(['not',[
                                              'in',
                                              'id',
                                              \app\models\DocumentTypeHasField::find()
                                                  ->select('field_id')
                                                  ->where(['document_type_id'=>$model->id])
                                          ]
                                          ])
                                          ->asArray()
                                          ->all(),
                                      'id',
                                      'name'
                                  )
                              ])?>
                              <?= $form->field($dthf, 'required')->widget(\kartik\widgets\SwitchInput::class,[
                                  'pluginOptions' => [
                                      'onColor' => 'success',
                                      'offColor' => 'danger',
                                      'onText' => Yii::t('app', 'Yes'),
                                      'offText'=> Yii::t('app', 'No'),
                                  ]
                              ]) ?>
                              <?= Html::submitButton(
                                      Yii::t('app','add'),
                                      ['class'=>'btn btn-success','style'=>'width:100%;']
                              ) ?>
                      </div>

                      <?php \kartik\form\ActiveForm::end() ?>
            	  </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
            	  <div class="panel-heading">
            			<h3 class="panel-title">FOLGT NOCH</h3>
            	  </div>
            	  <div class="panel-body">
            			<?= Html::a('add',['/admin/document-field-create'],['class'=>'btn btn-success']) ?>
            	  </div>
            </div>
        </div>
    </div>

<?php \yii\bootstrap\Modal::end() ?>
<div class="document-type-view">
    <div class="col-md-12" style="margin-bottom: 15px">
        <?= Html::a('Update', ['document-type-update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['document-type-delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'name',
                        [
                            'attribute' => 'regex',
                            'format'    => 'raw',
                            'value'     => "<code>{$model->regex}</code>"
                        ]
                    ],
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="panel panel-default">
        	  <div class="panel-heading">
        			<h3 class="panel-title"><?= Yii::t('app', 'Document Fields') ?></h3>
        	  </div>
        	  <div class="panel-body">
        			<?= \yii\grid\GridView::widget([
        			        'dataProvider' => new \yii\data\ArrayDataProvider(['allModels'=>$model->documentTypeHasFields, 'key' => 'field_id']),
                            'columns' => [
                                    'field.name',
                                    [
                                            'attribute' => 'required',
                                            'format'    => 'raw',
                                            'value'     => function($model){
        			                            if($model->required == 1){
        			                                return "<span class=\"label label-success\">" . Yii::t('app', 'Yes') . "</span>";
                                                }
                                                return "<span class=\"label label-danger\">" . Yii::t('app', 'No') . "</span>";
                                            }
                                    ],
                                    [
                                            'attribute' => 'field.regex',
                                            'format' => 'raw',
                                            'value' => function($model){
        			                            return "<code>{$model->field->regex}</code>";
                                            }
                                    ],
                                    'field.element',
                                    [
                                            'class'     => ActionColumn::class,
                                            'template'  => '{update} {delete}',
                                            'urlCreator'=> function ($action, $modelA, $key, $index) use ($model) {
        			                            $action = 'document-field-'.$action;
                                                $params = is_array($key) ? $key : ['documenttype'=> $model->id, 'id' => (string) $key ];
                                                $params[0] = $action;
                                                return \yii\helpers\Url::toRoute($params);
                                            }
                                    ]
                            ]
                    ]) ?>
        	  </div>

               <div class="panel-footer">
                   <?= Html::a(
                           Yii::t('app', 'add Document-Field'),
                           null,
                           ['class'=>'btn btn-success', 'onclick'=>'$("#mdl-add-doc-field").modal("show");']
                   ) ?>
               </div>

        </div>
    </div>
    

</div>
