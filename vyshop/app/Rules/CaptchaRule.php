<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use ReCaptcha\ReCaptcha;
class CaptchaRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $recaptcha = new ReCaptcha(env('CAPTCHA_SECRET')); //đến file env lấy CAPTCHA_SECRET
        $response = $recaptcha->verify($value, $_SERVER['REMOTE_ADDR']); //verify là hàm trong recaptcha.php kiểm tra domain là localhost
        //REMOTE_ADDR lấy địa chỉ source mình
        return $response->isSuccess();

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Vui lòng xác nhận captcha';	
        //trả về thông báo khi lỗi không xác nhận captcha

    }
}
