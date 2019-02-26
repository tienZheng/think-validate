<h1 align="center"> think-validate </h1>

<p align="center"> ThinkPhp5 验证数据扩展包.</p>

## 项目简介
此扩展包不是覆盖了 TP5 原有的验证功能，只是拓展了自动替换功能。

## 安装

```shell
$ composer require tien/think-validate
```

## 使用

1. 需在原有的验证类引入 Core trait（若你同时使用了 [tien/think-swagger](https://github.com/tienZheng/think-swagger)，可不用重复引入）。
2. 最佳使用体验是在中间件中完成数据验证，若 TP 版本不支持中间件的，请参考代码自行完成，谢谢！
3. 中间件默认提取的验证对象是同一模块下的相同名字的验证类。

### 示例代码

	use Tien\ThinkSwagger\Core; 	//需要引入 Core 类
	
	class Feedback extends Validate
	{
		use Core;		//需要引入 Core 类
		
		protected $tienSupplySuffix = '_no';  //默认是 ‘_no’,可以更改
		
		protected $rule = [
			'name|姓名' => 'require|max:32',
			'mobile|手机号' => 'require|mobile',
			'token|会话密钥' => 'require|length:32',
			'id|反馈 id' => 'require|integer|gt:0' 
		];
		
		/**
		 * name 及 mobile 是 require 的，而 name_no 及 moible_no 不是必须的
		 * 若场景中的属性在 $rule 中不存在，会检查是否含有替换的后缀，若有，
		 *   去掉后缀再次去 $rule 中匹配，若还是木有，会抛出错误
		 */
		protected $scene = [
			'create'	=> ['token', 'name', 'mobile'],
			'update'	=> ['token', 'id', 'name_no', 'mobile_no']
		];
		
	}
	
验证数据中间件代码实现
	
	use think\Response;
	use Tien\ThinkVlidate\Validate;		//引入验证类
	
	...
	
	public function handle($request, \Closure $next)
	{
		$validate = new Validate($request);
		
		$result = $validate->check();
		
		if (true !== $result) {
			$error = $validate->getErrorMsg();
			return new Response($error, 400);
		}
		
		return $next($resquest);
		
	}
	
获取替换后的验证规则

	//实例化验证对象
	
	$validate = new yourVlidateClass();
	
	$rule = $validate->getRuleByAction($action);  //$action 是 scene 的 key 

	

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/tienZheng/think-validate/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/tienZheng/think-validate/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT