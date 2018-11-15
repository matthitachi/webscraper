<?php
/**
 * Created by PhpStorm.
 * User: ITACHI
 * Date: 11/12/2018
 * Time: 1:28 PM
 */
require_once('database.php');
class scraper
{
    public $db = null;
public $url = "";
//stores regex pattern for scraping in different depth levels data grab
public $depth = array();
//holds result to be tranversed by database class to be inserted in the table
public $result = array();
public $result1 = array();
public $track_url=array();
//rows number for a singular scrape.
public $rows = 0;
//depth at which row change
public $conversion_depth = 2;

public $level_data = array();

public function __construct($url, $server, $username, $password, $database)
{
    $this->db = new database($server, $username, $password, $database);
    $this->url = $url;
}

public function init(){
    $this->fill_leveldepth();
    $this->do_sort();
$response = $this->get_data($this->url);
$this->scrape($response, 0);
}

//get the webpage to be scraped
public function get_data($url){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($curl);
    return $result;
}

public function scrape($response, $depth, $prev_level_data = []){
    $scrape_depth = $this->depth[$depth];
    $index =0;

    foreach ($scrape_depth as $depth_options){
        if($depth == 0){
            echo 1;
        }

        if(preg_match_all($depth_options[0], $response, $match)){

            for($i = 0; $i<count($match[1]); $i++){
                if($depth_options[1][0] == 'anchor'){

                    $depth = $depth_options[1][1];
                    $url = $this->url.$match[1][$i];
                    $response_inner = $this->get_data($url);
                    $prev_level_data = $this->level_data[($depth >0)?($depth-1):0];
                    if($index>0 && $this->depth[$depth][$index-1][1][0] == 'anchor'){
                        $prev_level_data = [];
                    }
                    $this->scrape($response_inner, $depth, $prev_level_data);//
                }else{
                    $data = $match[1][$i];
                    //get all result in an array before passing to daatabase
                    array_push($prev_level_data, array($data, $depth_options[2]));
                    $this->result[$this->rows] = $prev_level_data;
                    $this->level_data[$depth] = (count(end($this->result))==0)?[]:end($this->result);
                }

            }
        }
    $index++;

    }

    if($this->conversion_depth == $depth){
        if($this->rows <  count($this->result)){
            $this->db->insert($this->result[$this->rows],($this->rows+1));
        }
        $this->rows++;
    }
return;
}

public function data_pattern($regex, $type, $column, $depth){
    //type is an array which is either text which gets the data within te regex or anchor which opens another page to grab data based on the depth value then returns to continue.
    //type=array('anchor','2'), type=array('text','')
    //depth specifies where the depth field which the current data is stored
    //regex match should be in group 1
    $regex = "/".$regex."/";
    if($type[0] != 'anchor'){
        $type[1] = 0;
    }
    $this->depth[$depth][] = array($regex, $type, $column);
}

public function fill_leveldepth(){
    for($i = 0; $i < count($this->depth); $i++){
        $this->level_data[$i] = array();
    }
}


public function do_sort(){
    for ($i = 0; $i<count($this->depth); $i++){
        usort($this->depth[$i], function ($a, $b){
            return ($a[1][0] != $b[1][0])?($a[1][0] < $b[1][0]):$a[1][1] < $b[1][1];
        });
    }
}

}