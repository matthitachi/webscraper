<?php
/**
 * Created by PhpStorm.
 * User: ITACHI
 * Date: 11/12/2018
 * Time: 1:01 PM
 */

require_once('../scraper.php');

$scraper = new scraper('http://localhost:8080/regex/','localhost', 'root', '','test');
$scraper->db->column('title', 'varchar', 50);
$scraper->db->column('description', 'varchar', 50);
$scraper->db->column('sub_title', 'varchar', 50);
$scraper->db->column('sub_description', 'varchar', 50);
$scraper->db->column('sub_extra', 'varchar', 50);
$scraper->db->createTable('scrape');
$scraper->data_pattern('<a class="next" href="(.*)">.*<\/a>',['anchor',0],'data',0);
$scraper->data_pattern('<h1>(.*)<\/h1>',['text',1],'title',0);
$scraper->data_pattern('<h6>(.*)<\/h6>',['text',0],'description',0);
//$scraper->data_pattern('<li><a href="http:\/\/localhost:8080\/regex\/scrapefile\d.html">(.*)<\/a> <\/li>',['text',0],'data',0);


$scraper->data_pattern('<li><a href="(.*)">.*<\/a> <\/li>',['anchor',1],'data',0);

$scraper->data_pattern('<h1>(.*)<\/h1>',['text',0],'sub_title',1);
$scraper->data_pattern('<h6>(.*)<\/h6>',['text',0],'sub_description',1);
$scraper->data_pattern('<p>(.*)<\/p>',['text',0],'sub_extra',1);
$scraper->init();
