<?php

namespace jnpdev\Password;

interface PasswordInterface
{
    public static function create(String $string);

    public static function verify(String $string, String $expected);
}
