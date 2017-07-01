<?php

/**
 * @var array $letterText
 */

use app\assets\admin\AdminAsset;
use yii\helpers\Html;
use yii\helpers\Url;
AdminAsset::register($this);
$this->title = 'Letter';
?>
<h1>Редактировать текст сопроводительного письма</h1>

<form method="post">
    <label style="font-weight: normal">Тема
        <br />
        <input type="text" value="<?=$letterText['subject']?>" name="subject">
    </label>
    <br />
    <br />
    <label style="font-weight: normal; white-space: pre-wrap" >Текст
        <textarea rows="4" cols="50" name="text"><?=$letterText['text']?></textarea>
    </label>
    <br />
    <label style="font-weight: normal">Выберите тип файла вложения<br/>
        <select name="type">
            <option value="excel" <?= $letterText['type'] == 'excel' ? 'selected' : '' ?>>excel</option>
            <option value="pdf" <?= $letterText['type'] == 'pdf' ? 'selected' : '' ?>>pdf</option>
        </select>
        <br/>
    </label>
    <br />
    <br />
    <input type="submit" value="Сохранить изменения" name="submit" class="btn-default">
</form>
<br />
<?= Html::a('Вернуться', Url::to('/admin/admin')) ?>