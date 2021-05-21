<?php
include_once "./JString.php";

class JString2 extends JString
{

    public function reverse()
    {
        return $this->str = implode("", array_reverse($this->getChars()));
    }

    public function getChars($start = 0, $end = 0){
        $ret = array();
        $max = ($end > 0 && $end < $this->length() ) ? $end : $this->length();

        for($i = $start; $i < $max; $i++){
            $ret[] = parent::substring($i, $i+1);
        }

        return $ret;
    }


    public function insert($index = 0, $string = null){
        $objString = new JString2($string);
        $before = $index == 0 ? "" : parent::substring(0, $index);
        $after = parent::substring($index, $this->length());
        $this->str = $before.$objString.$after;
        return $this;
    }

    public function endsWith($string = null){
        $stringObj = new JString2($string);
        $revInput = $stringObj->reverse();
        $revOrig = parent::reverse();
        return $revOrig->startsWith($revInput);
    }

    public function lastIndexOf($string = null, $offset = 0){
        $stringObj = new JString2($string);
        $revInput = $stringObj->reverse();
        $revOrig = parent::reverse();
        $result = $revOrig->indexOf($revInput, $offset);
        if($result != -1){
            $ret = $revOrig->length() - 1 - $result;
        }else{
            $ret = $result;
        }
        return $ret;
    }

    public function substring($start = 0, $end = 0){
        $newStr = ($start == $end) ? "" : mb_substr($this->str, $start, ($end > 0) ? $end - $start : null);
        return $this->str = $newStr;
    }

    public function concat($string1 = null){
        return $this->str = $this->str.$this->getString($string1);
    }


    public function replace($what = null, $with = null){
        return $this->str = str_replace($this->getString($what), $this->getString($with), $this->str);
    }

    public function replaceNewLines($with = null) {
        return  $this->str = $this->replace("\r\n", $with)->replace("\r", $with)->replace("\n", $with) ;
    }

    public function trim(){
        return $this->str = trim($this->str);
    }

    public function toLowerCase(){
        return $this->str = mb_strtolower($this->str);
    }

    public function toUpperCase(){
        return $this->str = mb_strtoupper($this->str);
    }


    public function replaceFirst($what = null, $with = null){
        if($this->contains($what)){
            $objWhat = new JString2($what);
            $objWith = new JString2($with);

            $startIndex = $this->indexOf($objWhat);
            $endIndex = $startIndex + $objWhat->length();
            return $this->str = parent::substring(0, $startIndex) . $objWith . parent::substring($endIndex) ;
        }else{
            return $this;
        }
    }


    public function replaceLast($what = null, $with = null){
        $objWhat = new JString($what);
        $objWith = new JString($with);

        return $this->str = parent::reverse()->replaceFirst($objWhat->reverse(), $objWith->reverse())->reverse();
    }

    public function split($string = null){
        $rawString = $this->getString($string);
        $retRaw = $rawString != "" ? explode($rawString, $this->str) : array();
        $ret = array();
        foreach($retRaw as $current){
            $ret[] = new static($current);
        }
        return $ret;
    }


    public function htmlSpecialChars(){
        return $this->str = htmlspecialchars($this->str);
    }

    public function htmlSpecialCharsDecode(){
        return $this->str = htmlspecialchars_decode($this->str);
    }

    public function stripTags(){
        return $this->str = strip_tags($this->str);
    }

    public function stripSlashes(){
        return $this->str = stripslashes($this->str);
    }

    public function toCamelCase() {
        $ret = parent::toLowerCase();
        while(true) {
            $i = $ret->indexOf("_");
            if($i == -1) {
                break;
            }
            $before = $ret->substring(0, $i);
            $toUp = $i < $ret->length() - 1? $ret->charAt($i + 1)->toUpperCase() : "";
            $after = $ret->substring($i + 2);
            $ret = new JString($before . $toUp . $after);
        }
        return $this->str = $ret->str;
    }


    public function fromCamelCase() {
        $ret = new JString();
        $chars = $this->getChars();
        foreach ($chars as $currentChar) {
            if($currentChar->toLowerCase() == $currentChar) {
                $ret->append($currentChar);
            } else {
                $ret->append("_")->append($currentChar->toLowerCase());
            }
        }
        return $this->str = $ret->str;
    }


    public function trimTo($count) {
        if ($count >= $this->length()) {
            return $this;
        } else {
            $tmpString = parent::substring(0, $count);
            $index = $tmpString->lastIndexOf(" ");
            return $this->str = parent::substring(0, $index)->append(" ...");
        }
    }


    public function recursiveReplace($what, $to) {
        $result = new JString($this);
        if (!static::from($to)->contains($what)) {
            while ($result->contains($what)) {
                $result = $result->replace($what, $to);
            }
        }
        return $this->str = $result;
    }



}