<?php
// Get the browser language
// $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

// // Set the chinese language array
// $acceptLang = ['zh', 'zh-hk', 'zh-tw', 'zh-cn'];

// // Determine language
// $lang = in_array($lang, $acceptLang) ? 'zh-hk' : 'en' ;

// // Set the cookie
// setcookie("lang", $lang, time() + 31556926);

// Change page to specific language
header("Location: /zh-hk");