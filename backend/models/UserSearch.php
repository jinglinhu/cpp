<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\User;
use backend\models\Organization;


/**
 * UserSearch represents the model behind the search form about `backend\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','status'], 'integer'],
            [['username', 'auth_key','oid','password_hash', 'password_reset_token', 'email', 'created_at','realname','position','mobile','updated_at',], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find()->andFilterWhere(['oid'=>Organization::getChildren(Yii::$app->user->identity->oid)]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            // 'pagination' => array('pageSize' => 10),
        ]);
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            //'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])

            ->andFilterWhere(['like', 'realname', $this->realname])

            ->andFilterWhere(['like', 'position', $this->position])

            ->andFilterWhere(['like', 'mobile', $this->mobile])

            ->andFilterWhere(['>', 'created_at', strtotime($this->created_at)])
            ->andFilterWhere(['>', 'updated_at', strtotime($this->updated_at)]);

            if($this->oid){
                $query->andFilterWhere(['oid'=>Organization::getChildren($this->oid)]);
            }

        return $dataProvider;
    }
}
