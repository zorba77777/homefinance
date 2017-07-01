<?php
/**
 * @var array $categoryList
 */

foreach ($categoryList as $key => $value) {
    switch (true) {
        case ($key == 0):
            echo '<li style="cursor:pointer">
                            <span id="' . $value->id . '" onclick="deletion(this)">' . $value->category . '</span>
                            <span id="' . $value->id . '" style="font-size: 10px"  onclick="addChild(this)">   +добавить дочернюю категорию</span>';
            break;
        case ($categoryList[$key - 1]->position == $categoryList[$key]->position):
            echo '</li><li style="cursor:pointer">
                            <span id="' . $value->id . '" onclick="deletion(this)">' . $value->category . '</span>
                            <span id="' . $value->id . '" style="font-size: 10px"  onclick="addChild(this)">   +добавить дочернюю категорию</span>';
            break;
        case ($categoryList[$key - 1]->position < $categoryList[$key]->position):
            echo '<ul><li style="cursor:pointer"><span id="' . $value->id . '" onclick="deletion(this)">' . $value->category . '</span>
                             <span id="' . $value->id . '" style="font-size: 10px" onclick="addChild(this)">   +добавить дочернюю категорию</span></li>';
            break;
        case ($categoryList[$key - 1]->position > $categoryList[$key]->position):
            $i = $categoryList[$key - 1]->position - $categoryList[$key]->position;
            while ($i != 0) {
                echo '</li>';
                echo '</ul>';
                $i--;
            }
            echo '</li>';
            echo '<li style="cursor:pointer"><span id="' . $value->id . '" onclick="deletion(this)">' . $value->category . '</span>
                             <span id="' . $value->id . '" style="font-size: 10px" onclick="addChild(this)">   +добавить дочернюю категорию</span>';
            break;
    }
}
$keyOfLastElement = count($categoryList) - 1;
$i = $categoryList[$keyOfLastElement]->position;
while ($i != 0) {
    echo '</li>';
    echo '</ul>';
    echo '</li>';
    $i--;
}
?>