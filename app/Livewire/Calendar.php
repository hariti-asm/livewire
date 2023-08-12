<?php
namespace App\Livewire;

use Livewire\Component;

class Calendar extends Component
{
    public $year = "2023";

    public $selectedMonth;
    public $selectedYear;
    public $today;
    public $month = "Auguest";
     public $monthNumber ;



    public function render()
    {
        return view('livewire.calendar', [
            'year' => $this->year,
            'month' => $this->month,
            'days' => $this->getDaysInMonth(),
            'today' => $this->today = date('d'),
            'monthNumber'=>  $this->monthNumber = date('m', strtotime($this->month . ' 1'))
        ]);
    }



    private function getDaysInMonth()
    {
        $firstDay = $this->year . '-' . (int)$this->monthNumber. '-01';
        $dayOfWeek = date('w', strtotime($firstDay));
        $days = [];
        // Calculate how many days from the previous month need to be shown
        $daysInPrevMonth = date('t', strtotime('-1 month', strtotime($firstDay)));
        $prevMonthStart = $daysInPrevMonth - $dayOfWeek + 2;

        for ($i = $prevMonthStart; $i <= $daysInPrevMonth; $i++) {
            $days[] = ["day"=>$i,"month"=>(int)$this->monthNumber -1];
        }

        $numberOfDays = date('t', strtotime($firstDay));

        for ($i = 1; $i <= $numberOfDays; $i++) {

            $days[] = ["day"=>$i,"month"=>(int)$this->monthNumber];

        }

        // Calculate how many days from the next month need to be shown
        $totalDays = count($days);
        $remainingCols = (7 - ($totalDays % 7)) % 7;

        // Fill in the remaining days from the next month
        $nextMonthDay = 1;
        for ($i = 1; $i <= $remainingCols; $i++) {
            $days[] = ["day"=>$i,"month"=>(int)$this->monthNumber +1];
            $nextMonthDay++;
        }

        // Add extra row of numbers from the next month
        for ($i = 1; $i <= 7; $i++) {
            $days[] = ["day"=>$nextMonthDay,"month"=>(int)$this->monthNumber +1];

            $nextMonthDay++;
        }

        return $days;
    }
}
