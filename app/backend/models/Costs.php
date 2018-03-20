<?php

namespace app\models;

use frontend\models\Client;
use Yii;

/**
 * This is the model class for table "costs".
 *
 * @property int $id
 * @property int $client_id
 * @property string $date_from
 * @property string $date_to
 * @property int $sum
 *
 * @property Client $client
 */
class Costs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'costs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'sum'], 'integer'],
            [['date_from', 'date_to', 'sum'], 'required'],
            [['date_from', 'date_to'], 'safe'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    public function dateToTimestamp($data = []): array
    {
        if ($data !== []) {
            foreach ($data['Costs'] as $key => $val) {
                if ($key === 'date_from' || $key === 'date_to') {
                    $date_time = new \DateTime($data['Costs'][$key]);
                    $data['Costs'][$key] = $date_time->getTimestamp();
                }
            }
        }

        return $data;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'date_from' => 'Date From',
            'date_to' => 'Date To',
            'sum' => 'Sum',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }
}
