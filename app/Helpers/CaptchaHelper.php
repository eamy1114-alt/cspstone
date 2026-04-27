<?php

namespace App\Helpers;

use Gregwar\Captcha\CaptchaBuilder;

class CaptchaHelper
{
    public static function generate()
    {
        $builder = new CaptchaBuilder;
        $builder->build();
        
        session(['captcha' => $builder->getPhrase()]);
        
        return $builder;
    }
    
    public static function validate($input)
    {
        $captcha = session('captcha');
        return strtolower($input) === strtolower($captcha);
    }
}