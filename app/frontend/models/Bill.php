<?php

namespace frontend\models;

use DatePeriod;
use DateTime;
use Yii;

/**
 * This is the model class for table "bill".
 *
 * @property int $id
 * @property int $client_id
 * @property int $type_id
 * @property int $date_from
 * @property int $date_to
 * @property int $sum
 *
 * @property Client $client
 */
class Bill extends \yii\db\ActiveRecord
{
    private $params_days = [
        ['interval' => 'P5D', 'start_date' => 'now', 'end_date' => '+ 6 day', 'pay_type' => 0],
        ['interval' => 'P5D', 'start_date' => '+ 5 day', 'end_date' => '+ 6 day', 'pay_type' => 3],
        ['interval' => 'P4D', 'start_date' => '+ 11 day', 'end_date' => '+ 99 day', 'pay_type' => 1],
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bill';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_from', 'date_to',], 'string'],
            [['date_from', 'date_to', 'sum', 'type_id'], 'required'],
            [['date_from', 'date_to',], 'validateDate'],
            [['client_id', 'type_id', 'sum'], 'integer'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    /**
     * @throws \Exception
     */
    public function validateDate()
    {
        $date_from = new DateTime();
        $date_from->setTimestamp($this->date_from);

        $date_to = new DateTime();
        $date_to->setTimestamp($this->date_to);

        $from = false;
        $to = false;
        foreach ($this->params_days as $param) {
            $start_date = new DateTime($param['start_date']);
            $end_date = new DateTime($param['end_date']);
            $period = new DatePeriod($start_date, new \DateInterval($param['interval']), $end_date);
            foreach ($period as $key => $data) {
                if ($data->format('d-m-Y') === $date_from->format('d-m-Y')) {
                    $from = true;
                }

                if ($data->format('d-m-Y') === $date_to->format('d-m-Y')) {
                    $to = true;
                }
            }

            if ($from && $to) {
                if (!$this->isAlreadyPayment($date_from->getTimestamp(), $date_to->getTimestamp())) {
                    $this->addError('type_id', 'У клиента уже есть счет для этого периода');
                } elseif (!$this->validatePayType($param['pay_type'])) {
                    $this->addError('type_id', 'Неверный тип оплаты для периода');
                }

                break;
            }
        }

        if (!$from) {
            $this->addError('date_from', 'Неверная дата начала платежа');
        } elseif (!$to) {
            $this->addError('date_to', 'Неверная дата завершения платежа');
        }
    }

    /**
     * @param int $date_from
     * @param int $date_to
     * @return bool
     */
    private function isAlreadyPayment(int $date_from, int $date_to): bool
    {
        $payment = $this::findOne([
            'client_id' => $this->client_id,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to
        ]);

        return is_null($payment) ? true : false;
    }

    /**
     * @param int $pay_type
     * @return bool
     */
    private function validatePayType(int $pay_type): bool
    {
        $result = false;
        if ($pay_type == $this->type_id || $pay_type === 3) {
            $result = true;
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'type_id' => 'Type ID',
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
