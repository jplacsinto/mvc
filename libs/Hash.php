<?php
class Hash{

    /*
     * @param string $algo The algorithm ('md5', 'sha1', 'sha256', 'whirlpool', etc
     * @param string $data The data to hash
     * @param string $salt the salt or hash key
     */
    public static function create($algo, $data, $salt){

        $context = hash_init($algo, HASH_HMAC, $salt);
        hash_update($context, $data);

        return hash_final($context);
    }
}