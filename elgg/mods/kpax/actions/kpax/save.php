<?php

$objKpax = new kpaxSrv(elgg_get_logged_in_user_entity()->username);
gatekeeper();


// get the form input
$title = get_input('title');
$description = get_input('description');
$logo = get_input('logo');
$banner = get_input('banner');
$videourl = get_input('videourl');
$images = string_to_url_array(get_input('images'));
$tags = string_to_tag_array(get_input('tags'));
$category = get_input('category'); //NOU
$creationDate = get_input('creationDate'); //NOU

$guid = get_input('guid');
$container_guid = get_input('container_guid', elgg_get_logged_in_user_guid());

elgg_make_sticky_form('kpax'); //if saving fails, the input info. in the form is retained

if ($guid == 0) { // New game
    $kPAXgame = new ElggObject;
    $kPAXgame->subtype = "kpax";
    $kPAXgame->container_guid = (int) get_input('container_guid', $_SESSION['user']->getGUID());
    $new = true;
} else { //Edit existing game (???)
    $kPAXgame = get_entity($guid);
    if (!$kPAXgame->canEdit()) {
        system_message(elgg_echo('kpax:save:failed:entity'));
        forward(REFERRER);
    }
    $listGameImgs = $objKpax->getGameImages($_SESSION["campusSession"], $guid);
    for ($n = 0; $n < count($listGameImgs); $n++) {
        error_log(print_r('image' . $listGameImgs[$n]->idGameImage, TRUE));
        $img = get_input('image' . $listGameImgs[$n]->idGameImage);
        error_log(print_r($img, TRUE));
        if ($img == 'on'){
            if($objKpax->delGameImage($_SESSION["campusSession"], $listGameImgs[$n]->idGameImage)!="OK"){
                register_error(elgg_echo('kpax:save:failed:service'));
            }
        }
    }
}

// fill in the game object with the information from the form
$kPAXgame->title = $title;
$kPAXgame->description = $description;
$kPAXgame->logo = $logo;
$kPAXgame->banner = $banner;
$kPAXgame->videourl = $videourl;
$kPAXgame->idCategory = $category; //NOU
$kPAXgame->creationDate = $creationDate; //NOU

// by default, the game is public
$kPAXgame->access_id = ACCESS_LOGGED_IN;

// by default, the developer is the logged in user
$kPAXgame->owner_guid = elgg_get_logged_in_user_guid();

// save tags as metadata
$kPAXgame->tags = $tags;

// save urls as metadata
$kPAXgame->images = $images;

// save the game to the database
if ($kPAXgame->save()) {    
    elgg_clear_sticky_form('kpax');
    system_message(elgg_echo('kpax:save:success'));
} else {
    register_error(elgg_echo('kpax:save:failed'));
    forward("kpax");
}

//if($objKpax->addGame($_SESSION["campusSession"],$title, $kPAXgame->getGUID())!="OK"){
// register_error(elgg_echo('kpax:save:failed:service'));
//}
//NOU
$developer = elgg_get_logged_in_user_entity()->username;
if($objKpax->addGame($_SESSION["campusSession"],$title, $kPAXgame->getGUID(), $category, $creationDate, $developer )!="OK"){
    register_error(elgg_echo('kpax:save:failed:service'));
}
else
{
    if($objKpax->addDelTagsGame($_SESSION["campusSession"], $kPAXgame->getGUID(), get_input('tags'))!="OK"){
     register_error(elgg_echo('kpax:save:failed:service'));
    }

    if($objKpax->addDetailGame($_SESSION["campusSession"], $kPAXgame->getGUID(), $kPAXgame->description, $kPAXgame->logo, $kPAXgame->banner, $kPAXgame->videourl)!="OK"){
        register_error(elgg_echo('kpax:save:failed:service'));
    }

    if($objKpax->addImagesGame($_SESSION["campusSession"], $kPAXgame->getGUID(), get_input('images'))!="OK"){
     register_error(elgg_echo('kpax:save:failed:service'));
    }
}

// forward user to a page that displays the developer's games information
system_message($kPAXgame->getURL());

forward('kpax/play');
//forward('kpax/my_dev_games'); SUBSTITUIR PER L'ANTERIOR QUAN ESTIGUI ARREGLAT
?>