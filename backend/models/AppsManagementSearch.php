<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AppsManagement;

/**
 * AppsManagementSearch represents the model behind the search form about `backend\models\AppsManagement`.
 */
class AppsManagementSearch extends AppsManagement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auto_id', 'apps_logo'], 'integer'],
            [['apps_name', 'apps_description','company_name','company_logo', 'create_date', 'update_date'], 'safe'],
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
        $query = AppsManagement::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'auto_id' => $this->auto_id,
         'apps_logo' => $this->apps_logo,

        ]);

        $query
           /* ->andFilterWhere(['like', 'apps_logo', $this->apps_logo])*/
            ->andFilterWhere(['like', 'apps_name', $this->apps_name])
            ->andFilterWhere(['like', 'apps_description', $this->apps_description])
            ->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'company_logo', $this->company_logo])
            ->andFilterWhere(['like', 'create_date', $this->create_date])
            ->andFilterWhere(['like', 'update_date', $this->update_date]);

        return $dataProvider;
    }
}
