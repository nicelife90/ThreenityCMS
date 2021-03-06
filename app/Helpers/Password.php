<?php
/**
 * Copyright (C) 2014 - 2017 Threenity CMS - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary  and confidential
 * Written by : nicelife90 <yanicklafontaine@gmail.com>
 * Last edit : 2018
 *
 *
 */

/**
 * Created by PhpStorm.
 * User: ylafontaine
 * Date: 2017-10-16
 * Time: 14:30
 */

namespace ThreenityCMS\Helpers;


class Password
{

    /**
     * Validate password
     *
     * @param $password - Text password
     * @param $hash - Stored Hash
     *
     * @return bool
     */
    public static function isValid($password, $hash)
    {
        if (password_verify($password, $hash)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * validate if hash required update
     *
     * @param $password
     * @param $hash
     *
     * @return bool|string
     */
    public static function needsRehash($password, $hash)
    {
        $options = [
            'cost' => 10,
        ];

        if (password_needs_rehash($hash, PASSWORD_BCRYPT, $options)) {

            return self::hash($password);
        }

        return false;
    }

    /**
     * Hash password
     *
     * @param $password - Text password
     *
     * @return string
     */
    public static function hash($password)
    {
        $options = [
            'cost' => 10,
        ];

        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    /**
     * Get best cost for the current serveur
     */
    public static function getBestCost()
    {
        $timeTarget = 0.05;

        $cost = 8;
        do {
            $cost++;
            $start = microtime(true);
            password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
            $end = microtime(true);
        } while (($end - $start) < $timeTarget);

        echo "Best cost for this server is : " . $cost . "\n";
    }


	/**
	 * Validate password Strength
	 * @param $password
	 *
	 * @return bool
	 */
    public static function validateStrength($password){

		$uppercase = preg_match('@[A-Z]@', $password);
		$lowercase = preg_match('@[a-z]@', $password);
		$number    = preg_match('@[0-9]@', $password);

		if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
			return false;
		}

		return true;
	}
}