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

class DateValidator {
    private const REGEX_DATE = '/\d{2}\/\d{2}\/\d{4}/';

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
