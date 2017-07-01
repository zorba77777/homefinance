<?php
/**
 * @var string $type
 * @var array $output
 */
?>

<label style="font-weight: normal">Выберите категорию <br/>
    <select name="category" onchange="subcategory(this)" data-type="<?= $type ?>">
        <option value="select" disabled selected>Выбрать</option>
        <?php foreach ($output as $value) {
            $hasChild = $value->has_child == 'yes' ?>
            <option data-has-child="<?= $hasChild  ? 1 : 0 ?>" value="<?= $value->id ?>">
                <?= $value->category ?> <?= $hasChild ? '&#9660;' : '' ?>
            </option>
        <?php } ?>
    </select>
    <br/>
</label>
<br/>