<?php

namespace App\Helpers;

class OtpHelper
{
    public static function generateOtp()
    {
        return 'FIT-' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
    }
}
