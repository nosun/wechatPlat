<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Share\ModelHelpers\WechatContentModelHelper;

class SimpleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $url = 'http://mmbiz.qpic.cn/mmbiz_jpg/SJJkaGcJ6nfgPfkEicefDaTLFibomFnyHehIGjTbPTadG9oESicODgAJAxjQiaLKS8KoAqmrklpjciaj1iaaPFhpibkDA/0?wx_fmt=jpeg';
        $type= WechatContentModelHelper::getImageType($url);
        $this->assertEquals('jpeg',$type);
    }
}
