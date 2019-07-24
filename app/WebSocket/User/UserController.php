<?php


namespace App\WebSocket\User;


use App\Model\Dao\UserDao;
use Swoft\Http\Message\Request;
use Swoft\Redis\Redis;
use Swoft\Session\Session;
use Swoft\WebSocket\Server\Annotation\Mapping\MessageMapping;
use Swoft\WebSocket\Server\Annotation\Mapping\WsController;

/**
 * Class UserController
 * @package App\WebSocket\User
 * @WsController()
 */
class UserController
{

    /**
     * @param Request $request
     * @param int $fd
     * @MessageMapping()
     * @return array
     */
    public function login($data)
    {
        $requestData = json_decode($data, true);
        //TODO:: token 验证
        $userId = $requestData['user_id'];
        $fd = Session::mustGet()->getRequest()->getFd();

        Redis::hSet('rt-user-fd', 'user-id-' . $userId, $fd);
        Redis::hSet('rt-user-id', 'user-fd-' . $fd, $userId);

        return [
            'result' => [
                'code' => 0,
                'msg' => "success",
                'data' => []
            ]
        ];
    }

    /**
     * @MessageMapping()
     */
    public function loginList($data)
    {
        $requestData = json_decode($data, true);
        $userId = $requestData['user_id'];

        $userDao = new UserDao();
        $userDao->setReturnQuery(true);
        $users = $userDao->getLoginUsers()
            ->where('id', '<>', $userId)
            ->paginate(intval(1), 20);

        return [
            'result' => [
                'code' => 0,
                'msg' => "success",
                'data' => $users
            ]
        ];
    }
}