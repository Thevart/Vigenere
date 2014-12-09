<?php

namespace Crypto;

class VigenereTool {

    public static function toLower($str){
        $str = strtolower($str);
        return preg_replace('/[^\da-z]/i', '', $str);
    }

    public static function invertChar($char1, $char2){
        $ord1 = ord($char1)-96;
        $ord2 = ord($char2)-96;
        $letter = (($ord2+$ord1));
        if($letter-26 >0 ) {
            $letter = $letter-26;
        }
        $finalOrd = $letter+96;
        return chr($finalOrd);
    }

    public static function invertCharFromKey($char1, $char2){
        $ord1 = ord($char1)-96;
        $ord2 = ord($char2)-96;
        $finalOrd = (($ord2-$ord1)+26)%26+96;
        return chr($finalOrd);
    }

    public static function encryptVigenere($key, $plaintext){
        $key = self::toLower($key);
        $plaintext = self::toLower($plaintext);
        $plaintextArray = str_split($plaintext);
        $keyArray = str_split($key);
        $encrypt = '';
        for($i=0; $i<count($plaintextArray); $i++){
            $newChar = self::invertChar($keyArray[$i%count($keyArray)],$plaintextArray[$i]);
            $encrypt =  $encrypt.$newChar;
        }
        return $encrypt;
    }

    public static function decryptVigenere($key, $encrypted){
        $encryptedArray = str_split($encrypted);
        $keyArray = str_split($key);
        $plaintext = '';
        for($i=0; $i<count( $encryptedArray); $i++){
            $newChar = self::invertCharFromKey($keyArray[$i%count($keyArray)], $encryptedArray[$i]);
            $plaintext =  $plaintext.$newChar;
        }
        return $plaintext;
    }

    public static function getKeyFromProbableWord($str, $probableWord, $pos)
    {
        $seq = substr($str,$pos, strlen($probableWord));
        return self::decryptVigenere($probableWord, $seq);
    }

    public static function getAllPossibleKey($str, $probableWord)
    {
        $possibleKeys = array();

        for($i=0; $i<strlen($str)-strlen($probableWord); $i++)
        {
            $possibleKeys[] = self::getKeyFromProbableWord($str, $probableWord, $i);
        }
        return $possibleKeys;
    }

    public static function cleanUselessRepetitions($sequences){
        $factors = array();
        $goodOccurences = array();
        $newSequencesArray = array();
        foreach($sequences as $seq){
            foreach($seq['length'] as $distance){
                $seq['factors'][] = self::getFactors($distance);
                $factors[] = self::getFactors($distance);
            }
            $newSequencesArray[] = $seq;
        }
        foreach($newSequencesArray as $seq){
            foreach($seq['factors']  as $fac){
                $count = 0;
                foreach($factors as $secFac){
                    if(array_intersect($fac, $secFac)) $count++;
                }
                if($count > 1){
                    $goodOccurences[] = $seq;
                }
            }
        }
        return ($goodOccurences);
    }

    public static function getFactors($n){

        $listFactors = array();

        for($i=3; $i<$n; $i++)
        {
            if($n%$i == 0){
                $listFactors[] = $i;
            }
        }
        return $listFactors;
    }
    public static function getRepeatedSequence($str)
    {
        $strArray = str_split($str);
        $countSeq = array();
        for($k=3 ; $k<10; $k++){
            for($i = 0; $i<= count($strArray)-$k; $i++ )
            {
                $seq = '';
                for($l=0; $l<$k; $l++)
                {
                    $seq.=$strArray[$i+$l];
                }
                $count = substr_count($str, $seq);
                if($count >1)
                {
                    $posArray = array();
                    $pos = strpos($str, $seq);
                    $length = null;

                    while($pos !== FALSE )
                    {
                        if($length != null){
                            array_push($posArray, $length);
                        }
                        $length = strpos($str, $seq, $pos+1) - $pos;
                        $pos = strpos($str, $seq, $pos+1);

                    }
                    $countSeq[$seq] = array( 'occurence'=>$seq, 'count' => $count, 'length' => $posArray);
                }
            }
        }

        return ($countSeq);

    }

}
