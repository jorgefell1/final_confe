<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Company;

class UniqueCompanyRule implements ValidationRule
{
    protected $companyId;

    public function __construct($companyId = null)
    {
        $this->companyId = $companyId;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = Company::where('ruc', $value)
                        ->where('user_id', auth()->id());

        if ($this->companyId) {
            $query->where('id', '!=', $this->companyId);
        }

        if ($query->exists()) {
            $fail('El RUC ya está registrado para este usuario.');
        }
    }
}