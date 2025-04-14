<?php
namespace App\Exceptions;

use Illuminate\Http\Request;
use App\Services\ApiResponseService;

class PublicException extends \Exception implements \Throwable
{
    public function __construct(string $message, int $code = 500)
    {
        parent::__construct($message, $code);
    }
    public function render(Request $request)
    {
        return ApiResponseService::error($this->getMessage(), $this->getCode());
    }
}
