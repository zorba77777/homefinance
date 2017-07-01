<?php

namespace app\controllers;

use app\models\Category;
use Yii;

class CategoryController extends BaseController
{
    public $enableCsrfValidation = false;

    public function actionEditCategory()
    {
        $login = Yii::$app->user->identity->login;
        $depositCategories = Category::findSortedDepositCategories($login);
        $depositCategories = $this->addChildren($depositCategories);
        $debitCategories = Category::findSortedDebitCategories($login);
        $debitCategories = $this->addChildren($debitCategories);
        return $this->render('editCategory', [
            'depositCategories' => $depositCategories,
            'debitCategories'   => $debitCategories
        ]);
    }

    public function actionAdd()
    {
        $id = Yii::$app->request->post('id');
        if ($id == 'debit' || $id == 'deposit') {
            $newCategory = new Category();
            $newCategory->login = Yii::$app->user->identity->login;
            $newCategory->category = Yii::$app->request->post('category');
            $newCategory->typeOfCategory = $id;
            $newCategory->save();
        } else {
            $parentCategory = Category::find()
                ->where(['id' => Yii::$app->request->post('id')])
                ->one();
            $newCategory = new Category();
            $newCategory->login = $parentCategory->login;
            $newCategory->category = Yii::$app->request->post('category');
            $newCategory->typeOfCategory = $parentCategory->typeOfCategory;
            $newCategory->parent_category = $parentCategory->id;
            $newCategory->position = $parentCategory->position + 1;
            $newCategory->save();
            $parentCategory->has_child = 'yes';
            $parentCategory->save();
        }
    }

    public function actionDelete()
    {
        Category::deleteCategory(Yii::$app->request->post('id'));
    }

    private function addChildren($array)
    {
        $resultingArray = $array;
        foreach ($array as $key => $value) {
            if ($value->parent_category != 'none') {
                foreach ($resultingArray as $item) {
                    if ($item->id == $value->parent_category) {
                        $item->children[] = $value;
                        unset($resultingArray[$key]);
                    }
                }
            }
        }
        $resultingArray = Category::orderChildrenParents($resultingArray);
        return $resultingArray;
    }
}