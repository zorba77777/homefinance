<?php


namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Category
 * @package app\models
 * @property string $login
 * @property string $category
 * @property string $typeOfCategory
 * @property string $parent_category
 * @property string $has_child
 * @property integer $position
 */
class Category extends ActiveRecord
{
    public $children = [];

    public static function tableName()
    {
        return 'categories';
    }

    public function rules()
    {
        return [
            [['login', 'category', 'typeOfCategory', 'parent_category', 'has_child', 'position'], 'safe']
        ];
    }

    public static function findByLogin($login)
    {
        $categories = Category::find()
            ->where(['login' => $login])
            ->all();
        return $categories;
    }

    public static function deleteCategory($id)
    {
        $category = Category::find()
            ->where(['id' => $id])
            ->one();
        if ($category->has_child == 'yes') {
            $children = Category::find()
                ->where(['parent_category' => $id])
                ->all();
            foreach ($children as $value) {
                self::deleteCategory($value->id);
            }
        }
        if ($category->parent_category != 'none') {
            $parentId = $category->parent_category;
            $category->delete();
            if (!Category::find()->where(['parent_category' => $parentId])->one()) {
                $cat = Category::find()
                    ->where(['id' => $parentId])
                    ->one();
                $cat->has_child = 'no';
                $cat->save();
            }
        } else {
            $category->delete();
        }

    }


    public static function findDepositCategories($login)
    {
        $categories = Category::find()
            ->where(['login' => $login,
                'typeOfCategory' => 'deposit'])
            ->all();
        return $categories;
    }

    public static function findDebitCategories($login)
    {
        $categories = Category::find()
            ->where(['login' => $login,
                'typeOfCategory' => 'debit'])
            ->all();
        return $categories;
    }

    public static function findSortedDebitCategories($login)
    {
        $categories = Category::find()
            ->where(['login' => $login,
                'typeOfCategory' => 'debit'])
            ->orderBy(['position' => SORT_DESC])
            ->all();
        return $categories;
    }

    public static function findSortedDepositCategories($login)
    {
        $categories = Category::find()
            ->where(['login' => $login,
                'typeOfCategory' => 'deposit'])
            ->orderBy(['position' => SORT_DESC])
            ->all();
        return $categories;
    }

    public static function orderChildrenParents($element)
    {
        $array = [];
        foreach ($element as $item) {
            $array[] = $item;
            if ($item->has_child == 'yes') {
                $result = self::orderChildrenParents($item->children);
                $array = array_merge($array, $result);
            }
        }
        return $array;
    }
}