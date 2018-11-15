<?php

$url='https://www.rexegg.com/regex-quickstart.html#quantifiers';
$string = 'fdcl f;dkf dfkdlf <b>working through ebola</b> fdlfk fldkf fdlf';
$string2 = '1234567';
$string3= "abcdefghijklmnopqrstuvwxyz ABCDEFGHIJKLMNOPQRSTUVWXYZ
01234567890 _+-.,!@#$%^&*();\/|<>\"\'
<strong>Hello World </strong>
1234 -98.7 3.141 .6180 9,000 +42
555.123.4567	+1-(800)-555-2468
foo@demo.net	bar@ba.test.co.uk
www..demo.com	http://foo.co.uk/
<span class=\"certificate\">PG-13</span>
http://regexr.com/foo.html?q=bar
https://mediatemple.net";
$regex = '/\w[a-Z]/';
$regex2 = '/3+x/';
$regex3 ='/.+/';

preg_match_all($regex3, $string3,$match);
var_dump($match);

?>