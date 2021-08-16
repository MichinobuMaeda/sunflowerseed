<?php
session_name("DokuWiki");
if(!isset($_SESSION)) {
	session_start();
}
define('DOKU_REL', "/sswiki/");
define('DOKU_COOKIE', 'DW'.md5(DOKU_REL.((1) ? $_SERVER['SERVER_PORT'] : '')));
if (array_key_exists("do", $_GET) && $_GET["do"] == "admin") {
    $_SESSION[DOKU_COOKIE] = [
        'auth' => [
            'user' => 'vote-admin',
            'info' => [
                'grps' => [
                    'voteadmin',
                    'ss',
                ],
                'name' => '投票管理者氏名',
            ],
        ],
    ];
} else if (array_key_exists("do", $_GET) && $_GET["do"] == "user") {
    $_SESSION[DOKU_COOKIE] = [
        'auth' => [
            'user' => 'voter',
            'info' => [
                'grps' => [
                    'ss',
                ],
                'name' => '氏名',
            ],
        ],
    ];
} else if (array_key_exists("do", $_GET) && $_GET["do"] == "logout") {
    session_unset();
}
?>
<p><a href="/">App</a></p>
<form method="GET" action="test.php">
    <input type="submit" name="do" value="admin" />
    <input type="submit" name="do" value="user" />
    <input type="submit" name="do" value="logout" />
</form>
$_SESSION:
<pre><?php print_r(array_key_exists(DOKU_COOKIE, $_SESSION) ? $_SESSION[DOKU_COOKIE] : ''); ?></pre>
