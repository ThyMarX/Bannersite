<?php
/*Template name: bannerform */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
get_header();
nectar_page_header( $post->ID );
$nectar_fp_options = nectar_get_full_page_options();

// Custom made code starts here
require_once WP_CONTENT_DIR . '/themes/salient-child/config.php'; 

$query = 'SELECT * FROM customer';
$result = mysqli_query($conn, $query);
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result); 
?>

<!-- HTML for the banner form -->
<!-- Made by: Thomas Dyrholm Siemsen -->

<?php require_once WP_CONTENT_DIR . '/themes/salient-child/bannerform/submit.php'; ?>
<head><link rel="stylesheet" href="/wp-content/themes/salient-child/bannerform/bannerform-style.css"></head>

<div class="container-wrap">
	<div class="<?php if ( $nectar_fp_options['page_full_screen_rows'] !== 'on' ) { echo 'container'; } ?> main-content">

        <!-- The custom selfmade html starts here -->
        <h2>Banner Specifikationer</h2>
        <h4 class="airTop2">Her er en tjekliste for hvilke specifikationer der er nødvendige for teamet at have, før de kan lave banneret. </h4>
        <h7>(Denne side er kun optimeret til at blive brugt på Google Chrome)</h7>

        <form method="POST" id="bannerForm" enctype="multipart/form-data" class="airTop2">
            <!-- Customer details -->
            <h4>Brief</h4>
            
            <div class="flex spaceBetween airTop1">
                <div class="half">
                    <p>Kunde *</p>
                    <!-- <input type="text" name="client" list="clients" class="empty">
                    <datalist id="clients">
                        <option value="Stark">Stark</option>
                        <option value="Q8">Q8</option>
                        <option value="Meny">Meny</option>
                        <option value="Lyngy Storycenter">Lyngy Storycenter</option>
                        <option value="Apotek">Apotek</option>
                    </datalist>  -->
                    <select name="client" style="height:48px;background:rgb(0,0,0,0.04);">
                        <option disable select value>...</option>
                        <?php foreach($posts as $post) {?>
                            <option value="<?=$post['name'];?>"><?=$post['name'];?></option>
                        <?php } ?>
                    </select>
                    <p id="clientErr" class='errorMsg'></p>
                </div>
                <div class="half">
                    <p>Job nr. *</p>
                    <input type="text" name="jobNr">
                    <p id="jobNrErr" class='errorMsg'></p>
                </div>
            </div>

            <div class="flex spaceBetween airTop1">
                <div class="half">
                    <p>Kunde kontakt *</p>
                    <input type="text" name="contact"> 
                    <p id="contactErr" class='errorMsg'></p>
                </div>
                <div class="half">
                    <p>Kundemail *</p>
                    <input type="email" name="clientEmail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                    <p id="clientEmailErr" class='errorMsg'></p>
                </div>
            </div>

            <div class="flex spaceBetween airTop1">
                <div class="half">
                    <p>1. draft deadline *</p>
                    <input type="date" name="firstDeadline">
                    <p id="firstDLErr" class='errorMsg'></p>
                </div>
                <div class="half">
                    <p>Endelig deadline *</p>
                    <input type="date" name="finalDeadline"> 
                    <p id="finalDLErr" class='errorMsg'></p>
                </div>
            </div>
            
            <p class="airTop1">Brief *</p>
            <textarea name="briefText" class="bannerFormTextArea"></textarea>
            <p id="briefTextErr" class='errorMsg'></p>
            <p class="formNote">Hvis kunden har givet briefen som en fil, så skriv det og tilføj filen.</p> 
            <input type="file" name="briefFile" class="sm-files" accept="">
            <p id="briefFileErr" class='errorMsg'></p>
            
            <p class="airTop1">Sun server link *</p>
            <input type="text" name="serverLink" list="empty">
                <datalist id="empty">
                    <option>Intet materiale givet</option>
                </datalist>
            <p class="formNote">Hvis du kan finde det, så link gerne til der hvor den relevante materiale er på sun serveren.</p>
            <p id="serverLinkErr" class='errorMsg'></p>  
    
            <!-- The "Specific Banner Details" field --> 
            <h4 class="airTop2">Bannerspecifikationer</h4>

            <div id="bannerDetails0" class="bannerDetails airTop3">
                <h5>Banner nr. 1</h5>
                <p class="airTop3">Type *</p>
                <select name="type0"> <!-- It's necesarry that type has a unique name and isn't an array -->
                    <option disable select value>...</option>
                    <option value="SoMe Video">Sociale Medier Video</option>
                    <option value="Adobe Animation">Adobe Animate - Brugerdefineret design og animation $$$$</option>
                    <option value="Google Web Designer">Google Web Designer $$$</option>
                    <option value="ZUUVI">ZUUVI - Predefineret animation og brugerdefineret design $$$</option>
                    <option value="GIF">GIF - Ingen animation, 3-5 stk. brugerdefinerede designs $$</option>
                    <option value="Billede">Billede - Ingen animation, 1 stk. brugerdefineret design $</option>
                </select>
                <p id="typeErr0" class='errorMsg'></p>

                <p class="airTop3">Kampagnelink *</p>
                <input type="text" name="destination0" list="destinationList1">
                <p class="formNote">Hvis kunden ikke har et link endnu, er det også fint.<span class="md-hide"> Det skal først bruges når designet af banneret er godkendt.</span></p> 
                <p id="destinationErr0" class='errorMsg'></p>
                <datalist id="destinationList1">
                    <option>Intet materiale givet</option>
                    <option>Intet link behøvet, det en SoMe video</option>
                </datalist>
                <datalist id="destinationList2">
                    <option>Intet materiale givet</option>
                    <option>Samme link som til banner nr. 1</option>
                    <option>Intet behøvet, det en SoMe video</option>
                </datalist>

                <p class="airTop3">Max størrelse pr zipfil *</p>
                <input type="text" name="fileSize0" list="fileSizes">
                <datalist id="fileSizes">
                    <option select>&#60 120kb (Grøndland)</option>
                    <option>&#60 150kb (Danmark)</option>
                    <option>&#60 2mb (ZUUVI)</option>
                    <option>Intet behøvet, det en SoMe video</option>
                </datalist> 
                <p id="fileSizeErr0" class='errorMsg'></p>

                <p class="airTop1"> Platform * <span class="formNote"> Platform nr. 1</span></p>
                <input type="text" name="platform[0][]" id="platform0_0" list="platforms">
                <datalist id="platforms">
                    <option value="Google">Google</option>
                    <option value="TubeMogul">TubeMogul</option>
                    <option value="Adform">Adform</option>
                    <option value="Facebook (Banner)">Facebook (Banner)</option>
                    <option value="Facebook (Video)">Facebook (Video)</option>
                    <option value="Instagram">Instagram</option>
                    <option value="Snapchat">Snapchat</option>
                </datalist>
                <!-- This is a output tag instead of a p tag so that it can have the name attribute -->
                <output name="platformErr[0][]" class='errorMsg'></output>  

                <div id="sizes0_0" class="sizes airTop1">
                    <p class="sizeText"> Banner størrelser * <span class="formNote"> bredde x højde</span> </p>
                    <!-- This is a object tag instead of a div tag so that it can have the name attribute -->
                    <object name="sizeContainer[0][]" class="flex sizeContainer">
                        <div class="fw">
                            <label for="basicSizes0_0" type="radio" class="basicPackage bpLabel flex"> 
                                <input type="checkbox" id="basicSizes0_0" checked class="bpInput"> 
                                <p> Basic Pakke </p>
                            </label>
                        </div>
                        
                        <div class="flex bpOptions basicPackage">
                            <div class="sizeBoxChild sizeBoxChild1">
                                <label for="size0_0_0" type="radio"> 
                                    <input type="checkbox" name="sizeInput[0][0][]" value="120 x 600" checked id="size0_0_0"> 
                                    <p> 120 x 600 </p>
                                </label>
                                <label for="size0_0_1" type="radio"> 
                                    <input type="checkbox" name="sizeInput[0][0][]" value="180 x 600" checked id="size0_0_1"> 
                                    <p> 180 x 600 </p>
                                </label>
                            </div>
                            <div class="sizeBoxChild sizeBoxChild1">
                                <label for="size0_0_2" type="radio"> 
                                    <input type="checkbox" name="sizeInput[0][0][]" value="300 x 250" checked id="size0_0_2"> 
                                    <p> 300 x 250 </p>
                                </label>
                                <label for="size0_0_3" type="radio"> 
                                    <input type="checkbox" name="sizeInput[0][0][]" value="300 x 600" checked id="size0_0_3"> 
                                    <p> 300 x 600 </p>
                                </label>
                            </div>
                            <div class="sizeBoxChild sizeBoxChild1" style="margin-right:0;">
                                <label for="size0_0_4" type="radio"> 
                                    <input type="checkbox" name="sizeInput[0][0][]" value="728 x 90" checked id="size0_0_4"> 
                                    <p> 728 x 90 </p>
                                </label>
                                <label for="size0_0_5" type="radio"> 
                                    <input type="checkbox" name="sizeInput[0][0][]" value="930 x 180" checked id="size0_0_5"> 
                                    <p> 930 x 180 </p>
                                </label>
                            </div>
                        </div>
                        <div class="sizeBoxChild sizeBoxChild1" style="padding: 5px;">
                            <label for="size0_0_6" type="radio"> 
                                <input type="checkbox" name="sizeInput[0][0][]" value="1200 x 1200" id="size0_0_6"> 
                                <p> 1200 x 1200</p>
                            </label>
                            <label for="size0_0_7" type="radio"> 
                                <input type="checkbox" name="sizeInput[0][0][]" value="1800 x 1800" id="size0_0_7"> 
                                <p> 1800 x 1800 </p>
                            </label>
                        </div>
                        <div class="sizeBoxChild sizeBoxChild2 airTop4 flex">
                            <div class="flex">
                                <label type="radio" class="specificSizeCheck"> 
                                    <input type="checkbox" name="extraCheck[0][0][]" value="checked" style="margin-top: 7px;"> 
                                    <p style="font-weight:600;">Specifikke Størrelser:</p>
                                </label> 
                            </div>
                        </div>
                        <div id="sizeExtra0_0" class="flex md-spaceBetween specificSize0_0" style="display: none;">
                            <div class="sizeExtraChild flex spaceBetween" id="sizeExtraChild0_0_0">
                                <input type="text" class="sizeBoxTextInput sizeBoxTextInput2" name="extraWidth[0][0][]" placeholder="Bredde" pattern="[0-9]{2,4}">
                                <p>x</p>
                                <input type="text" class="sizeBoxTextInput sizeBoxTextInput2" name="extraHeight[0][0][]" placeholder="Højde" pattern="[0-9]{2,4}">
                                <button type="button" class="smBtn" id="sizeExtraMinus0_0_0">slet</button>
                            </div> 
                        </div>
                        <div class="specificSize0_0 airTop4" style="display: none;">
                            <button type="button" class="smBtn" id="sizePlus0_0">Tilføj Størrelse</button>
                            <button type="button" class="smBtn" id="sizeMinus0_0">Slet alle</button>
                        </div>
                    </object>
                    <output name="sizeErr[0][]" class='errorMsg'></output>
                </div>
                <div id="platformExtra0"></div>
                <div class="airTop1">
                    <button type="button" id="platformPlus0" class="mdBtn">Tilføj Platform</button>
                    <button type="button" id="platformMinus0" class="mdBtn">Slet alle</button>
                </div>
            </div>
            <div id="bannerDetailsExtra"></div>
            <div class="airTop1"> 
                <button type="button" class="mdBtn" id="bannerDetailsPlus">Tilføj Banner</button>
                <button type="button" class="mdBtn" id="bannerDetailsMinus">Slet alle</button>
            </div>

            <!-- Intern kommunikation -->
            <h4 class="airTop2">Intern kommunikation</h4>
            <p> Yderligere kommentarer </p>
            <textarea name="extraComments" class="bannerFormTextArea"></textarea>  

            <p class="airTop1"> Send bestilling til *</p>
            <input type="email" name="coworkerEmail[]" placeholder="Msq mail..." list="coworkerEmailList">
            <datalist id="coworkerEmailList">
                <option value="fake.dk@hotmail.com">Thomas</option>
                <option value="olh@marketsquare.dk">Orla</option>
                <option value="ek@marketsquare.dk">Eva</option>
                <option value="hkh@marketsquare.dk">Hilda</option>
                <option value="bz@marketsquare.dk">Bogdan</option>
            </datalist>
            <p id="coworkerErr0" class='errorMsg'></p> 
            <div id="coworkerEmailExtra"></div>
            <div class="airTop1">
                <button type="button" class="mdBtn" id="coworkerEmailPlus">Tilføj Mail</button> 
                <button type="button" class="mdBtn" id="coworkerEmailMinus">Slet alle</button>
            </div>

            <p class="airTop1">Afsender *</p>
            <input type="text" name="sender" placeholder="Hvad er dit navn ?"> 
            <p id="senderErr" class='errorMsg'></p>
            
            <!-- The submit button -->
            <div class="flex airTop2">
                <button type="submit" id="confirmationSubmit">Send</button>
                <p id="errMsgOutput"></p> 
                <button type="button" onclick="test()">Test JS</button>
                <button type="button" onclick="fillOutAll()">Fyld formen</button>
                <button type="submit" name="submit" value="testPhp">Test Php</button>
            </div>

            <!-- -----------The stuff that you can't see right away -->
            <!-- The Pop Up window that display the confirmation message -->
            <div id="confirmation" class="popUp">
                <div class="popUpContent confirmationStyle">
                    <div>
                        <span class="closePopUp">&times;</span>
                        <h5 style="margin:0;">Emailen du skal til at sende indholder følgende:</h5>
                    </div>
                    <div id="confirmationContent"></div>
                    <div class="flex spaceBetween">
                        <h5 style="margin:0; padding:11px 0;">Er du sikker på at du vil sende?</h5>
                        <button type="submit" name="submit">Send</button>
                        <button type="button" name="closeButton" style="padding:0 20px;">Luk</button>
                    </div>
                </div>
            </div> 

            <!-- Where the mail result popUp message gets echo'ed -->
            <div id="mailResult" class="<?=$displayClass?> popUp">
                <div class="popUpContent mailResultStyle">
                    <span class="closePopUp">&times;</span>
                    <?=$mailResult?>
                </div>
            </div>
            
            <!-- The invisible field we use to send the detailsCntr and platformCntr values from the JS to the PHP -->
            <input type="text" style="display: none;" name="detailsCntr" id="detailsCntr" value="1">
            <input type="text" style="display: none;" name="platformCntr" id="platformCntr" value="1">
        </form>
	</div><!--/container-->
</div><!--/container-wrap-->
<?php print_r($_POST['list']); ?>

<script src="/wp-content/themes/salient-child/bannerform/script.js"></script>
<script src="/wp-content/themes/salient-child/bannerform/test.js"></script>

<?php get_footer(); ?>