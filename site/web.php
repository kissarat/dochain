<?php
/**
 * Last modified: 18.07.10 09:20:09
 * Hash: caa98ef6c500d51de94ffe875973c31f1ae663c7
 */

require_once 'boot.php';

/**
 * @param string $method
 * @param string $url
 * @return bool|string
 */
function request(string $method, string $url)
{
    $info = explode('://', $url);
    return file_get_contents($url, false, stream_context_create([
        $info[0] => [
            'method' => $method,
            'header' => "Accept: application/json\r\n"
        ]
    ]));
}
