<?php declare(strict_types=1);


namespace App\Http\Controller;
use Swoft\Context\Context;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;


/**
 * Class UserController
 * @package App\Http\Controller
 * @Controller()
 */
class UserController
{
    /**
     * @RequestMapping("index")
     */
    public function index()
    {
        $request = Context::mustGet()->getRequest();

        $response = Context::mustGet()->getResponse();
        $response->withData(['a' => 10]);

        return $response;
    }
}