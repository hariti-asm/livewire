<?php
namespace App\Livewire;

use Livewire\Component;

class Calendar extends Component
{





public $year;
public $selectedMonth;
public $selectedMonthName; // New property to hold month abbreviation
public $today;
public $days = [];
public $month ;
public $clickedDay =null;
public $percentage ;

public function mount()
{
    $this->year = date('Y');
    $this->today = date('d');
    $this->selectedMonth = date('n'); // Use numerical month value (1-12)
    $this->selectedMonthName = date('M'); // Set the initial month abbreviation
    $this->days = $this->getDaysInMonth();
    $this->month = date('n');
    $this->clickedDay = null;
    $this->percentage = "-50%";
}
    public function render()
    {
        return view('livewire.calendar');

    }



    public function next()
    {
        $this->selectedMonth = $this->selectedMonth + 1;

        if ($this->selectedMonth > 12) {
            $this->selectedMonth = 1;
            $this->year++;
        }

        $this->selectedMonthName = date('M', mktime(0, 0, 0, $this->selectedMonth, 1)); // Update month abbreviation
        $this->days = $this->getDaysInMonth();
    }


    public function previous()
    {
        $currentYear = date('Y');
        $currentMonth = date('n'); // numerical month value (1-12)

        if ($this->year > $currentYear || ($this->year == $currentYear && $this->selectedMonth > $currentMonth)) {
            $this->selectedMonth--;

            if ($this->selectedMonth < 1) {
                $this->selectedMonth = 12;
                $this->year--;
            }

            $this->selectedMonthName = date('M', mktime(0, 0, 0, $this->selectedMonth, 1)); // Update month abbreviation
            $this->days = $this->getDaysInMonth();
        }
    }



    public function dayClicked($day){

        $this->dayClicked =$day;
    }


    private function getDaysInMonth()
    {
        $firstDay = $this->year . '-' . $this->selectedMonth . '-01';
        $dayOfWeek = date('w', strtotime($firstDay));
        $days = [];
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


        return $days;
    }

}
