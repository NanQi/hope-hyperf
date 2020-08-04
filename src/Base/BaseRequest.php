<?php

declare(strict_types=1);

namespace NanQi\Hope\Base;

use Hyperf\Validation\Request\FormRequest;

abstract class BaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
}
