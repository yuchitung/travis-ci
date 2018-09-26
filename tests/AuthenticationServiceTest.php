<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 07:45
 */

namespace Tests {

    use App\AuthenticationService;
    use App\IProfile;
    use App\IToken;
    use PHPUnit\Framework\TestCase;

    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
    use Mockery as m;

    class AuthenticationServiceTest extends TestCase
    {
        /** @test */
        public function is_valid_test()
        {
            $stubProfile = m::mock(IProfile::class);
            $stubProfile->shouldReceive('getPassword')->with('joey')->andReturn('91');

            $stubToken = m::mock(IToken::class);
            $stubToken->shouldReceive('getRandom')->andReturn('000000');

//            $target = new AuthenticationService(new FakeProfile(), new FakeToken());
            $target = new AuthenticationService($stubProfile, $stubToken);
            $actual = $target->isValid('joey', '91000000');

            $this->assertTrue($actual);
        }
    }
}

//namespace App {
//    class FakeProfile implements IProfile
//    {
//        public function getPassword($account)
//        {
//            if ($account == 'joey') {
//                return '91';
//            }
//
//            return '';
//        }
//    }
//
//    class FakeToken implements IToken
//    {
//        public function getRandom($account)
//        {
//            return '000000';
//        }
//    }
//}
