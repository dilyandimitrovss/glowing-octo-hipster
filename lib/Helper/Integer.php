<?php
namespace Helper;

class Integer
{
    public static function isPrime($int)
    {
        // 1 is not prime
        if($int == 1) {
            return false;
        } elseif($int == 2) {
            // only even prime
            return true;
        }

        // square root speeds up testing of bigger prime numbers
        $x = floor(sqrt($int));
        for($i = 2; $i <= $x; ++$i) {
            if($int % $i == 0) {
                break;
            }
        }

        if($x == $i - 1) {
            return true;
        }

        return false;
    }
}