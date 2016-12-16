<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 03.08.2016
 * Time: 18:48
 */

/**@var \app\models\Document[] $documents */


foreach ($documents as $document): ?>
    <tr>
        <td>
        </td>
        <td>
            <a href="<?= \yii\helpers\Url::to(['document/update','id'=>$document->id]) ?>">
                <div class="document-preview" style="background-image: url('./data/<?= $document->folder ?>/thumb.jpeg'); width: 250px; height: 150px;"></div>
            </a>
        </td>
        <td>
            <a href="<?= \yii\helpers\Url::to(['document/update','id'=>$document->id]) ?>">
                <h4><?= $document->input_filename.'.'.$document->input_file_extension ?></h4>
            </a>
        </td>

        <td>
            <?= $document->input_date ?>
        </td>
    </tr>

<?php endforeach; ?>
