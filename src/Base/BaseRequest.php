<?php

declare(strict_types=1);

namespace NanQi\Hope\Base;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Validation\Request\FormRequest;
use NanQi\Hope\Helper;

abstract class BaseRequest extends FormRequest
{
    use Helper;

    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    public function authorize(): bool
    {
        return true;
    }
}
