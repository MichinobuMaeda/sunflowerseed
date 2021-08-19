<?php
session_name("DokuWiki");
if(!isset($_SESSION)) {
	session_start();
}
define('DOKU_REL', "/sswiki/");
define('DOKU_COOKIE', 'DW'.md5(DOKU_REL.((1) ? $_SERVER['SERVER_PORT'] : '')));
if (array_key_exists("do", $_GET) && $_GET["do"] == "admin1") {
    $_SESSION[DOKU_COOKIE] = [
        'auth' => [
            'user' => 'vote-admin1',
            'info' => [
                'grps' => [
                    'voteadmin',
                    'ss',
                ],
                'name' => '投票管理者１',
            ],
        ],
    ];
} else if (array_key_exists("do", $_GET) && $_GET["do"] == "admin2") {
    $_SESSION[DOKU_COOKIE] = [
        'auth' => [
            'user' => 'vote-admin2',
            'info' => [
                'grps' => [
                    'voteadmin',
                    'ss',
                ],
                'name' => '投票管理者２',
            ],
        ],
    ];
} else if (array_key_exists("do", $_GET) && $_GET["do"] == "user1") {
    $_SESSION[DOKU_COOKIE] = [
        'auth' => [
            'user' => 'voter1',
            'info' => [
                'grps' => [
                    'ss',
                ],
                'name' => '氏名１',
            ],
        ],
    ];
} else if (array_key_exists("do", $_GET) && $_GET["do"] == "user2") {
    $_SESSION[DOKU_COOKIE] = [
        'auth' => [
            'user' => 'voter2',
            'info' => [
                'grps' => [
                    'ss',
                ],
                'name' => '氏名２',
            ],
        ],
    ];
} else if (array_key_exists("do", $_GET) && $_GET["do"] == "user3") {
    $_SESSION[DOKU_COOKIE] = [
        'auth' => [
            'user' => 'voter3',
            'info' => [
                'grps' => [
                    'ss',
                ],
                'name' => '氏名３',
            ],
        ],
    ];
} else if (array_key_exists("do", $_GET) && $_GET["do"] == "user4") {
    $_SESSION[DOKU_COOKIE] = [
        'auth' => [
            'user' => 'voter4',
            'info' => [
                'grps' => [
                    'ss',
                ],
                'name' => '氏名４',
            ],
        ],
    ];
} else if (array_key_exists("do", $_GET) && $_GET["do"] == "user5") {
    $_SESSION[DOKU_COOKIE] = [
        'auth' => [
            'user' => 'voter5',
            'info' => [
                'grps' => [
                    'ss',
                ],
                'name' => '氏名５',
            ],
        ],
    ];
} else if (array_key_exists("do", $_GET) && $_GET["do"] == "logout") {
    session_unset();
}
?>
<p><a href="/">App</a></p>
<form method="GET" action="test.php">
    <input type="submit" name="do" value="admin1" />
    <input type="submit" name="do" value="admin2" />
    <input type="submit" name="do" value="user1" />
    <input type="submit" name="do" value="user2" />
    <input type="submit" name="do" value="user3" />
    <input type="submit" name="do" value="user4" />
    <input type="submit" name="do" value="user5" />
    <input type="submit" name="do" value="logout" />
</form>
$_SESSION:
<pre><?php print_r(array_key_exists(DOKU_COOKIE, $_SESSION) ? $_SESSION[DOKU_COOKIE] : ''); ?></pre>
