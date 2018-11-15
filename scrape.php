<?php
/**
 * Created by PhpStorm.
 * User: ITACHI
 * Date: 11/11/2018
 * Time: 2:41 PM
 */

$curl = curl_init();
$url = "http:/www.imdb.com/search/title"
    ."?year=2000,2000&title=feature&sort=moviemeter,asc&page=76&ref=adv_nxt";

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($curl);
$movies = array();
//match movie title
preg_match_all('<a href="\/title\/.*?\/?ref_=adv_li_tt">(.*?)<\/a>', $result,$match);
$movies['name'] = $match[1];
//match movie year
preg_match_all('<span class="lister-item-year text-muted unbold">\(.*(\d{4}) \w*?\)<\/span>', $result,$match);
$movies['year'] = $match[1];
//match image url
preg_match_all('', $result,$match);
$movies['image'] = $match[1];

//match certificate, runtime, genre block
preg_match_all('', $result,$match);

//match certificate, runtime, genre block individually from above block
for($i=0;$i<count($match[1]); $i++){
    //match certificate
    if(preg_match('', $match[1][$i], $certificate)){
        $movies['certificate'][$i] = $certificate[1];
    }else{
        $movies['certificate'][$i] = '';
    }

    //match runtume
    if(preg_match('', $match[1][$i], $runtime)){
        $movies['runtime'][$i] = $runtime[1];
    }else{
        $movies['runtime'][$i] = '';
    }

    //match genre
    if(preg_match('', $match[1][$i], $genre)){
        $movies['genre'][$i] = $genre[1];
    }else{
        $movies['genre'][$i] = '';
    }
}

//match rating bar block
preg_match_all('', $result,$match);


//match rating individually
for($i=0;$i<count($match[1]); $i++){
    //match certificate
    if(preg_match('', $match[1][$i], $imdb_rating)){
        $movies['imdb_rating'][$i] = $imdb_rating[1];
    }else{
        $movies['imdb_rating'][$i] = '';
    }


}

//match the metascores and description together, make metascore optional

preg_match_all('', $result,$match);
for($i=0;$i<count($match[0]); $i++){
    //match certificate
    if(preg_match('', $match[0][$i], $metascore)){
        $movies['metascore'][$i] = $metascore[1];
    }else{
        $movies['metascore'][$i] = '';
    }

    if(preg_match('', $match[0][$i], $description)){
        $movies['description'][$i] = $description[1];
    }else{
        $movies['description'][$i] = '';
    }

}


//match directors and stars block

preg_match_all('', $result,$match);
for($i=0;$i<count($match[1]); $i++){
    //match certificate
    if(preg_match('', $match[1][$i], $directors)){
        //print_r($directors);die;
        $clean_directors = preg_replace('','', $directors);
        $movies['directors'][$i] = $clean_directors;
    }else{
        $movies['directors'][$i] = '';
    }

    if(preg_match('', $match[0][$i], $stars)){
        preg_match_all('', $stars[1], $all_stars);
        $movies['stars'][$i] = implode(', ',$all_stars[1]);
    }else{
        $movies['stars'][$i] = '';
    }

}

//match votes block, votes and gross, (because Gross can be empty)
//votes pr gross can be empty, they can also both be empth. make them both optional
$regex = '';
//<div class="lister-item mode-advanced">

preg_match_all($regex, $result, $match);
for($i=0;$i<count($match[0]); $i++){
    //match certificate
    if(preg_match('', $match[0][$i], $votes)){
        $movies['votes'][$i] = $votes[1];
    }else{
        $movies['votes'][$i] = '';
    }

    if(preg_match('', $match[0][$i], $gross)){
        $movies['gross'][$i] = $gross[1];
    }else{
        $movies['gross'][$i] = '';
    }

}

print_r($movies);