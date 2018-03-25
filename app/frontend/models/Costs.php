<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "costs".
 *
 * @property int $id
 * @property int $client_id
 * @property int $date_from
 * @property int $date_to
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
            [['date_from', 'date_to',], 'string'],
            [['date_from', 'date_to', 'sum'], 'required'],
            [['date_from', 'date_to',], 'validateDate'],
            [['client_id', 'sum'], 'integer'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    public function validateDate()
    {
        if (!$this->isPayment()) {
            $this->addError('date_from', 'Для периода, нет оплаты или неверные даты периода');
            $this->addError('date_to', 'Для периода, нет оплаты или неверные даты периода');
        }

        if (!$this->checkPeriodCost()) {
            $this->addError('date_from', 'Расход уже существует');
            $this->addError('date_to', 'Расход уже существует');
        }
    }

    /**
     * @return bool
     */
    private function checkPeriodCost(): bool
    {
        $cost = $this::find()->where('client_id = :client_id', [':client_id' => $this->client_id])
            ->andWhere('date_to <= :date_from', [':date_from' => $this->date_from])
            ->andWhere('date_from >= :date_to', [':date_to' => $this->date_to])
            ->one();

        if (!$cost) {
            $cost = $this::find()->where('client_id = :client_id', [':client_id' => $this->client_id])
                ->andWhere('date_to >= :date_from', [':date_from' => $this->date_from])
                ->andWhere('date_from <= :date_to', [':date_to' => $this->date_to])
                ->one();
        }

        return $cost ? false : true;
    }

    /**
     * @return array|Bill|null|\yii\db\ActiveRecord
     */
    public function isPayment()
    {
        return Bill::find()->where('client_id = :client_id', [':client_id' => $this->client_id])
            ->andWhere('date_from <= :date_from', [':date_from' => $this->date_from])
            ->andWhere('date_to >= :date_to', [':date_to' => $this->date_to])
            ->one();
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
