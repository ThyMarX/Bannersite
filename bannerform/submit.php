<!-- PHP for sending the banner form info via mail -->
<!-- Made by: Thomas Dyrholm Siemsen -->
 
<?php
require_once WP_CONTENT_DIR . '/themes/salient-child/config.php'; 

$mailResult = "";
$displayClass = "";

function monthToString($monthInt){
    if($monthInt == "01"){return "Jan";}
    else if($monthInt == "02"){return "Feb";}
    else if($monthInt == "03"){return "Mar";}
    else if($monthInt == "04"){return "Apr";}
    else if($monthInt == "05"){return "May";}
    else if($monthInt == "06"){return "Jun";}
    else if($monthInt == "07"){return "Jul";}
    else if($monthInt == "08"){return "Aug";}
    else if($monthInt == "09"){return "Sep";}
    else if($monthInt == "10"){return "Oct";}
    else if($monthInt == "11"){return "Nov";}
    else if($monthInt == "12"){return "Dec";}
}

// doesn't work for some fucking reason, dunno why
function dispResultMsg($text1, $text2){
    $displayClass = "visible";
    $mailResult = "<h2>$text1</h2><h3>$text2</h3>";
}

if(isset($_POST['submit'])){
    // If it's the test button do this, else do the actual stuff
    if ($_POST['submit'] == "testPhp"){
        $text1 = 'Success!';
        $text2 = 'Du fik sendt mailen, og alt er godt :-)';
        $displayClass = "visible";
        $mailResult = "<h2>$text1</h2><h3>$text2</h3>";
        
        // dispResultMsg("Success!", "Du fik sendt mailen, og alt er godt :-)");
    } else {
        // --- Creating the Variables
        // The empty variables that are used
        $bannerSpecsOutput = "";
        $firstDeadlineOutput = "";
        $finalDeadlineOutput = "";
        $serverLinkOutput = "intet link givet <br>";
        $extraCommentsOutput = "";
        $attachments = array();
        $briefFilePath = "";
        $bannerQuery = "INSERT INTO `banners` (`job_nr_FK`, `customer_FK`, `width`, `height`, `type`, `platform`) VALUES";

        // Collecting the data from the form
        $client = $_POST['client'];
        $jobNr = $_POST['jobNr'];
        $contact = $_POST['contact'];
        $clientEmail = $_POST['clientEmail'];
        $firstDeadline = $_POST['firstDeadline'];
        $finalDeadline = $_POST['finalDeadline'];
        $briefText = $_POST['briefText'];
        $fileSize = $_POST['fileSize']; 
        $platform = $_POST["platform"];
        $sizeInput = $_POST["sizeInput"];
        $extraWidth = $_POST["extraWidth"];
        $extraHeight = $_POST["extraHeight"];
        $extraCheck = $_POST["extraCheck"];
        $serverLink = $_POST["serverLink"];
        $briefFile = $_FILES["briefFile"];
        $extraComments = $_POST['extraComments'];
        $coworkerEmail = $_POST['coworkerEmail'];
        $sender = $_POST['sender'];
        $detailsCntr = $_POST['detailsCntr'];
        $platformCntr = array_map('intval', explode('_', $_POST['platformCntr'])); //it's a string of an array in html so we have to process it
        
        // We get the customer from the db so we can convert the customer name into it's id for the order and banners in the db
        $query1 = "SELECT * FROM `customer` WHERE `name` = '$client'";    // Create Query
        $result1 = mysqli_query($conn, $query1);                        // Get Result
        $posts1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);             // Fetch Data
        mysqli_free_result($result1);

        // ---Formatting the data
        // Sun server link
        if (filter_var($serverLink, FILTER_VALIDATE_URL))  { 
            $serverLinkOutput = "<a href=" . $serverLink . ">" . $serverLink . "</a>";
        }

        // Banner details
        $tempBannerCntr = 0; // the variable that counts how many banners we have in total
        // we use the detailsCntr we got from the js to find out what the max nr of banneres there are
        for ($i = 0; $i < $detailsCntr; $i++) {
            // If it finds a type with the specific number then it starts the process
            if(!empty($_POST["type$i"])){
                $y = 0; // We declare the variable for the loop here so we can change the start 
                $tempBannerCntr++;
                $bannerSpecsOutput .= "Banner nr. $tempBannerCntr <br>"; 
                $bannerSpecsOutput .= 'Type: ' . $_POST["type$i"] . '<br>';
                // Making the destination a link if it's a link
                if(filter_var($_POST["destination$i"], FILTER_VALIDATE_URL))  { 
                    $_POST["destination$i"] = "<a href=" . $_POST["destination$i"] . ">" . $_POST["destination$i"] . "</a>";
                }
                $bannerSpecsOutput .= 'Kampagnelink: ' . $_POST["destination$i"] .'<br>';
                $bannerSpecsOutput .= 'Max størrelse pr zipfil: ' . $_POST["fileSize$i"] .'<br>';
                // since we know there is a type at this $i index, we also know there is a platform[$i][] array
                for ($x = 0; $x < count($platform[$i]); $x++) { 
                    $bannerSpecsOutput .= "Platform: " . $platform[$i][$x] . " og dens størrelserne: <br>";
                    // we use the platformCntr[$i] we got from the js to find out what the max nr of sizesArrays there are
                    for ($y; $y < $platformCntr[$i]; $y++) { 
                        // If it finds a size with the specific number then it starts the process
                        if(!empty($sizeInput[$i][$y]) || !empty($extraCheck[$i][$y])){
                            if(!empty($sizeInput[$i][$y])){
                                foreach ($sizeInput[$i][$y] as $value) {
                                    $bannerSpecsOutput .= "- $value <br>";

                                    // Save it to upload it to the database ------------NY KODE------------
                                    $sizeValues = explode(" x ", $value);
                                    $bannerQuery .= " ($jobNr, ".$posts1[0]['customer_ID'].", ".$sizeValues[0].", ".$sizeValues[1].", '".$_POST['type'.$i]."', '".$platform[$i][$x]."'),"; 
                                }
                            }
                            if (!empty($extraCheck[$i][$y])) {
                                for ($z = 0; $z < count($extraWidth[$i][$y]); $z++) {
                                    if($extraWidth[$i][$y][$z] !== ""){
                                        $bannerSpecsOutput .= " - " . $extraWidth[$i][$y][$z] . " x " . $extraHeight[$i][$y][$z] . "<br>";
                                        
                                        // Save it to upload it to the database ------------NY KODE------------
                                        $bannerQuery .= " ($jobNr, ".$posts1[0]['customer_ID'].", ".$extraWidth[$i][$y][$z].", ".$extraHeight[$i][$y][$z].", '".$_POST['type'.$i]."', '".$platform[$i][$x]."'),";
                                    }
                                }
                            }  
                            $y++; // we update the y variable so the next time we loop we don't loop through the same shit
                            break; // we only want it to add to the bannerSpecsOutput once so we break the loop
                        }
                    }
                }
                $bannerSpecsOutput .= "<br>";
            }
        }

        // Extra comments info
        if(!empty($extraComments)){
            $extraCommentsOutput = "Der er yderlige følgende kommentarer til opgaven: <br> - $extraComments <br><br>";
        }

        // Brieffile
        if(!empty($briefFile)){
            $targetDir = WP_CONTENT_DIR . "/themes/salient-child/uploads";
            $tmpFile = $briefFile["tmp_name"];
            $fileName = $briefFile["name"];
            move_uploaded_file($tmpFile, "$targetDir/" . strtolower($fileName));
            $briefFilePath = "$targetDir/" . strtolower($fileName);
        }

        // Deadlines
        $firstMonth = monthToString(substr($firstDeadline, 5, 2));
        $finalMonth = monthToString(substr($finalDeadline, 5, 2));
        $firstDeadlineOutput = substr($firstDeadline, 0, 5) . $firstMonth . substr($firstDeadline, 7, 3);
        $finalDeadlineOutput = substr($finalDeadline, 0, 5) . $finalMonth . substr($finalDeadline, 7, 3);


        // ---Putting the data into the email
        $to = $coworkerEmail;
        $emailSubject = "Banner bestilling fra: $client";
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $attachments = $briefFilePath;
        $emailBody = "E-mail er sendt af: $sender. <br>".
            "Ny banner bestilling fra <strong>$client</strong>, job nr.: $jobNr <br>".
            "Kontaktperson: $contact, kontaktmail: $clientEmail. <br> <br>".
            "Første deadline: $firstDeadlineOutput. Endelige deadline: $finalDeadlineOutput <br>". 
            "Sun server link: $serverLinkOutput <br>".
            "<strong> Bannerspecifikationer: </strong><br> $bannerSpecsOutput". 
            "<strong> Kundebrief: </strong> <br> - $briefText <br><br>".
            "$extraCommentsOutput";
        
        // ------------------------------------------NY KODE-----------------------------------------
        $orderQuery = "INSERT INTO `orders`(`job_nr`, `customer_FK`, `order_status`) 
            VALUES ($jobNr, ".$posts1[0]['customer_ID'].", 'order_recieved')";

        // Putting the order in the database 
        if (mysqli_query($conn, $orderQuery)) {

            // Put in every banner in the database  
            if (mysqli_query($conn, substr($bannerQuery, 0, -1))){
                // create the directories for the order
                $dirPath = WP_CONTENT_DIR."/themes/salient-child/files/".strtolower($client)."/o$jobNr/";
                if (mkdir($dirPath, 0777, true)){
                    // Get the id's for the new made banners
                    $bannerQ = "SELECT * FROM `banners` WHERE `job_nr_FK` = $jobNr";
                    $bannerR = mysqli_query($conn, $bannerQ); 
                    $bannerP = mysqli_fetch_all($bannerR, MYSQLI_ASSOC); 
                    mysqli_free_result($bannerR);

                    // create all the directories for the banners
                    foreach ($bannerP as $post){
                        mkdir($dirPath."b".$post['banner_ID']."/", 0777, true);
                        mkdir($dirPath."b".$post['banner_ID']."/zip/", 0777, true);
                        mkdir($dirPath."b".$post['banner_ID']."/banner/", 0777, true);
                        mkdir($dirPath."b".$post['banner_ID']."/banner/images/", 0777, true);
                    }

                    // Sending the email
                    if(wp_mail($to, $emailSubject, $emailBody, $headers, $attachments)){
                        $displayClass = "visible";
                        $mailResult = "<h2>Success!</h2><h3>Du fik sendt mailen, og alt er godt :-)</h3>";
                    } else {
                        $displayClass = "visible";
                        $mailResult = "<h2>Noget gik galt!</h2><h3>Mailen kunne ikke sendes</h3>";
                    }
                } else {
                    $displayClass = "visible";
                    $mailResult = "<h2>Noget gik galt!</h2><h3>Bestillingens mappen kunne ikke oprettes i serveren</h3>";
                }
            } else {
                $displayClass = "visible";
                $mailResult = "<h2>Noget gik galt!</h2><h3>Bannerne kunne ikke oprettes i databasen</h3>";
            }
        } else {
            $displayClass = "visible";
            $mailResult = "<h2>Noget gik galt!</h2><h3>Bestillingen kunne ikke oprettes i databasen</h3>";
        }

        // After the mail has been sent delete the upload
        if($fileName !== ""){
            unlink($briefFilePath);
        }

        /* ---Testing area, echoing and vardumping to see what i get
        echo "<br><strong>Det er sådan den sendte mail ser ud: </strong><br>";
        echo "$emailSubject <br><br> $emailBody"; */
        //var_dump(explode('_', $_POST['platformCntr']));
        //echo "<pre>"; var_dump($platform); echo "</pre>";
    }
}


mysqli_close($conn);                                            // Close Connection 
?>