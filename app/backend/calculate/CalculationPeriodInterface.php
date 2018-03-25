<?php

namespace backend\calculate;

use frontend\models\Bill;

/**
 * Interface CalculationInterface
 * @package backend\models
 */
interface CalculationPeriodInterface
{
    public function setPayment();

    /**
     * @param Bill $payment
     * @return array
     */
    public function getCostsPeriod(Bill $payment): array;

    /**
     * @return bool
     */
    public function calculatePeriod(): bool;

    /**
     * @param int $client_id
     * @param int $sum
     * @return bool
     */
    public function saveBalanceClient(int $client_id, int $sum): bool;
}
