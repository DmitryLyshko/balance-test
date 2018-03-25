<?php

namespace backend\calculate;

use frontend\models\Bill;
use frontend\models\Client;
use frontend\models\Costs;

/**
 * Class CalculateDate
 * @package backend\calculate
 */
class CalculateDate extends CalculationPeriod implements CalculateDateInterface
{
    private $date_from;
    private $date_to;

    public function __construct(int $date_from, int $date_to)
    {
        $this->date_to = $date_to;
        $this->date_from = $date_from;
    }

    /**
     * @return array
     */
    public function getClients(): array
    {
        return Client::find()->all();
    }

    /**
     * @param int $client_id
     * @return int
     */
    public function getClientCosts(int $client_id): int
    {
        $sum = 0;
        $costs = Costs::find()->where('client_id = :client_id', [':client_id' => $client_id])
            ->andWhere('date_to >= :date_from', [':date_from' => $this->date_from])
            ->andWhere('date_from <= :date_to', [':date_to' => $this->date_to])
            ->all();

        foreach ($costs as $cost) {
            $sum += $cost->sum;
        }

        return $sum;
    }

    /**
     * @param int $client_id
     * @return int
     */
    public function getClientBills(int $client_id): int
    {
        $sum = 0;
        $bills = Bill::find()->where('client_id = :client_id', [':client_id' => $client_id])
            ->andWhere('date_to >= :date_from', [':date_from' => $this->date_from])
            ->andWhere('date_from <= :date_to', [':date_to' => $this->date_to])
            ->all();

        foreach ($bills as $bill) {
            $sum += $bill->sum;
        }

        return $sum;
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function calculateClients(): int
    {
        $res = 0;
        foreach ($this->getClients() as $client) {
            $costs = $this->getClientCosts($client->id);
            $bills = $this->getClientBills($client->id);
            $balance = $bills - $costs;
            $this->saveBalanceClient($client->id, $balance);
            $res++;
        }

        return $res;
    }
}
