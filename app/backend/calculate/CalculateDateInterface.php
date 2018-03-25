<?php

namespace backend\calculate;

/**
 * Class CalculateDateInterface
 * @package backend\calculate
 */
interface CalculateDateInterface
{
    /**
     * @return array
     */
    public function getClients(): array;

    /**
     * @param int $client_id
     * @return int
     */
    public function getClientCosts(int $client_id): int;

    /**
     * @param int $client_id
     * @return int
     */
    public function getClientBills(int $client_id): int;

    /**
     * @return int
     */
    public function calculateClients(): int;
}
