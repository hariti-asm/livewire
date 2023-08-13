<?php
namespace App\Livewire;

use Livewire\Component;

class Calendar extends Component
{
    public $year = "2023";
    public $month = 8;
    public $selectedMonth;
    public $selectedYear;
    public $today;
    // public $month = "September";
     public $monthNumber ;



    public function render()
    {
        return view('livewire.calendar', [
            'year' => $this->year,
            'month' => $this->month,
            'days' => $this->getDaysInMonth(),
            'today' => $this->today = date('d'),
            'monthNumber'=>  $this->monthNumber = date('m', strtotime($this->month . ' 1')) ,
              'selectedMonth' =>$this->selectedMonth = date('m', strtotime($this->month . ' 1'))
        ]);
    }
    public function onMount()
    {
        // Set the initial month and year values
        $this->month = date('F');
        $this->year = date('Y');

        // Set the selected month and year to the initial
        $this->selectedMonth = $this->month;
        $this->selectedYear = $this->year;
    }

    public function Next()
    {
        $this->selectedMonth = date('F', strtotime($this->selectedMonth . ' +1 month'));
    }

    public function Previous()
    {
        $this->selectedMonth = date('F', strtotime($this->selectedMonth . ' -1 month'));
    }




    private function getDaysInMonth()
    {
        $firstDay = $this->year . '-' . (int)$this->monthNumber. '-01';
        $dayOfWeek = date('w', strtotime($firstDay));
        $days = [];
        $percentage = "50%";
        // Calculate how many days from the previous month need to be shown
        $daysInPrevMonth = date('t', strtotime('-1 month', strtotime($firstDay)));
        $prevMonthStart = $daysInPrevMonth - $dayOfWeek + 2;

        for ($i = $prevMonthStart; $i <= $daysInPrevMonth; $i++) {
            $days[] = ["day"=>$i,"month"=>$this->month -1];
        }

        $numberOfDays = date('t', strtotime($firstDay));

        for ($i = 1; $i <= $numberOfDays; $i++) {

            $days[] = ["day"=>$i,"month"=>$this->month];

        }

        // Calculate how many days from the next month need to be shown
        $totalDays = count($days);
        $remainingCols = (7 - ($totalDays % 7)) % 7;

        // Fill in the remaining days from the next month
        $nextMonthDay = 1;
        for ($i = 1; $i <= $remainingCols; $i++) {
            $days[] = ["day"=>$i,"month"=>$this->month +1];
            $nextMonthDay++;
        }

        // Add extra row of numbers from the next month
        for ($i = 1; $i <= 7; $i++) {
            $days[] = ["day"=>$nextMonthDay,"month"=>$this->month +1];

            $nextMonthDay++;
        }
        foreach ($days as &$day) {
            $day['percentage'] = $percentage;
        }

        return $days;
    }
}
