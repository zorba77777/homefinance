<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Class Settings
 * @package app\models
 * @property string $group
 * @property array $data
 */
class Settings extends ActiveRecord
{
    public static function tableName()
    {
        return 'settings';
    }

    public function rules()
    {
        return [
            [['group'], 'required'],
            [['group', 'data'], 'safe']
        ];
    }

    public function get($name)
    {
        return $this->data[$name] ?? null;
    }

    public function set($name, $data)
    {
        $groupData = $this->data;
        $groupData[$name] = $data;
        $this->data = $groupData;
    }

    /**
     * @param $group
     * @return array|null|Settings
     */
    public static function getGroup($group)
    {
        $settings = Settings::find()
            ->where(['group' => $group])
            ->one();
        return $settings;
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->data = Json::decode($this->data);
    }

    public function beforeSave($insert)
    {
        $this->data = Json::encode($this->data);
        return parent::beforeSave($insert);
    }
}
