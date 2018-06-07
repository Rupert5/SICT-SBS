<?php
abstract class Validate{
    public static function uname($uname,&$err,$required=false,$min=1,$max=20){
        $uname = Text::antiWhiteSpace($uname);
        if(empty($uname)){
            if($required){$err="field required";}
            return !$required;
        }
        if(Text::isNamePlus($uname,$min,$max)!== "success"){            $err = Text::isNamePlus($uname,$min,$max);return false;}
        if(!Text::isAlphabet($uname[0])){$err="nust begin with alphabet";return false;}
        if(Text::isSymbol($uname)){$err="must have no symbols";return false;}
        return true;
    }
    
    public static function umail($umail,&$err,$required=false){
        $umail = trim($umail);
        if(empty($umail)){
        if($required){$err="field required";}
            return !$required;
        }
        if(!Text::isEmail($umail)){$err="email address"; return false;}
        return true;
    }
    
    public static function phone($phone,&$err,$required=false,$digits=10){
        $phone = trim($phone);
        if(empty($phone)){
            if($required){$err="field required";}
            return !$required;
        }
        if(!Text::isInt($phone)){$err="use only digits";return false;}
        if(strlen($phone) !== $digits){$err="use exactly $digits digits";return false;}
        return true;
    }
    
    public static function pname($name,&$err,$required=false,$min=1,$max=20){
        if(empty($name)){
            if($required){$err="field required";}
            return !$required;
        }
        if(Text::isNamePlus($name,$min,$max)!== "success"){            $err = Text::isNamePlus($name,$min,$max);return false;}
        return true;
    }
    
    public static function passwd($passwd,&$err,$length=8){
        if(empty($passwd)){$err="password empty";return false;}
        for($i=0;$i<strlen($passwd);$i++){
            if(ord($passwd[$i]) >= 65 && ord($passwd[$i]) <= 90){                break;}
            if($i === strlen($passwd)-1){$err="uppercase char not found";return false;}
        }
        for($i=0;$i<strlen($passwd);$i++){
            if(ord($passwd[$i]) >= 97 && ord($passwd[$i]) <= 122){                break;}
            if($i === strlen($passwd)-1){$err="lowercase char not found";return false;}
        }
        for($i=0;$i<strlen($passwd);$i++){
            if(ord($passwd[$i]) >= 48 && ord($passwd[$i]) <= 57){                break;}
            if($i === strlen($passwd)-1){$err="numeric not found";return false;}
        }
        if(!Text::isSymbol($passwd)){$err="no symbols found";return false;}
        if(strlen($passwd) < $length){$err="length below $length chars";return false;}
        return true;
    }
}