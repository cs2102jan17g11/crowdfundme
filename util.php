<?php

    function calculatePercantage($numerator, $denominator){
      return ($numerator / $denominator) * 100;
    }

    function dateDifference($date){
        $diff = floor((strtotime($date) - time())/(86400));
        if($diff > 0){
            return $diff;
        }
        else{
            return 0;
        }
    }

?>
