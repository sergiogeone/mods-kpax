<?php

//----------------
//AUTHOR: rviguera
//----------------
$objKpax = new kpaxSrv(elgg_get_logged_in_user_entity()->username); //Get games list from kpaxSrv

// "Show my games" button


//Get filter and order parameters
$idFilterer = $_SESSION['gameListFilter']; //Millor fer-ho com a post
$idOrderer = $_SESSION['gameListOrder'];
$fields = $_SESSION['gameListFields'];
$values = $_SESSION['gameListValues'];

if(!isset($idFilterer))
{
    $idFilterer = 0; //Default filterer: do not filter
    $_SESSION['gameListFilter'] = $idFilterer;
}
if(!isset($idOrderer))
{
    $idOrderer = 0; //Default orderer: do not order
    $_SESSION['gameListOrder'] = $idOrderer;
}
if(!isset($fields))
{
    $fields = array(); //Default fields array: no fields
    $values = array(); //Default fields array: no fields

    $_SESSION['gameListFields'] = $fields;
    $_SESSION['gameListValues'] = $values;
}
$userGameList = $objKpax->getDeveloperGames($_SESSION["campusSession"], elgg_get_logged_in_user_entity()->username);
$notUserGameList = $objKpax->getNotDeveloperGames($_SESSION["campusSession"], elgg_get_logged_in_user_entity()->username);

if(isset($notUserGameList))
{
    //system_message(elgg_echo('kpax:list:success'));
    //$content = '<p>' . elgg_echo($gameList[1]->name). '</p>';
    //$content = '<p>' . elgg_echo("HOLA"). '</p>';  
    $content = elgg_view('kpax/games_list', array('objGameList' => $notUserGameList, 'objUserGameList' => $userGameList, 'template' => "list"));
    //var_dump($content);
}
else
{
    register_error(elgg_echo('kpax:list:failed'));
    $content = '<p>' . elgg_echo('kpax:none') . '</p>';
}
$params = array(
'content' => $content,
'filter' => false,  // All, Mine and Friends tabs are not shown
'sidebar' => elgg_view('kpax/sidebar', array('template' => "list"))
);

$body = elgg_view_layout('one_sidebar', $params);
 
//echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));

echo elgg_view_page($title, $body);
?>
