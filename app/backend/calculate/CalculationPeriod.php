<?php

namespace backend\calculate;

use frontend\models\Balance;
use frontend\models\Bill;
use frontend\models\Costs;

/**
 * Class Calculation
 */
class CalculationPeriod implements CalculationPeriodInterface
{
    const POSTPAY = 0;
    private $cost;
    private $payments;

    public function __construct(Costs $cost)
    {
        $this->cost = $cost;
    }

    /**
     * @return void
     */
    public function setPayment()
    {
        $this->payments = Bill::find()->where('client_id = :client_id', [':client_id' => $this->cost->client_id])
            ->andWhere('date_to >= :date_to', [':date_to' => time()])
            ->andWhere('type_id = :type_id', [':type_id' => self::POSTPAY])
            ->all();
    }

    /**
     * @param Bill $payment
     * @return array
     */
    public function getCostsPeriod(Bill $payment): array
    {
        return Costs::find()->where('client_id = :client_id', [':client_id' => $payment->client_id])
            ->andWhere('date_from >= :date_from', [':date_from' => $payment->date_from])
            ->andWhere('date_to <= :date_to', [':date_to' => $payment->date_to])
            ->all();
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function calculatePeriod(): bool
    {
        $this->setPayment();
        $costs_sum = 0;
        $payment_sum = 0;
        foreach ($this->payments as $payment) {
            $payment_sum += $payment->sum;
            if ($payment->type_id === 0) {
                foreach ($this->getCostsPeriod($payment) as $cost){
                    $costs_sum += $cost->sum;
                }
            }
        }

        $balance = $payment_sum - $costs_sum;
        $this->saveBalanceClient($this->cost->client_id, $balance);

        return true;
    }

    /**
     * @param int $client_id
     * @param int $sum
     * @return bool
     * @throws \Exception
     */
    public function saveBalanceClient(int $client_id, int $sum): bool
    {
        $transaction = Balance::getDb()->beginTransaction();
        try {
            $balance = Balance::findOne(['client_id' => $client_id]);
            if ($balance) {
                $balance->sum = $sum;
                $balance->save();
            } else {
                $balance = new Balance();
                $balance->client_id = $client_id;
                $balance->sum = $sum;
                $balance->save();
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw new \Exception('Системная ошибка' . $e->getMessage(), 400);
        } catch(\Throwable $e) {
            $transaction->rollBack();
            throw new \Exception('Системная ошибка' . $e->getMessage(), 400);
        }

        return true;
    }
}
