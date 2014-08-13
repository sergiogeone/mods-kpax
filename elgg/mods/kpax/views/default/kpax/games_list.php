<script >
    function toggle_visibility() 
    {
        var e = document.getElementById('myGames');
        if ( e.style.display == 'block' )
            e.style.display = 'none';
        else
            e.style.display = 'block';
    }
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> <!-- 33 KB -->
<link  href="http://fotorama.s3.amazonaws.com/4.6.0/fotorama.css" rel="stylesheet"> <!-- 3 KB -->
<script src="http://fotorama.s3.amazonaws.com/4.6.0/fotorama.js"></script> <!-- 16 KB -->

<?php

$objKpax = new kpaxSrv(elgg_get_logged_in_user_entity()->username);

if ($vars['objGameList'] && $vars['template'] == "list") {    
    if ($vars['objGameList']) {
        echo'<div style="float:right;"><input onclick="toggle_visibility();" type="button" value="Show my games" id="toggleGames" ></div>';
        echo'<div style="clear:both;"></div>';
    }
    ?>
    <div id="myGames" style="display: none;">
        <?php echo '<div style="font-weight:bold; font-size:18px; text-align:center;">' . elgg_get_logged_in_user_entity()->username . ' Games</div>';?>
        <div class='score' style='border:1px solid #cccccc; padding:10px; padding-right: 0px; text-align:left;'>
            <?php
            foreach ($vars['objUserGameList'] as $mygame) {
                echo '<div class="game" style="float:left; margin-right:10px; margin-bottom:10px;"><a href=view/'. $mygame->idGame . '>';
                    echo '<div style="font-weight:bold; text-align:center;">' . $mygame->name . '</div>';
                    $objGameDet = $objKpax->getGameDetail($_SESSION["campusSession"], $mygame->idGame);
                    if($objGameDet != null && $objGameDet->logo != null && $objGameDet->logo != ""){
                        echo '<div><img src="'. $objGameDet->logo .'" width="150" height="150" alt=""/></div>';
                    }
                    else{
                        echo '<div><img src="http://localhost/elgg-1.8.14/mod/kpax/graphics/logo.png" width="150" height="150" alt=""/></div>';
                    }
                    echo '<div style="font-weight:bold; text-align:center;"><a href=edit/'. $mygame->idGame . '> Edit </a></div>';
                echo '</a></div>';
                //echo "<p>" . $game->idGame . " - " . "<a href=view/" . $game->idGame . "> $game->name </a>" . $game->idCategory . "</p>";
            }
            echo'<div style="clear:both;"></div>';
            ?>
        </div>
    </div>
    <?php echo '<div style="margin-top: 10px; font-size:18px; font-weight:bold; text-align:center;">Games</div>';?>
    <div class='score' style='border:1px solid #cccccc; padding:10px; padding-right: 0px; text-align:left;'>
        <?php
        foreach ($vars['objGameList'] as $game) {
            echo '<div class="game" style="float:left; margin-right:10px; margin-bottom:10px;"><a href=view/'. $game->idGame . '>';
                echo '<div style="font-weight:bold; text-align:center;">' . $game->name . '</div>';
                $objGameDet = $objKpax->getGameDetail($_SESSION["campusSession"], $game->idGame);
                if($objGameDet != null && $objGameDet->logo != null && $objGameDet->logo != ""){
                    echo '<div><img src="'. $objGameDet->logo .'" width="150" height="150" alt=""/></div>';
                }
                else{
                    echo '<div><img src="http://localhost/elgg-1.8.14/mod/kpax/graphics/logo.png" width="150" height="150" alt=""/></div>';
                }
            echo '</a></div>';           
            //echo "<p>" . $game->idGame . " - " . "<a href=view/" . $game->idGame . "> $game->name </a>" . $game->idCategory . "</p>";
        }
        echo'<div style="clear:both;"></div>';
        ?>
    </div>
    <?php
}
else if ( $vars['objGame'] && $vars['template'] == "detail") { 
    ?><script>$(".elgg-breadcrumbs").hide(); </script><?php
    if($vars['objGameDet'] != null && $vars['objGameDet']->banner != null && $vars['objGameDet']->banner != "")
        echo '<div style="margin-top: -25px;"><img src="'. $vars['objGameDet']->banner .'" width="840" alt=""/></div>';
    else
        echo '<div style="margin-top: -25px;"><img src="http://localhost/elgg-1.8.14/mod/kpax/graphics/banner.png" width="840" alt=""/></div>';
    if($vars['objGameDet'] != null && $vars['objGameDet']->logo != null && $vars['objGameDet']->logo != "")
        echo '<div style="margin-left: 20px; margin-top: -75px !important; border-top-style: solid;"><img src="'. $vars['objGameDet']->logo .'" width="150" height="150" alt=""/></div>';
    echo '<div style="margin-top:20px; float:left;"><iframe width="410" height="315" src="//www.youtube.com/embed/'. $vars['objGameDet']->videourl .'" frameborder="0" allowfullscreen></iframe></div>';
    echo '<div style="margin-top:20px; padding-left:20px;" class="fotorama" width="410" height="315">';
        if (count($vars['listGameImgs'])>0){
            for ($n = 0; $n < count($vars['listGameImgs']); $n++)
                echo '<img width="410" height="315" src="' . $vars['listGameImgs'][$n]->image . '">';
        }
    ?>
    </div>
    <div style="clear:both;"></div>
    <hr width="90%">
    <div id="description">
        <div class="title" style="font-size:25px; margin-bottom:20px;">Description</div>
        <?php 
        echo $vars['objGameDet']->description; 
        ?>
    </div>
    <hr width="90%">
    <div class="title" style="font-size:25px; margin-bottom:20px; margin-top:20px;">Other games from the same developer</div>
    <div class='score' style='border:1px solid #cccccc; padding:10px; padding-right: 0px; text-align:left;'>
        <?php
        foreach ($vars['objUserGameList'] as $mygame) {
            echo '<div class="game" style="float:left; margin-right:10px; margin-bottom:10px;"><a href=view/'. $mygame->idGame . '>';
                echo '<div style="font-weight:bold; text-align:center;">' . $mygame->name . '</div>';
                $objGameDet = $objKpax->getGameDetail($_SESSION["campusSession"], $mygame->idGame);
                if($objGameDet != null && $objGameDet->logo != null && $objGameDet->logo != ""){
                    echo '<div><img src="'. $objGameDet->logo .'" width="150" height="150" alt=""/></div>';
                }
                else{
                    echo '<div><img src="http://localhost/elgg-1.8.14/mod/kpax/graphics/logo.png" width="150" height="150" alt=""/></div>';
                }
                echo '<div style="font-weight:bold; text-align:center;"><a href=edit/'. $mygame->idGame . '> Edit </a></div>';
            echo '</a></div>';
            //echo "<p>" . $game->idGame . " - " . "<a href=view/" . $game->idGame . "> $game->name </a>" . $game->idCategory . "</p>";
        }
        echo'<div style="clear:both;"></div>';
        ?>
    </div>
    <?php

}
else
{ 
	elgg_echo('kPAX:noGames');
}
?> 