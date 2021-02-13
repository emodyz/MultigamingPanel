<?php


namespace App\Http\Controllers\Dashboard\Contracts;

// TODO: Handle Cashing
use Illuminate\Support\Collection;
abstract class DashboardStats
{
    public ?int $dailyDiff;
    public bool $isDailyDiffPositive;
    public Collection $graphData;
    public int $total;

    abstract public function setDailyDiff(): void;
    abstract public function setGraphData(): void;
    abstract public function setTotal(): void;

    public function __construct()
    {
        $this->setDailyDiff();
        $this->setGraphData();
        $this->setTotal();
    }
}
