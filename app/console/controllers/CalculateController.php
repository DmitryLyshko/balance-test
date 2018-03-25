<?php

namespace console\controllers;

use backend\calculate\CalculateDate;
use DateTime;
use yii\console\Controller;

/**
 * Class CalculateController
 * @package app\commands
 */
class CalculateController extends Controller
{
    public $message;

    public function options($actionID)
    {
        return ['message'];
    }

    public function optionAliases()
    {
        return ['m' => 'message'];
    }

    /**
     * @param string $date_from
     * @param string $date_to
     * @return int
     * @throws \Exception
     */
    public function actionIndex(string $date_from, string $date_to): int
    {
        $date_from = new DateTime($date_from);
        $date_to = new DateTime($date_to);
        $calculate_date = new CalculateDate($date_from->getTimestamp(), $date_to->getTimestamp());
        $res = $calculate_date->calculateClients();
        echo 'Обновлено : ' . $res . "\n";
        return 1;
    }
}
