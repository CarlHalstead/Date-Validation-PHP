<?php
class ValidatedDate{
    private $isValid = false;

    function __construct($isValid){
        $this->isValid = $isValid;
    }
    
    function isValid(){
        return $this->isValid;
    }

    function getMessage(){
        if($this->isValid)
            return "This date has been successfully validated";
        else
            return "This date has failed validation";
    }
}

/**
 * If we were unable to use checkdate for whatever reason
 * then the way I would process the date as follows:
 * 
 * 1) Array of days in each month. e.g
 * 
 * $daysInMonths = [
 *      1 => 31,
 *      2 => 28...
 * ];
 * 
 * 2) Validate user input using regex
 * 3) Split input into the day, month and year
 * 4) Ensure month is in the range 1 -> 12
 * 5) Ensure day is in the range 1 -> $daysInMonth[month] (+1 if April and a leap year)
 * 6) Ensure year is in range (e.g. only allow dates in the past) 
 */ 
class DateValidator {

    /**
     * I intend to keep this regex quite simple with it only checking that there
     * are the correct number of digits in the correct format seperated by a slash. 
     * Whether those digits are in range or not I leave to PHPs checkdate method.
     */ 
    private const REGEX_DATE = '/^\d{2}\/\d{2}\/\d{4}$/';

    static function validateHistoricalDate($date){
        $isValid = preg_match(self::REGEX_DATE, $date);

        if($isValid){
            $parts = explode("/", $date);

            $day = $parts[0];
            $month = $parts[1];
            $year = $parts[2];

            $isValid = checkdate($month, $day, $year);
        }

        return new ValidatedDate($isValid);
    }
}

$dateString = "03/12/1999";
$result = DateValidator::validateHistoricalDate($dateString);

echo $result->isValid();
echo "\r\n";
echo $result->getMessage();
?>
