<?php
/**
 * Created by PhpStorm.
 * User: ITACHI
 * Date: 11/12/2018
 * Time: 1:01 PM
 */

//require_once('database.php');
require_once ('scraper.php');


$scraper = new scraper('https://bincheck.org/','localhost', 'root', '','test');
$scraper->db->column('bin', 'varchar', 50);
$scraper->db->column('brand', 'varchar', 100);
$scraper->db->column('brand_url', 'varchar', 100);
$scraper->db->column('type', 'varchar', 100);
$scraper->db->column('category', 'varchar', 100);
$scraper->db->column('bank', 'text', '');
$scraper->db->column('bank_url', 'text', '');
$scraper->db->column('country', 'varchar', 100);
$scraper->db->column('country_url', 'varchar', 100);
$scraper->db->column('short', 'varchar', 10);
$scraper->db->column('latitude', 'varchar', 100);
$scraper->db->column('longitude', 'varchar', 100);
$scraper->db->createTable('bincheck');
$scraper->data_pattern('<a class="list-group-item withripple" data-no-turbolink="true" href="\/(.+?)">.+<\/a>',['anchor',1],'data',0);
//$scraper->data_pattern('<a class="list-group-item withripple" data-no-turbolink="true" href="\/(.+?)">Cyprus<\/a>',['anchor',1],'data',0);
$scraper->data_pattern('<span class="monts"><a href="\/(\w+)">.*<\/a><\/span>',['anchor',2],'data',1);
$scraper->data_pattern('<a rel="next" href="\/(.+?)">',['anchor',1],'data',1);
$scraper->data_pattern('<tr>\s+<th class="col-md-3"> BIN\/IIN<\/th>\s+<td>(\d+?)<\/td>\s+<\/tr>',['text',0],'bin',2);
$scraper->data_pattern('<tr>\s+<th>Brand<\/th>\s+<td>\s+<a href="\/\w+?">(\w+?)<\/a>\s+<\/td>\s+<\/tr>',['text',0],'brand',2);
$scraper->data_pattern('<tr>\s+<th>Brand<\/th>\s+<td>\s+<a href="\/(\w+?)">\w+?<\/a>\s+<\/td>\s+<\/tr>',['text',0],'brand_url',2);
$scraper->data_pattern('<tr>\s+<th>Type<\/th>\s+<td>\s+(.*)\s+<\/td>\s+<\/tr>',['text',0],'type',2);
$scraper->data_pattern('<tr>\s+<th>Category<\/th>\s+<td>\s+(.*)\s+<\/td>\s+<\/tr>',['text',0],'category',2);
$scraper->data_pattern('<tr>\s+<th class="col-md-3"> Bank<\/th>\s+<td>\s+(.*)\s+<\/td>\s+<\/tr>',['text',0],'bank',2);
$scraper->data_pattern('<th class="col-md-3"> Bank URL<\/th>\s+<td>\s+(.+?)\s+<\/td>\s+',['text',0],'bank_url',2);
$scraper->data_pattern('<tr>\s+<th>Country<\/th>\s+<td>\s+<a href="\/.+?">(.+?)<\/a>\s+<\/td>\s+<\/tr>',['text',0],'country',2);
$scraper->data_pattern('<tr>\s+<th>Country<\/th>\s+<td>\s+<a href="\/(.+?)">.+?<\/a>\s+<\/td>\s+<\/tr>',['text',0],'country_url',2);
$scraper->data_pattern('<tr>\s+<th>Country Short<\/th>\s+<td>\s+(.*)\s+<\/td>\s+<\/tr>',['text',0],'short',2);
$scraper->data_pattern('<tr>\s+<th>Latitude<\/th>\s+<td>\s+(.*)\s+<\/td>\s+<\/tr>',['text',0],'latitude',2);
$scraper->data_pattern('<tr>\s+<th>Longitude<\/th>\s+<td>\s+(.*)\s+<\/td>\s+<\/tr>',['text',0],'longitude',2);
//

$scraper->init();
//preg_match_all('/<a class="list-group-item withripple" data-no-turbolink="true" href="\/(.+?)">.+<\/a>/', $input_lines, $output_array);