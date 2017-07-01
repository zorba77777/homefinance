<?php

namespace app\widgets\categoryTree;

use yii\base\Widget;

class CategoryTree extends Widget
{
    public $categoryList;

    public function run()
    {
        return $this->render('categoryTree', [
            'categoryList' => $this->categoryList
        ]);
    }
}
