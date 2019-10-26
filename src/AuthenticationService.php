<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 07:43
 */

namespace App {

    /**
     * Class AuthenticationService
     * @package App
     */
    class AuthenticationService
    {
        /**
         * @var IProfile
         */
        private $profile;
        /**
         * @var IToken
         */
        private $token;

        /**
         * @var ILogger
         */
        private $logger;

        public function __construct(IProfile $profileDao = null, IToken $rsaTokenDao = null, ILogger $logger = null)
        {
            $this->profile = $profileDao ?: new $profileDao();
            $this->token = $rsaTokenDao ?: new $rsaTokenDao();
            $this->logger = $logger;
        }

        public function isValid($account, $password)
        {
            // 根據 account 取得自訂密碼
            $passwordFromDao = $this->profile->getPassword($account);
            // 根據 account 取得 RSA token 目前的亂數
            $randomCode = $this->token->getRandom($account);

            var_dump($randomCode);

            // 驗證傳入的 password 是否等於自訂密碼 + RSA token亂數
            $validPassword = $passwordFromDao . $randomCode;
            $isValid = $password === $validPassword;

            if ($isValid) {
                return true;
            } else {
                $this->logger->save(sprintf('account: %s try to login failed', $account));
                return false;
            }
        }
    }

    class ProfileDao implements IProfile
    {
        public function getPassword($account)
        {
            return Context::getPassword($account);
        }
    }

    class RsaTokenDao implements IToken
    {
        public function getRandom($account)
        {
            return sprintf('%06d', mt_rand(0, 999999));
        }
    }

    class Context
    {
        public static $profiles = [
            'joey' => '91',
            'mei' => '99',
        ];

        public static function getPassword($key)
        {
            return static::$profiles[$key];
        }
    }
}
