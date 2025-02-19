<?php
use NumberToWords\NumberToWords;
use Carbon\Carbon;


    function numberToWord($digit)
    {
        
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('en'); 
        $inWords = $numberTransformer->toWords($digit); // outputs "five thousand one hundred twenty"
        return $inWords;       
    }

    function todayDate()
    {
        $date = Carbon::now()->format('Y-m-d');
        return  $date;
    }
    
    function oneMonthBeforeDate(){
        $date = Carbon::now()->subMonths(1)->format('Y-m-d');
        return $date;
    }

    function numberFormat($numF){
        $numberFormat = number_format($numF,2);
        return $numberFormat ;
    }

       