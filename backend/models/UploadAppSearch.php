<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UploadApp;

/**
 * UploadAppSearch represents the model behind the search form about `backend\models\UploadApp`.
 */
class UploadAppSearch extends UploadApp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auto_id','upload_id'], 'integer'],
            [['upload_apk', 'app_description', 'appsname', 'app_version', 'create_date', 'update_date'], 'safe'],
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
        $query = UploadApp::find()->orderBy(['update_date'=>SORT_DESC])
        ->joinWith(['lead']);
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
           'upload_id' =>$this->upload_id,
           'apps_management.auto_id' =>$this->appsname,
        ]);

        $query->andFilterWhere(['like', 'upload_apk', $this->upload_apk])
            ->andFilterWhere(['like', 'app_description', $this->app_description])
            ->andFilterWhere(['like', 'app_version', $this->app_version])
             ->andFilterWhere(['like', 'create_date', $this->create_date])
              ->andFilterWhere(['like', 'update_date', $this->update_date]);
           // ->andFilterWhere(['like', 'apps_management.apps_name', $this->appsname]);

        return $dataProvider;
    }
}
