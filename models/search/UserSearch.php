<?php

namespace app\models\search;

use app\models\User;
use yii\data\ActiveDataProvider;

class UserSearch extends User
{
    public function rules()
    {
        return [
            [['id', 'login', 'name', 'surname', 'city', 'role', 'email', 'subscribed', 'vk_id'], 'safe']
        ];
    }


    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'login' => $this->login,
            'name' => $this->name,
            'surname' => $this->surname,
            'city' => $this->city,
            'role' => $this->role,
            'email' => $this->email,
            'subscribed' => $this->subscribed,
            'vk_id' => $this->vk_id
        ]);

        return $dataProvider;
    }

}