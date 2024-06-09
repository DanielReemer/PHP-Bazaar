<?php

namespace App\Rules;

use App\Models\HiredProduct;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class valid_time implements ValidationRule
{
    private $start;
    private $end;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $hires = HiredProduct::where('advert_id', $attribute)->get();

        foreach ($hires as $hiredProduct) {
            if (($hiredProduct->from <= $this->end) && ($hiredProduct->to >= $this->start)) {
                $fail(self::message());
                return;
            }
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Product not available at given time';
    }
}
