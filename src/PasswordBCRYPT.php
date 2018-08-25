<?php

namespace Jnicolau\Password;

class PasswordBCRYPT implements PasswordInterface
{
    public static function create(String $password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    public static function verify(String $password, String $hash)
    {
        return password_verify($password, $hash);
    }

    public static function isConsecutive(String $password)
    {
        $counter = 1;
        $split = $password;
        foreach (str_split($split) as $index => $char) {
            $current = ord($char);

            if ($index > 0 && $current == $last + 1) {
                $counter++;
                
                if ($counter == strlen($password)) {
                    return true;
                }
            }
            $last = $current;
        }
        
        return false;
    }

    public static function isValid(String $password)
    {
        return preg_match('(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$', $password);
    }

    public static function isInsecure(String $password)
    {
        try {
            $list = file_get_contents('https://raw.githubusercontent.com/mozilla/fxa-password-strength-checker/master/source_data/10_million_password_list_top_10000.txt');
        } catch (Exception $e) {
            die('no insecure password list');
        }

        $pattern = preg_quote($password, '/');
        if (preg_match_all("/^.*$pattern.*\$/m", $list, $matches)) {
            return $matches;
        } else {
            return false;
        }
    }
}
