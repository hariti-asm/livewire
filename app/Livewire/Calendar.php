<?php
namespace App\Livewire;

use Livewire\Component;

class Calendar extends Component
{
    public $year ;
    public $month ;
    public $selectedMonth;
    public $selectedYear;
    public $today;
    public $days =[];
    public $disabledMonth;

public function mount(){
$this->year =date('Y');
$this->month=date('m');
$this->today = date('d');
$this->selectedMonth = date('m');
$this->days =$this->getDaysInMonth();
$this->disableddMonth = date('m') -1;



}
    public function render()
    {
        return view('livewire.calendar');

    }

    public function next() {
        $this->year = date('Y');
        $this->selectedMonth = $this->selectedMonth + 1;

        if ($this->selectedMonth > 12) {
            $this->selectedMonth = 1;
            $this->year++;
        }

        $this->days = $this->getDaysInMonth();
    }

    public function previous() {
        $this->selectedMonth -= 1;

        if ($this->selectedMonth < 1) {
            $this->selectedMonth = 12;
            $this->year--;
        }

        $this->days = $this->getDaysInMonth();
    }


    private function getDaysInMonth()
    {
        $firstDay = $this->year . '-' . $this->selectedMonth . '-01';
        $dayOfWeek = date('w', strtotime($firstDay));
        $days = [];
        $percentage = 50;
        // Calculate how many days from the previous month need to be shown
        $daysInPrevMonth = date('t', strtotime('-1 month', strtotime($firstDay)));
        $prevMonthStart = $daysInPrevMonth - $dayOfWeek + 2;

        for ($i = $prevMonthStart; $i <= $daysInPrevMonth; $i++) {
            $days[] = ["day"=>$i,"month"=> $this->  selectedMonth -1];
        }

        $numberOfDays = date('t', strtotime($firstDay));

        for ($i = 1; $i <= $numberOfDays; $i++) {

            $days[] = ["day"=>$i,"month"=>$this->selectedMonth];

        }

        // Calculate how many days from the next month need to be shown
        $totalDays = count($days);
        $remainingCols = (7 - ($totalDays % 7)) % 7;

        // Fill in the remaining days from the next month
        $nextMonthDay = 1;
        for ($i = 1; $i <= $remainingCols; $i++) {
            $days[] = ["day"=>$i,"month"=>$this->selectedMonth+1];
            $nextMonthDay++;
        }

        // Add extra row of numbers from the next month
        for ($i = 1; $i <= 7; $i++) {
            $days[] = ["day"=>$nextMonthDay,"month"=>$this->selectedMonth +1];

            $nextMonthDay++;
        }
        foreach ($days as &$day) {
            $day['percentage'] = $percentage;
        }

        return $days;
    }
}
