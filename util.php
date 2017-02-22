<?php

    function calculatePercantage($numerator, $denominator){
      return ($numerator / $denominator) * 100;
    }

    function dateDifference($date){
        $diff = strtotime($date) - time();
        if($diff > 0){
            return $diff;
        }
        else{
            return 0;
        }
    }

?>
