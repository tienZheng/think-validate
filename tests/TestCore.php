<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/2/26
 * Time: 10:43 PM
 */

namespace Tien\ThinkValidate\Tests;


use PHPUnit\Framework\TestCase;
use Tien\ThinkValidate\exceptions\Exception;
use Tien\ThinkValidate\TCore;

class TestCore extends TestCase
{

    public function getTCoreObj()
    {
        return new TCore();
    }


    public function testGetRuleByCreate()
    {
        $core = $this->getTCoreObj();
        $action = 'create';

        $actual = $core->getRuleByAction($action);

        $except = [
            'id|标识符' => 'require|gt:0',
            'name|姓名' => 'require|max:16',
            'mobile|手机号' => 'require|mobile',
            'token|密钥' => 'require|length:32'
        ];

        $this->assertSame($except, $actual);

        //断定 tienStrictBool
        $actual = $core->getTiemStrictBool();
        $except = true;

        $this->assertSame($except, $actual);
    }



    public function testGetRuleByUpdate()
    {
        $core = $this->getTCoreObj();
        $action = 'update';

        $actual = $core->getRuleByAction($action);

        $except = [
            'id|标识符' => 'require|gt:0',
            'token|密钥' => 'require|length:32',
            'name|姓名' => 'max:16',
            'mobile|手机号' => 'mobile',
        ];

        $this->assertSame($except, $actual);

        //断定 min
        $minNum = $core->getTienMinNum();
        $this->assertSame(3, $minNum);

        //断定 max
        $maxNum = $core->getTiemMaxNum();
        $this->assertSame(4, $maxNum);

        //断定 strict
        $strict = $core->getTiemStrictBool();
        $this->assertSame($strict, false);
    }


    public function testGetRuleThrow()
    {
        $core = $this->getTCoreObj();
        $action = 'show';

        $this->expectException(Exception::class);

        $this->expectExceptionMessage('不存在该变量的验证规则：error');

        $core->getRuleByAction($action);
    }


    public function testGetCheckRule()
    {
        $core = $this->getTCoreObj();
        $action = 'create';

        $core->getRuleByAction($action);

        $actual = $core->getCheckRule();

        $except = ['id', 'name', 'mobile', 'token'];

        $this->assertSame($except, $actual);
    }
}