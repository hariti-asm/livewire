<?php

namespace App\Livewire;

use Livewire\Component;

class Calendar extends Component
{
    public $year ="2023" ;
    public $month ="February" ;

    public function render()
    {

        return view('livewire.calendar',[
            'year' => $this->year,
            'month' =>$this->month,
            'days' => $this->getDaysInMonth()
        ]

        );
    }
    private function getDaysInMonth(){

$firstDay = $this->year .'-' .$this->month . '-01';
$dayOfWeek = date('w',strtotime($firstDay));
$days = [];
for($i =0 ;$i < $dayOfWeek -1; $i =$i +1){
    $days[] = '';
}
$numberOfDays = date('t',strtotime($firstDay));
for($i =0 ;$i < $numberOfDays -1; $i =$i +1){
    $days[] = ($i +1);
}

$lastDay = $this->year . '-' . $this->month . '-' . $numberOfDays;
$lastDayOfWeek = date('w',strtotime($lastDay));
$colsToAdd = 7 -$lastDayOfWeek;
for($i =0 ;$i < $colsToAdd; $i =$i +1){

$days[] ='';
}
        return $days;

    }
}







