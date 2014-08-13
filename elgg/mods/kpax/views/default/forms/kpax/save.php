<style>
.left{float:left; margin-right:10px;}
.imagecheck{text-align: center;}
</style>
<?php
$category = elgg_extract('category', $vars, ''); //NOU
$creationDate = elgg_extract('creationDate', $vars, ''); //NOU
$skills = elgg_extract('skills', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$csr_file = elgg_extract('csr_file', $vars, '');
$container_guid = elgg_extract('container_guid', $vars);
$guid = elgg_extract('guid', $vars, null);
$kpax = elgg_extract('entity', $vars, FALSE);

//$owner = $kpax->getOwnerEntity();

if ($guid) {
  $objKpax = new kpaxSrv(elgg_get_logged_in_user_entity()->username);
  $objGame = $objKpax->getGame($kpax->guid, $_SESSION["campusSession"]);
  $objGameDet = null;
  $listGameImgs = null;
  if ($objGame != null) {
    $objGameDet = $objKpax->getGameDetail($_SESSION["campusSession"], $kpax->guid);
    $listGameImgs = $objKpax->getGameImages($_SESSION["campusSession"], $kpax->guid);
  } 
}
$title = "";
$desc = "";
$logo = "";
$banner = "";
$videourl = "";
if ($objGameDet != null){
  $title = $objGame->name;
  $desc = $objGameDet->description;
  $logo = $objGameDet->logo;
  $banner = $objGameDet->banner;
  $videourl = $objGameDet->videourl;
}
?>

<div>
    <label><?php echo elgg_echo('kPAX:game:name'); ?></label><br />
    <?php echo elgg_view('input/text', array('name' => 'title', 'value' => $title)); ?>
</div>

<div>
    <label><?php echo elgg_echo('kPAX:game:description'); ?></label><br />
    <?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $desc)); ?>
</div>

<div>
    <label><?php echo elgg_echo('Logo (square image url 150px x 150px)'); ?></label><br />
    <?php echo elgg_view('input/text', array('name' => 'logo', 'value' => $logo)); ?>
</div>

<div>
    <label><?php echo elgg_echo('Game banner (image url)'); ?></label><br />
    <?php echo elgg_view('input/text', array('name' => 'banner', 'value' => $banner)); ?>
</div>

<div>
    <label><?php echo elgg_echo('Youtube id video'); ?></label><br />
    <?php echo elgg_view('input/text', array('name' => 'videourl', 'value' => $videourl)); ?>
</div>

<div>
    <label><?php echo elgg_echo('kPAX:game:category'); ?></label><br />
    <?php echo elgg_view('input/text', array('name' => 'category', 'value' => $category)); ?>
</div>

<div>
    <label><?php echo elgg_echo('kPAX:game:creationDate'); ?></label><br />
    <?php echo elgg_view('input/text', array('name' => 'creationDate', 'value' => $creationDate)); ?>
</div>

<div> 
    <label><?php echo elgg_echo('kPAX:game:platforms'); ?></label><br />
    <?php echo elgg_view('input/checkboxes', array('name' => "plataformes", //It'd be great to include the logos
                                                   'options' => array('web' => '1', 
                                                                      'android' => '2',
                                                                      'iOS' => '3',
                                                                      'Nintendo DS' => '4',
                                                                      'PSP' => '5',
                                                                      'Nintendo Wii' => '6',
                                                                      'XBox' => '7'))); ?>
</div>

<div>
    <label><?php echo elgg_echo('kPAX:game:skills'); ?></label><br />
    <?php echo elgg_view('input/tags', array('name' => 'skills', 'value' => $skills)); ?>
</div>

<div>
    <label><?php echo elgg_echo('kPAX:game:tags'); ?></label><br />
    <?php echo elgg_view('input/tags', array('name' => 'tags', 'value' => $tags)); ?>
</div>

<h3>Images</h3>

<?php
if ($guid){
  $message = count($listGameImgs);
  if (count($listGameImgs)>0)
    echo'<label>';echo elgg_echo('Select images to delete them');echo'</label><br />';
  for ($n = 0; $n < count($listGameImgs); $n++) {
    $img = $listGameImgs[$n];
    echo '<div id="image' . $n,'" class="left">';
      echo '<div><img src="'. $img->image .'" width="100" height="100" alt=""/></div>';
      echo '<div class="imagecheck">';echo elgg_view('input/checkbox', array('name' => 'image' . $img->idGameImage));echo '</div>';
    echo'</div>';
  }
  echo'<div style="clear:both;"></div>';
}
?>

<div>
    <label><?php echo elgg_echo('Insert as many images as you want, put the URLs separated by a space'); ?></label><br />
    <?php echo elgg_view('input/longtext', array('name' => 'images', 'value' => '')); ?>
</div>

<h3>Security</h3>

<p>In order to connect your game to kPAX, it is necessary to create a specific public/private key pair. 
It can be done using <A HREF=http://www.openssl.org/>openSSL</A>. You only need to run the command:
</p>

<p><code>openssl req -out requestUser.csr -new -newkey rsa:2048 -nodes -keyout private.key</code>
</p>

<!-- <p><code>openssl req -passout pass:abcdefg -subj "/C=US/ST=IL/L=Chicago/O=IBM Corporation/OU=IBM Software Group/CN=Rational Performance Tester CA/emailAddress=rpt@abc.ibm.com" -new > waipio.ca.cert.csr</p> -->

<p>
Once you have run it, you should have two text files: the private key (.pml), which is only for your eyes, and the
certificate request file (.csr), which you must include below. kPAX will create and store a certificate in your 
game's information sheet.
</p>

<div>
    <label><?php echo elgg_echo('kPAX:game:csr_file'); ?></label><br />
    <?php echo elgg_view('input/file', array('name' => 'csr_file', 'value' => $csr_file)); ?>
</div>

<?php

echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));

if ($guid) {
	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
}

?>
<div>
    <?php echo elgg_view('input/submit', array('value' => elgg_echo('kPAX:game:send'))); ?>
</div>
