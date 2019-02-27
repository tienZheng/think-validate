<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/2/26
 * Time: 11:16 PM
 */

namespace Tien\ThinkValidate\Tests;


use PHPUnit\Framework\TestCase;
use Tien\ThinkValidate\exceptions\Exception;
use Tien\ThinkValidate\Validate;

class TestValidate extends TestCase
{

    public function getValidateObj()
    {
        $request = new \stdClass();
        $request->param = [
            'id' => 1,
            'name' => 'test',
        ];
        $request->action = 'create';
        return new Validate($request);
    }



    public function testSetClassName()
    {
        $validate = $this->getValidateObj();

        $className = 'test';

        $this->expectException(Exception::class);

        $this->expectExceptionMessage($className  . '类不存在');

        $validate->setValidateClass($className);

    }






}