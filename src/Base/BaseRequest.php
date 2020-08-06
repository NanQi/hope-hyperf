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

    public function inputString(string $key, $default = null) : string
    {
        return (string)$this->input($key, $default);
    }

    public function inputInt(string $key, $default = null) : int
    {
        return (int)$this->input($key, $default);
    }

    public function inputArray(string $key, $default = null) : array
    {
        return (array)$this->input($key, $default);
    }

    public function inputObject(string $key, $default = null) : object
    {
        return (object)$this->input($key, $default);
    }
}
