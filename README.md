## 安装部署

```
composer require edoctor/ecs-phpsdk
```
## 使用说明

#### 接入通用项目

```php
use Redis;
use eDoctor\Phpecs\Phpecs;
use eDoctor\Phpecs\Request\User\Login as UserLogin;

$redis = new Redis();
$redis->connect('127.0.0.1', '6379');

$config = [
    'api_server'    => '',
    'api_key'       => '',
    'api_secret'    => '',
    'request_timeout'   => 60
];
$phpecs = new Phpecs($config, $redis);

$userLogin = new UserLogin($phpecs);
$userLogin->setRoleId(1);
$userLogin->setAuthMethod('mobile');
$userLogin->setMobile('13300002222');
$userLogin->setPassword('123456');
$userLogin->setPlatform('android');

$response = $userLogin->getResponse();
```



#### For Laravel:

**编辑 config/app.php 在 providers 数组追加:**

```php
eDoctor\Phpecs\PhpecsProvider::class,
```
**发布配置文件到 config/phpecs.php**

```shell
php artisan vendor:publish --provider="eDoctor\Phpecs\PhpecsProvider" --tag=config
```
**在 .env 文件中增加配置选项, 它会被自动调用**

```ini
ECS_API_SERVER=
ECS_API_KEY=
ECS_API_SECRET=
ECS_REQUEST_TIMEOUT=60
```
```
当然也可以直接修改 config/phpecs.php (不推荐)
```
**在控制器中实现自动注入**

```php
class UserController extends Controller
{
    public function login(Request $request, Phpecs $phpecs)
    {
        $ecs = new Login($phpecs);
        $ecs->setRoleId(1);
        $ecs->setAuthMethod('mobile');
        $ecs->setMobile($request->input('mobile'));
        $ecs->setPassword($request->input('password'));
        $ecs->setPlatform('windows');
        $response = $ecs->getResponse();
        
        dd($response);
    }
}
```

# 接口列表
整理中...
(可参照IDE自动提示)

# 技术支持
weipeng.wen@edoctor.cn