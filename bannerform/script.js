/* Javascript for the banner form */
/* Made by: Thomas Dyrholm Siemsen */

/* ---Javascript for showing the size fields when data has been entered in the platform field--- */
// Getting the elements
let platform0_0 = document.getElementById("platform0_0");
let sizes0_0 = document.getElementById("sizes0_0");
let extraCheck0_0 = document.getElementsByName("extraCheck[0][0][]")[0];
let specificSize0_0 = document.getElementsByClassName("specificSize0_0");

// Making the function and using it with a eventlistener
function showBlock (show, displayStyle){
    show.style.animation = "sizesIn 0.3s ease-out";
    show.style.animationPlayState = "running";
    show.style.display = displayStyle;  
}
function hideBlock(show){
    show.style.animation = "sizesOut 0.3s ease-out";
    show.style.animationPlayState = "running";
    setTimeout(function(){show.style.display = "none";}, 290);
}

function handleBlock(trigger, show){
    if(HTMLCollection.prototype.isPrototypeOf(show)){
        if(!trigger.checked){
            for (let i = 0; i < show.length; i++) {
                hideBlock(show[i]);
            }
        } else {
            for (let i = 0; i < show.length; i++) {
                showBlock(show[i], "flex");
            }
        }
    } else {
        if(trigger.value == ""){
            hideBlock(show);
        } else {
            showBlock(show, "block");
        }
    }
}
platform0_0.addEventListener("input", function(){handleBlock(platform0_0, sizes0_0);});
extraCheck0_0.addEventListener("input", function(){handleBlock(extraCheck0_0, specificSize0_0);});

/* ---Javascript for "Basic Pakke"--- */
// Getting the elements
let basicSizes0_0 = document.getElementById("basicSizes0_0");

// Making the function
function basicPakke(basicSizes, sizes){
    if(basicSizes.checked){
        for (let i = 0; i < 6; i++) {
            document.getElementById(sizes+i).checked = true;
        }
    } else {
        for (let i = 0; i < 6; i++) {
            document.getElementById(sizes+i).checked = false;
        }
    }
}

// Adding the function via eventlistener
basicSizes0_0.addEventListener("click", function(){basicPakke(basicSizes0_0, "size0_0_")});


/* --------------Javascript for adding new input fields in the banner form-------------- */
// Variables used in function, for when you need to set a limit on how many extra fields you can make
let platformCntr = [];
platformCntr[0] = 0;
let sizeCntrArr = [];
sizeCntrArr[0] = [];
sizeCntrArr[0][0] = 0;
//let destinationCntr = 0;
let emailCntr = 0;
let bdCntr = 0; //bannerDetailsCounter
let nrOfBanners = 1;
let nrOfPlatforms = [];
nrOfPlatforms[0] = 1;
let detailsMinusCntr = 0;
let platformMinusCntr = [];
platformMinusCntr[0] = 0;

// Variables bassed on html elements
let platformPlus0 = document.getElementById("platformPlus0");
let platformMinus0 = document.getElementById("platformMinus0");
let platformExtra0 = document.getElementById("platformExtra0");
let sizePlus0_0 = document.getElementById("sizePlus0_0");
let sizeMinus0_0 = document.getElementById("sizeMinus0_0");
let sizeExtraChild0_0_0 = document.getElementById("sizeExtraChild0_0_0");
let sizeExtraMinus0_0_0 = document.getElementById("sizeExtraMinus0_0_0");
let sizeExtra0_0 = document.getElementById("sizeExtra0_0");
let coworkerEmailPlus = document.getElementById("coworkerEmailPlus");
let coworkerEmailMinus = document.getElementById("coworkerEmailMinus");
let coworkerEmailExtra = document.getElementById("coworkerEmailExtra");
let bannerDetailsPlus = document.getElementById("bannerDetailsPlus");
let bannerDetailsMinus = document.getElementById("bannerDetailsMinus");
let bannerDetailsExtra = document.getElementById("bannerDetailsExtra");

// Declaring the variables that has the HTML thats inserted, we can't write the html here, since it has to be dynamic
let sizeBoxArray = []; // Here we put the future sizeBox'es in
sizeBoxArray[0] = [];
let coworkerEmailBox = ``;
let bannerDetailsBox = "";
let platformBox = [];
platformBox[0] = ``;

// ---------Functions that helps remove duplicate lines of code
function sizeBoxFunc(x,y,z){
    sizeBoxArray[x][y] = `
    <div class="sizeExtraChild flexNW spaceBetween" id="sizeExtraChild`+x+`_`+y+`_`+z+`">
        <input type="text" class="sizeBoxTextInput sizeBoxTextInput2" name="extraWidth[`+x+`][`+y+`][]" placeholder="Bredde" pattern="[0-9]{2,4}">
        <p>x</p>
        <input type="text" class="sizeBoxTextInput sizeBoxTextInput2" name="extraHeight[`+x+`][`+y+`][]" placeholder="Højde" pattern="[0-9]{2,4}">
        <button type="button" class="smBtn" id="sizeExtraMinus`+x+`_`+y+`_`+z+`">slet</button>
    </div> `;
}

// If w = 1 then that means it's not used for making a new bannerDetails field, but only for making a new platform field
function platformBoxFunc(x,y,w,z){
    platformBox[x] = `
        <output name="platformErr[`+x+`][]" class='errorMsg'></output> 
            
        <div id="sizes`+x+`_`+y+`" class="sizes airTop1">
            <p class="sizeText"> Banner størrelser * <span class="formNote"> bredde x højde</span> </p>
            <!-- This is a object tag instead of a div tag so that it can have the name attribute -->
            <object name="sizeContainer[`+x+`][]" class="flex sizeContainer">
                <div class="fw">
                    <label for="basicSizes`+x+`_`+y+`" type="radio" class="basicPackage bpLabel flex"> 
                        <input type="checkbox" id="basicSizes`+x+`_`+y+`" checked class="bpInput"> 
                        <p> Basic Pakke </p>
                    </label>
                </div>
                
                <div class="flex bpOptions basicPackage">
                    <div class="sizeBoxChild sizeBoxChild1">
                        <label for="size`+x+`_`+y+`_0" type="radio"> 
                            <input type="checkbox" name="sizeInput[`+x+`][`+y+`][]" value="120 x 600" checked id="size`+x+`_`+y+`_0"> 
                            <p> 120 x 600 </p>
                        </label>
                        <label for="size`+x+`_`+y+`_1" type="radio"> 
                            <input type="checkbox" name="sizeInput[`+x+`][`+y+`][]" value="180 x 600" checked id="size`+x+`_`+y+`_1"> 
                            <p> 180 x 600 </p>
                        </label>
                    </div>
                    <div class="sizeBoxChild sizeBoxChild1">
                        <label for="size`+x+`_`+y+`_2" type="radio"> 
                            <input type="checkbox" name="sizeInput[`+x+`][`+y+`][]" value="300 x 250" checked id="size`+x+`_`+y+`_2"> 
                            <p> 300 x 250 </p>
                        </label>
                        <label for="size`+x+`_`+y+`_3" type="radio"> 
                            <input type="checkbox" name="sizeInput[`+x+`][`+y+`][]" value="300 x 600" checked id="size`+x+`_`+y+`_3"> 
                            <p> 300 x 600 </p>
                        </label>
                    </div>
                    <div class="sizeBoxChild sizeBoxChild1" style="margin-right:0;">
                        <label for="size`+x+`_`+y+`_4" type="radio"> 
                            <input type="checkbox" name="sizeInput[`+x+`][`+y+`][]" value="728 x 90" checked id="size`+x+`_`+y+`_4"> 
                            <p> 728 x 90 </p>
                        </label>
                        <label for="size`+x+`_`+y+`_5" type="radio"> 
                            <input type="checkbox" name="sizeInput[`+x+`][`+y+`][]" value="930 x 180" checked id="size`+x+`_`+y+`_5"> 
                            <p> 930 x 180 </p>
                        </label>
                    </div>
                </div>
                <div class="sizeBoxChild sizeBoxChild1" style="padding: 5px;">
                    <label for="size`+x+`_`+y+`_6" type="radio"> 
                        <input type="checkbox" name="sizeInput[`+x+`][`+y+`][]" value="1200 x 1200" id="size`+x+`_`+y+`_6"> 
                        <p> 1200 x 1200</p>
                    </label>
                    <label for="size`+x+`_`+y+`_7" type="radio"> 
                        <input type="checkbox" name="sizeInput[`+x+`][`+y+`][]" value="1800 x 1800" id="size`+x+`_`+y+`_7"> 
                        <p> 1800 x 1800 </p>
                    </label>
                </div>
                <div class="sizeBoxChild sizeBoxChild2 airTop4 flex">
                    <div class="flex">
                        <label type="radio" class="specificSizeCheck"> 
                            <input type="checkbox" name="extraCheck[`+x+`][`+y+`][]" value="checked" style="margin-top: 7px;"> 
                            <p style="font-weight:600;">Specifikke Størrelser:</p>
                        </label> 
                    </div>
                </div>
                <div id="sizeExtra`+x+`_`+y+`" class="flex md-spaceBetween specificSize`+x+`_`+y+`" style="display: none;">
                    <div class="sizeExtraChild flex spaceBetween" id="sizeExtraChild`+x+`_`+y+`_0">
                        <input type="text" class="sizeBoxTextInput sizeBoxTextInput2" name="extraWidth[`+x+`][`+y+`][]" placeholder="Bredde" pattern="[0-9]{2,4}">
                        <p>x</p>
                        <input type="text" class="sizeBoxTextInput sizeBoxTextInput2" name="extraHeight[`+x+`][`+y+`][]" placeholder="Højde" pattern="[0-9]{2,4}">
                        <button type="button" class="smBtn" id="sizeExtraMinus`+x+`_`+y+`_0">slet</button>
                    </div> 
                </div>
                <div class="specificSize`+x+`_`+y+` airTop4" style="display: none;">
                    <button type="button" class="smBtn" id="sizePlus`+x+`_`+y+`">Tilføj Størrelse</button>
                    <button type="button" class="smBtn" id="sizeMinus`+x+`_`+y+`">Slet alle</button>
                </div>
            </object>
            <output name="sizeErr[`+x+`][]" class='errorMsg'></output>
        </div>
    `;
    if(w == 1){
        platformBox[x] = `
        <div id="platformBox`+x+`_`+y+`" class="platformBox">
            <p class="platformBoxTop"> Platform * <span class="formNote"> Platform nr. <span id="platformNr`+x+`_`+y+`">`+(y+1-platformMinusCntr[x])+`</span></span></p>
            <div class="flexNW spaceBetween alignCenter">
                <input type="text" name="platform[`+x+`][]" id="platform`+x+`_`+y+`" list="platforms" class="fwMdBtn">
                <button type="button" id="platformMinus`+x+`_`+y+`" class="mdBtn">Slet Platform</button>
            </div>
            `+platformBox[x]+`
        </div>
        `;
        insertHtml(window["platformExtra"+x], platformBox[x], y, "platformBox"+x+"_");
        sizesFunc(x,y,z);
    
        // Making the the new platform deletable
        window["platformMinus"+x+"_"+y] = document.getElementById("platformMinus"+x+"_"+y);
        window["platformMinusFunc"+x+"_"+y] = function(){
            eval(`platformBox`+x+`_`+y+`.parentNode.removeChild(platformBox`+x+`_`+y+`);`);
            platformMinusCntr[x]++;
            for (let i = y+1; i < nrOfPlatforms[x]; i++) {
                if(window["platformNr"+x+"_"+i] = document.getElementById("platformNr"+x+"_"+i)){
                    window["platformNr"+x+"_"+i].innerHTML = parseInt(window["platformNr"+x+"_"+i].innerHTML)-1;
                }
            }
        }
        eval("platformMinus"+x+"_"+y+`.addEventListener("click", window["platformMinusFunc"+x+"_"+y]);`);

        // Making the first extraSizeChild deletable
        window["sizeExtraChild"+x+"_"+y+"_0"] = document.getElementById("sizeExtraChild"+x+"_"+y+"_0");
        window["sizeExtraMinus"+x+"_"+y+"_0"] = document.getElementById("sizeExtraMinus"+x+"_"+y+"_0");
        window["sizeExtraMinusFunc"+x+"_"+y+"_0"] = function(){
            window["sizeExtraChild"+x+"_"+y+"_0"].parentNode.removeChild(window["sizeExtraChild"+x+"_"+y+"_0"]);
        }
        window["sizeExtraMinus"+x+"_"+y+"_0"].addEventListener("click", window["sizeExtraMinusFunc"+x+"_"+y+"_0"]);
        // if(minus != undefined && minusFunc != undefined){
        //     window[minus+counter] = document.getElementById(minus+counter);
        //     eval(`function `+minusFunc+counter+`(){`+div+counter+`.parentNode.removeChild(`+div+counter+`);}`);
        //     eval(minus+counter+`.addEventListener("click", `+minusFunc+counter+`);`);
        // }
        
        // insertHtml(window["sizeExtra"+x+"_"+y], sizeBoxArray[x][y], z, "sizeExtraChild"+x+"_"+y+"_", "sizeExtraMinus"+x+"_"+y+"_", "sizeExtraMinusFunc"+x+"_"+y+"_");
    }
}

function sizesFunc(x,y,z){
    // Getting the necesarry elements from the new html
    window["platform"+x+"_"+y] = document.getElementById("platform"+x+"_"+y);
    window["sizes"+x+"_"+y] = document.getElementById("sizes"+x+"_"+y);
    window["sizePlus"+x+"_"+y] = document.getElementById("sizePlus"+x+"_"+y);
    window["sizeMinus"+x+"_"+y] = document.getElementById("sizeMinus"+x+"_"+y);
    window["sizeExtra"+x+"_"+y] = document.getElementById("sizeExtra"+x+"_"+y);
    window["extraCheck"+x+"_"+y] = document.getElementsByName("extraCheck["+x+"]["+y+"][]")[0]; //it's by name for the php's sake
    window["specificSize"+x+"_"+y] = document.getElementsByClassName("specificSize"+x+"_"+y);
    window["basicSizes"+x+"_"+y] = document.getElementById("basicSizes"+x+"_"+y);
    
    // Adding the handleBlock function to the platform field
    eval(`platform`+x+`_`+y+`.addEventListener("input", function(){
        handleBlock(platform`+x+`_`+y+`, sizes`+x+`_`+y+`);
    });`);
    // Adding the handleBlock function to the sizeExtra field
    eval(`extraCheck`+x+`_`+y+`.addEventListener("input", function(){
        handleBlock(extraCheck`+x+`_`+y+`, specificSize`+x+`_`+y+`);
    });`);

    // Making the new sizePlus function
    window["sizePlus"+x+"_"+y].addEventListener("click", function(){
        z++;
        sizeBoxFunc(x,y,z); // Making the new sizeBox
        insertHtml(window["sizeExtra"+x+"_"+y], sizeBoxArray[x][y], z, "sizeExtraChild"+x+"_"+y+"_", "sizeExtraMinus"+x+"_"+y+"_", "sizeExtraMinusFunc"+x+"_"+y+"_");
    });

    // Making the new sizeMinus function
    eval(`sizeMinus`+x+`_`+y+`.addEventListener("click", function(){
        z = 0;
        sizeExtra`+x+`_`+y+`.innerHTML = ""; 
    });`);
    
    // basicPackage function
    window["basicSizes"+x+"_"+y].addEventListener("click", function(){basicPakke(window["basicSizes"+x+"_"+y], "size"+x+"_"+y+"_")});
}

// Making the arrays for the dynamic functions so the stay global
let platformPlusFunc = [];
let platformMinusFunc = [];
platformMinusFunc[0] = [];
let detailsMinusFunc = [];

// Calling the insertHtml function and giving it the right arguments for each plus button
platformPlusFunc[0] = function(){
    platformCntr[0]++;
    nrOfPlatforms[0]++;

    sizeCntrArr[0].push(0);
    sizeCntrArr[0][nrOfPlatforms[0]];
    platformBoxFunc("0", platformCntr[0], 1, sizeCntrArr[0][platformCntr[0]]);
}


function sizePlusFunc0_0(){
    //sizeCntrArr[0]++;
    sizeCntrArr[0][0]++;
    sizeBoxFunc("0","0",sizeCntrArr[0][0]);
    //sizeExtra0_0.insertAdjacentHTML('beforeend', sizeBoxArray[0][0]);
    insertHtml(sizeExtra0_0, sizeBoxArray[0][0], sizeCntrArr[0][0], "sizeExtraChild0_0_", "sizeExtraMinus0_0_", "sizeExtraMinusFunc0_0_");
}
function coworkerEmailPlusFunc(){
    emailCntr++;
    coworkerEmailBox = `
        <div id="emailDiv`+emailCntr+`">
            <div class="airTop1 flexNW spaceBetween"> 
                <input type="email" name="coworkerEmail[]" class="fwMdBtn" placeholder="Msq mail..." list="coworkerEmailList"> 
                <button type="button" class="mdBtn" id="emailMinus`+emailCntr+`">Slet Mail</button> 
            </div>
            <p id="coworkerErr`+emailCntr+`" class='errorMsg'></p> 
        </div>`;
    insertHtml(coworkerEmailExtra, coworkerEmailBox, emailCntr, "emailDiv", "emailMinus", "emailMinusFunc"); 
}
function bannerDetailsPlusFunc(){
    // Setting stuff up for the function
    bdCntr++; 
    const x = bdCntr; // We are making a constant so that the variable doesn't change in function
    nrOfBanners++;
    platformCntr[x] = 0;
    nrOfPlatforms[x] = 1;
    sizeCntrArr.push([]);
    sizeCntrArr[x][0] = 0;
    sizeBoxArray.push([]);
    platformBox.push(``);
    platformPlusFunc.push("");
    platformMinusCntr.push(0);

    // Making the htmlbox and inserting it in the html
    platformBoxFunc(x,"0");
    bannerDetailsBox = `
        <div id="detailsDiv`+x+`" class="airTop1 bannerDetails"> 
            <button type="button" class="mdBtn dltBannerBtn" id="detailsMinus`+x+`">Slet Banner</button> 
            <h5>Banner nr. <span id="bannerNr`+x+`">`+(nrOfBanners-detailsMinusCntr)+`</span></h5>

            <p class="airTop3">Type * </p>
            <select name="type`+x+`">
                <option disable select value>...</option>
                <option value="SoMe Video">Sociale Medier Video</option>
                <option value="Adobe Animation">Adobe Animate - Brugerdefineret design og animation $$$$</option>
                <option value="Google Web Designer">Google Web Designer $$$</option>
                <option value="ZUUVI">ZUUVI - Predefineret animation og brugerdefineret design $$$</option>
                <option value="GIF">GIF - Ingen animation, 3-5 stk. brugerdefinerede designs $$</option>
                <option value="Billede">Billede - Ingen animation, 1 stk. brugerdefineret design $</option>
            </select>
            <p id="typeErr`+x+`" class='errorMsg'></p>
            
            <p class="airTop3">Kampagnelink *</p>
            <input type="text" name="destination`+x+`" list="destinationList2">
            <p id="destinationErr`+x+`" class='errorMsg'></p>

            <p class="airTop3">Max størrelse pr zipfil *</p>
            <input type="text" name="fileSize`+x+`" list="fileSizes">
            <p id="fileSizeErr`+x+`" class='errorMsg'></p>

            <p class="airTop1"> Platform * <span class="formNote">Platform nr. 1</span></p>
            <input type="text" name="platform[`+x+`][]" id="platform`+x+`_0" list="platforms">

            `+platformBox[x]+`
            
            <div id="platformExtra`+x+`"></div>
            <div class="airTop1">
                <button type="button" id="platformPlus`+x+`" class="mdBtn">Tilføj Platform</button>
                <button type="button" id="platformMinus`+x+`" class="mdBtn">Slet alle</button>
            </div>
        </div>
        `;
    insertHtml(bannerDetailsExtra, bannerDetailsBox, x, "detailsDiv");
    sizesFunc(x,"0",sizeCntrArr[x][0]);
    
    window["detailsMinus"+x] = document.getElementById("detailsMinus"+x);
    detailsMinusFunc[x] = function(){
        eval(`detailsDiv`+x+`.parentNode.removeChild(detailsDiv`+x+`);`);
        nrOfPlatforms[x] = 0;
        // This is to correct the "Banner nr. X" text, so it always shows 1,2,3 and never 1,3,6
        detailsMinusCntr++;
        for (let i = x+1; i < nrOfBanners; i++) {
            if(document.getElementById("bannerNr"+i)){
                document.getElementById("bannerNr"+i).innerHTML = parseInt(document.getElementById("bannerNr"+i).innerHTML)-1;
            }
        }
    }
    // eval(`function detailsMinusFunc`+x+`(){  This can be deleted when the above detailsMinusFunc is sure to work 100%
    //     detailsDiv`+x+`.parentNode.removeChild(detailsDiv`+x+`);
    //     nrOfPlatforms[`+x+`] = 0;
    // }`);
    eval("detailsMinus"+x+`.addEventListener("click", detailsMinusFunc[x]);`);

    // Getting the necesarry elements from the new html
    window["platformPlus"+x] = document.getElementById("platformPlus"+x);
    window["platformMinus"+x] = document.getElementById("platformMinus"+x);
    window["platformExtra"+x] = document.getElementById("platformExtra"+x);

    platformPlusFunc[x] = function(){
        platformCntr[x]++;
        nrOfPlatforms[x]++;
        const y = platformCntr[x]; // We are making a constant so that the variable doesn't change in the function
        platformBoxFunc(x,y,1);
    };

    window["platformMinusFunc"+x] = function(){
        window["platformExtra"+x].innerHTML = ""; 
        platformCntr[x] = 0;
        nrOfPlatforms[x] = 1;
        platformMinusCntr[x] = 0;
    };

    window["platformPlus"+x].addEventListener("click", platformPlusFunc[x]);
    window["platformMinus"+x].addEventListener("click", window["platformMinusFunc"+x]);

    // The first delete extraSize button
    window["sizeExtraChild"+x+"_0_0"] = document.getElementById("sizeExtraChild"+x+"_0_0");
    window["sizeExtraMinus"+x+"_0_0"] = document.getElementById("sizeExtraMinus"+x+"_0_0");
    window["sizeExtraMinusFunc"+x+"_0_0"] = function(){
        window["sizeExtraChild"+x+"_0_0"].parentNode.removeChild(window["sizeExtraChild"+x+"_0_0"]);
    }
    window["sizeExtraMinus"+x+"_0_0"].addEventListener("click", window["sizeExtraMinusFunc"+x+"_0_0"]);
}

// The clear buttons
function platformMinusFunc0(){
    platformExtra0.innerHTML = ""; 
    platformCntr[0] = 0;
    nrOfPlatforms[0] = 1;
    platformMinusCntr[0] = 0;
}
function sizeMinusFunc0_0(){
    sizeExtra0_0.innerHTML = ""; 
    sizeCntrArr[0][0] = 0;
}
function sizeExtraMinusFunc0_0_0(){
    sizeExtraChild0_0_0.parentNode.removeChild(sizeExtraChild0_0_0);
}
function coworkerEmailMinusFunc(){
    coworkerEmailExtra.innerHTML = ""; 
    emailCntr = 0;
}
function bannerDetailsMinusFunc(){
    bannerDetailsExtra.innerHTML = ""; 
    for (let i = 1; i < nrOfBanners; i++) { //Måske det ikke er den rigtige variable jeg tager length af???
        platformCntr.pop();
        sizeBoxArray.pop();
        nrOfPlatforms.pop();
        platformMinusCntr.pop();
    }
    bdCntr = 0;
    nrOfBanners = 1;
    detailsMinusCntr = 0;
}

// Adding eventlistners to use the functions
platformPlus0.addEventListener("click", platformPlusFunc[0]);
platformMinus0.addEventListener("click", platformMinusFunc0);
sizePlus0_0.addEventListener("click", sizePlusFunc0_0);
sizeMinus0_0.addEventListener("click", sizeMinusFunc0_0);
sizeExtraMinus0_0_0.addEventListener("click", sizeExtraMinusFunc0_0_0);
coworkerEmailPlus.addEventListener("click", coworkerEmailPlusFunc);
coworkerEmailMinus.addEventListener("click", coworkerEmailMinusFunc);
bannerDetailsPlus.addEventListener("click", bannerDetailsPlusFunc);
bannerDetailsMinus.addEventListener("click", bannerDetailsMinusFunc);

// The innerHTML function that is reused, it also adds the minusfunction to the minusbutton
function insertHtml(target, input, counter, div, minus, minusFunc){
    target.insertAdjacentHTML('beforeend', input);
    window[div+counter] = document.getElementById(div+counter);
    // We only make the minus function if it's been defined, this way we can make different ones in specific cases
    if(minus != undefined && minusFunc != undefined){
        window[minus+counter] = document.getElementById(minus+counter);
        eval(`function `+minusFunc+counter+`(){`+div+counter+`.parentNode.removeChild(`+div+counter+`);}`);
        eval(minus+counter+`.addEventListener("click", `+minusFunc+counter+`);`);
    }
}


/* --------------Javascript for validating the banner form-------------- */
// Getting the error fields
let clientErr = document.getElementById("clientErr");
let jobNrErr = document.getElementById("jobNrErr");
let contactErr = document.getElementById("contactErr");
let clientEmailErr = document.getElementById("clientEmailErr");
let firstDLErr = document.getElementById("firstDLErr");
let finalDLErr = document.getElementById("finalDLErr"); 
let briefTextErr = document.getElementById("briefTextErr"); 
let briefFileErr = document.getElementById("briefFileErr"); 
let serverLinkErr = document.getElementById("serverLinkErr");
let senderErr = document.getElementById("senderErr");
let errMsgOutput = document.getElementById("errMsgOutput");
let coworkerErrArr = [];

// The error texts that are used
let errorText1 = "Dette felt SKAL udfyldes!";
let errorText2 = "Ugyldig email: xx@xx.xx";
let errorText3 = 'Ugyldig størrelse: Mellem 10 til 9999';
let errorText4 = "Må max være et år fra dagens dato";
let errorText5 = "Skal være senere end den første deadline";
let errorText6 = "Skal være senere end dagens dato";
let errorText7 = "Ugyldig dato";
let errorText8 = "Filen er for stor til emails, max 10MB";
let errorText9 = "Udfyld både bredde og højde.";
let errCntr = 0;

// The used regular expressions
let patt1 = /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;
let patt2 = /[0-9]{2,4}/;
let patt3 = /(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/;

// Function for checking if a whole array is empty
function arrEmptyCheck(target, type){
    let errorLength = 0;
    for (let i = 0; i < target.length; i++) {
        if(type == "string"){
            if(target[i].value == ""){
                errorLength++;
            }
        } else if (type == "checkbox"){
            if(target[i].checked == false){
                errorLength++;
            }
        }
    }
    if(errorLength == target.length){
        return true;
    } else {
        return false;
    }
}

function arrExpCheck(array, exp, errMsg, errType){
    for (let y = 0; y < array.length; y++) {
        if(array[y].value != ""){
            if(!exp.test(array[y].value)){
                displayError(errMsg, array[y], errType);
            }
        }  
    }
}

// Function for showing the error
function displayError(errMsg, sourceField, errType){
    errMsg.innerHTML = errType;
    sourceField.classList.add("errorField");
    errCntr++;
}

// making the variables global so we can use them in other functions
let formElement = "";
let client = "";
let jobNr = "";
let clientEmail = "";
let contact = "";
let firstDeadline = "";
let finalDeadline = "";
let briefText = "";
let briefFile = "";
let serverLink = "";
let coworkerEmail = "";
let sender = "";

// The function that runs when you press the first submit button
document.getElementById("confirmationSubmit").addEventListener("click", function(event){
    event.preventDefault(); // we prevent the default submit function when this button is pressed, or when you press enter
    errCntr = 0; // if == 0 at the end run popUp(), otherwise display how many errors there are
    errMsgOutput.innerHTML = "";

    // Getting the input fields data
    formElement = document.querySelector("#bannerForm");
    client = formElement.client;
    jobNr = formElement.jobNr;
    contact = formElement.contact;
    clientEmail = formElement.clientEmail;
    firstDeadline = formElement.firstDeadline;
    finalDeadline = formElement.finalDeadline;
    briefText = formElement.briefText;
    briefFile = formElement.briefFile;
    serverLink = formElement.serverLink;
    coworkerEmail = document.getElementsByName("coworkerEmail[]");
    sender = formElement.sender;

    // Formatting the deadlines into dates
    let date1 = new Date(firstDeadline.value);
    let date2 = new Date(finalDeadline.value);

    // Ressetting the errorText1 divs innerHTML to empty and removing the red backgroundcolor class
    clientErr.innerHTML = "";
    jobNrErr.innerHTML = "";
    contactErr.innerHTML = "";
    clientEmailErr.innerHTML = "";
    firstDLErr.innerHTML = "";
    finalDLErr.innerHTML = "";
    briefTextErr.innerHTML = "";
    briefFileErr.innerHTML = "";
    serverLinkErr.innerHTML = "";
    senderErr.innerHTML = "";
    client.classList.remove("errorField");
    jobNr.classList.remove("errorField");
    contact.classList.remove("errorField");
    clientEmail.classList.remove("errorField");
    firstDeadline.classList.remove("errorField");
    finalDeadline.classList.remove("errorField");
    briefText.classList.remove("errorField");
    briefFile.classList.remove("errorField");
    serverLink.classList.remove("errorField");
    sender.classList.remove("errorField");

    // Here we check for errors and display them
    if(client.value == ""){displayError(clientErr, client, errorText1);}
    if(jobNr.value == ""){displayError(jobNrErr, jobNr, errorText1);}
    if(contact.value == ""){displayError(contactErr, contact, errorText1);}
    if(clientEmail.value == ""){displayError(clientEmailErr, clientEmail, errorText1);
    } else if (!patt1.test(clientEmail.value)){displayError(clientEmailErr, clientEmail, errorText2);}
    if (isNaN(date1)){displayError(firstDLErr, firstDeadline, errorText7);
    } else if (date1 >= maxDate){displayError(firstDLErr, firstDeadline, errorText4);
    } else if (date2 <= today){displayError(firstDLErr, firstDeadline, errorText6);}
    if (isNaN(date2)){displayError(finalDLErr, finalDeadline, errorText7);
    } else if (date2 >= maxDate){displayError(finalDLErr, finalDeadline, errorText4);
    } else if (date2 <= today){displayError(finalDLErr, finalDeadline, errorText6);
    } else if (date2 <= date1){displayError(finalDLErr, finalDeadline, errorText5);}
    if(briefText.value == ""){displayError(briefTextErr, briefText, errorText1);}
    if(briefFile.files[0] != undefined){
        if(briefFile.files[0].size >= 10000000){displayError(briefFileErr, briefFile, errorText8);}
    }
    if(serverLink.value == ""){displayError(serverLinkErr, serverLink, errorText1);}
    if(sender.value == ""){displayError(senderErr, sender, errorText1);}

    // Making all the above stuff for all the coworker-fields
    for (let i = 0; i < emailCntr+1; i++) {
        if(document.getElementById("coworkerErr"+i)){
            coworkerErrArr.push(document.getElementById("coworkerErr"+i));
        }
    }
    for (let i = 0; i < coworkerEmail.length; i++) {
        coworkerEmail[i].classList.remove("errorField");
        coworkerErrArr[i].innerHTML = "";
        if(coworkerEmail[i].value == ""){displayError(coworkerErrArr[i], coworkerEmail[i], errorText1);
        } else {
            if(!patt1.test(coworkerEmail[i].value)){displayError(coworkerErrArr[i], coworkerEmail[i], errorText2);}
        }
    }

    // Making all the above stuff for all the bannerDetail-fields: type, platform and size and making the variables global so they can be reused
    for (let i = 0; i < nrOfBanners; i++) {
        // every time it finds a type it makes a dynamic type variable
        if(window["type"+i] = document.getElementsByName("type"+i)[0]){
            // type and destination - get element, remove class and innerHtml, display error
            window["destination"+i] = document.getElementsByName("destination"+i)[0];
            window["fileSize"+i] = document.getElementsByName("fileSize"+i)[0];
            window["typeErr"+i] = document.getElementById("typeErr"+i);
            window["destinationErr"+i] = document.getElementById("destinationErr"+i);
            window["fileSizeErr"+i] = document.getElementById("fileSizeErr"+i);
            window["typeErr"+i].innerHTML = "";
            window["destinationErr"+i].innerHTML = "";
            window["fileSizeErr"+i].innerHTML = "";
            window["type"+i].classList.remove("errorField");
            window["destination"+i].classList.remove("errorField");
            window["fileSize"+i].classList.remove("errorField");
            if(window["type"+i].value == ""){displayError(window["typeErr"+i], window["type"+i], errorText1)}
            if(window["destination"+i].value == ""){displayError(window["destinationErr"+i], window["destination"+i], errorText1)}
            if(window["fileSize"+i].value == ""){displayError(window["fileSizeErr"+i], window["fileSize"+i], errorText1)}

            window["platform"+i] = document.getElementsByName("platform["+i+"][]");
            for (let x = 0; x < window["platform"+i].length; x++) {
                // type - get elements, remove class and innerHtml, display error
                window["platformErr"+i+"_"+x] = document.getElementsByName("platformErr["+i+"][]")[x];
                window["platformErr"+i+"_"+x].innerHTML = "";
                window["platform"+i][x].classList.remove("errorField");
                if(window["platform"+i][x].value == ""){displayError(window["platformErr"+i+"_"+x], window["platform"+i][x], errorText1)} 

                // sizeContainer and error - get elements, remove class and innerHtml
                window["sizeErr"+i+"_"+x] = document.getElementsByName("sizeErr["+i+"][]")[x];
                window["sizeContainer"+i+"_"+x] = document.getElementsByName("sizeContainer["+i+"][]")[x];
                window["sizeErr"+i+"_"+x].innerHTML = "";
                window["sizeContainer"+i+"_"+x].classList.remove("errorField");
                
                // making a selector variable for the querySelector since the html isn't organised smart for a universal selector
                let selector = "";
                if (x == 0){selector = "#sizes"+i+"_0";}
                else {      selector = "#platformExtra"+i+" > div:nth-child("+x+")";}

                // sizes - get element, remove class
                window["size"+i+"_"+x] = document.querySelectorAll(selector + " [name^=sizeInput]");
                window["extraCheck"+i+"_"+x] = document.querySelectorAll(selector + " [name^=extraCheck]")[0];
                window["extraWidth"+i+"_"+x] = document.querySelectorAll(selector + " [name^=extraWidth]");
                window["extraHeight"+i+"_"+x] = document.querySelectorAll(selector + " [name^=extraHeight]");
                let z = 0; // We declare the variable for the loop here so we can change the start 
                for (let y = 0; y < window["extraWidth"+i+"_"+x].length; y++) {
                    window["extraWidth"+i+"_"+x][y].classList.remove("errorField");
                    window["extraHeight"+i+"_"+x][y].classList.remove("errorField");
                    for(z; z <= sizeCntrArr[i][x]; z++){
                        if(document.getElementById("sizeExtraChild"+i+"_"+x+"_"+z) != null){
                            window["sizeExtraChild"+i+"_"+x+"_"+z] = document.getElementById("sizeExtraChild"+i+"_"+x+"_"+z);
                            window["sizeExtraChild"+i+"_"+x+"_"+z].classList.remove("errorField");
                            z++;
                            break;
                        }
                    }
                }

                // sizes - display errors
                if(!window["extraCheck"+i+"_"+x].checked) {
                    if(arrEmptyCheck(window["size"+i+"_"+x], "checkbox")){
                        displayError(window["sizeErr"+i+"_"+x], window["sizeContainer"+i+"_"+x], errorText1);
                    }
                } else if (window["extraCheck"+i+"_"+x].checked){
                    if (arrEmptyCheck(window["extraWidth"+i+"_"+x], "string") && arrEmptyCheck(window["extraHeight"+i+"_"+x], "string")){
                        if(arrEmptyCheck(window["size"+i+"_"+x], "checkbox")){
                            displayError(window["sizeErr"+i+"_"+x], window["sizeContainer"+i+"_"+x], errorText1);
                        }
                    } else {
                        let z = 0;
                        for(let y = 0; y < window["extraWidth"+i+"_"+x].length; y++){
                            for(z; z <= sizeCntrArr[i][x]; z++){
                                if(document.getElementById("sizeExtraChild"+i+"_"+x+"_"+z) != null){
                                    if((window["extraWidth"+i+"_"+x][y].value != "" && window["extraHeight"+i+"_"+x][y].value == "")  ||
                                       (window["extraWidth"+i+"_"+x][y].value == "" && window["extraHeight"+i+"_"+x][y].value != "")) {
                                        displayError(window["sizeErr"+i+"_"+x], window["sizeExtraChild"+i+"_"+x+"_"+z], errorText9);
                                    }
                                    z++;
                                    break;
                                }
                            }
                        }
                        if(window["sizeErr"+i+"_"+x].innerHTML == ""){
                            arrExpCheck(window["extraWidth"+i+"_"+x], patt2, window["sizeErr"+i+"_"+x], errorText3);
                            arrExpCheck(window["extraHeight"+i+"_"+x], patt2, window["sizeErr"+i+"_"+x], errorText3);
                        }
                    }
                }
            }
        }
    }

    // returns
    if(errCntr == 0){
        // Give the invisible input field the detailsCntr so the php can use it
        document.getElementById("detailsCntr").value = nrOfBanners;
        document.getElementById("platformCntr").value = nrOfPlatforms.join("_");
        popUp();
    } else {
        errMsgOutput.innerHTML = "Der er " + errCntr + " fejl.";
    }
});

/* --------------Javascript for the confirmation popup window that displays when confirmation is complete------------- */
function popUp(){    
    // ---Declaring the necesarry variables
    // Declaring the empty ones
    let bannerSpecsOutput = "";
    let firstDeadlineOutput = "";
    let finalDeadlineOutput = "";
    let extraCommentsOutput = "";
    let coworkerOutput = "";
    let briefTextOutput = "";
    
    // Getting the extra html elements
    let confirmationContent = document.getElementById("confirmationContent");
    let extraComments = formElement.extraComments.value;
    let serverLink = formElement.serverLink.value;

    // ---Formatting the input data
    // coworkerEmails
    for (let i = 0; i < coworkerEmail.length; i++) {
        if (coworkerEmail[i].value != "") {
            coworkerOutput += "- " + coworkerEmail[i].value + "<br>";
        }
    }
    // Bannerdetails
    let tempBannerCntr = 0;
    for (let i = 0; i < nrOfBanners; i++) {
        if(window["type"+i] = document.getElementsByName("type"+i)[0]){
            tempBannerCntr++;

            // Making the destination a link if it's a link
            if(patt3.test(window["destination"+i].value)){
                window["destinationOutput"+i] = "<a href=" + window["destination"+i].value + ">" + window["destination"+i].value + "</a>";
            } else {
                window["destinationOutput"+i] = window["destination"+i].value;
            } 

            bannerSpecsOutput += "Banner nr. " + tempBannerCntr + "<br>";
            bannerSpecsOutput += "Type: " + window["type"+i].value + "<br>";
            bannerSpecsOutput += "Kampagnelink: " + window["destinationOutput"+i] + "<br>";
            bannerSpecsOutput += "Max størrelse pr zipfil: " + window["fileSize"+i].value + "<br>";

            for (let x = 0; x < window["platform"+i].length; x++) {
                bannerSpecsOutput += "Platform: " + window["platform"+i][x].value + ", og dens størrelser: <br>";
                for (let y = 0; y < window["size"+i+"_"+x].length; y++) {
                    if(window["size"+i+"_"+x][y].checked){
                        bannerSpecsOutput += "- " + window["size"+i+"_"+x][y].value + "<br>";
                    }
                }
                if(window["extraCheck"+i+"_"+x].checked){
                    // for (let y = 0; y < window["extraInput"+i+"_"+x].length; y++) {
                    //     if(window["extraInput"+i+"_"+x][y].value != ""){
                    //         bannerSpecsOutput += "- " + window["extraInput"+i+"_"+x][y].value + "<br>";
                    //     }
                    // }

                    
                    for (let y = 0; y < window["extraWidth"+i+"_"+x].length; y++) {
                        if(window["extraWidth"+i+"_"+x][y].value != ""){
                            bannerSpecsOutput+="- "+window["extraWidth"+i+"_"+x][y].value+" x "+window["extraHeight"+i+"_"+x][y].value+"<br>";
                        }
                    }
                    // let z = 0;
                    // for(let y = 0; y < window["extraWidth"+i+"_"+x].length; y++){
                    //     for(z; z <= sizeCntrArr[i][x]; z++){
                    //         if(document.getElementById("sizeExtraChild"+i+"_"+x+"_"+z) != null){
                    //             if((window["extraWidth"+i+"_"+x][y].value != "" && window["extraHeight"+i+"_"+x][y].value == "")  ||
                    //                (window["extraWidth"+i+"_"+x][y].value == "" && window["extraHeight"+i+"_"+x][y].value != "")) {
                    //                 displayError(window["sizeErr"+i+"_"+x], window["sizeExtraChild"+i+"_"+x+"_"+z], errorText9);
                    //             }
                    //             z++;
                    //             break;
                    //         }
                    //     }
                    // }
                }            
            }
            bannerSpecsOutput += "<br>";
        }
    }
    // extra comments
    if(extraComments != ""){
        if(extraComments.length > 120){
            extraComments = extraComments.slice(0, 120) + "...";
        }
        extraCommentsOutput = "<br> Der er følgende ekstra kommentarer: <br> - " + extraComments;
    }
    // brief text
    if(briefText.value.length > 120){
        briefTextOutput = briefText.value.slice(0, 120) + "...";
    } else {
        briefTextOutput = briefText.value;
    }
    // server link
    if(patt3.test(serverLink)){
        serverLink = "<a href=" + serverLink + ">" + serverLink + "</a> <br>";
    }
    // deadlines
    let finalMonth = monthToString(finalDeadline.value.substr(5, 2));
    let firstMonth = monthToString(firstDeadline.value.substr(5, 2));
    finalDeadlineOutput = finalDeadline.value.substr(0, 5) + finalMonth + finalDeadline.value.substr(7, 3);
    firstDeadlineOutput = firstDeadline.value.substr(0, 5) + firstMonth + firstDeadline.value.substr(7, 3);
  
    // setting the data as html
    confirmationContent.innerHTML =
        "E-mailen bliver sent af: " + sender.value + " og til: <br>" + coworkerOutput +
        "<br> Kunden er: <strong>" + client.value + "</strong>, job nr.:" + jobNr.value + "<br>" +
        "Kontaktperson: " + contact.value + ", kontaktmail: " + clientEmail.value +
        ". <br> Første deadline: " + firstDeadlineOutput + ". Endelige deadline: " + finalDeadlineOutput +
        "<br> Sun server link: " + serverLink + 
        "<br><br> <strong> Bannerspecifikationer: </strong> <br>" + bannerSpecsOutput +
        "<strong> Kunde briefen: </strong> <br>- " + briefTextOutput + "<br>" +
        extraCommentsOutput;
        
    confirmation.style.display = "block";
}

// Arranging the popUp windows and giving them closing functions
let confirmation = document.getElementById('confirmation');
let mailResult = document.getElementById('mailResult');
let span1 = document.getElementsByClassName("closePopUp")[0];
let span2 = document.getElementsByClassName("closePopUp")[1];
let closeButton = document.getElementsByName("closeButton")[0];
span1.onclick = function() {confirmation.style.display = "none";}
closeButton.onclick = function() {confirmation.style.display = "none";}
span2.onclick = function() {mailResult.classList.remove("visible");}
window.onclick = function(event) {
    if (event.target == confirmation) {confirmation.style.display = "none";} 
    if (event.target == mailResult) {mailResult.classList.remove("visible");} 
}


/* --------------Javascript for extra small stuff------------- */
// Setting the minimum and maximum date in the input date fields
let today = new Date();
let maxDate = new Date();
maxDate.setMonth(maxDate.getMonth()+10);
let dd1 = today.getDate();
let mm1 = today.getMonth()+1; // January is 0!
let yyyy1 = today.getFullYear();
let dd2 = maxDate.getDate();
let mm2 = maxDate.getMonth()+1; // January is 0!
let yyyy2 = maxDate.getFullYear();
if(dd1<10){dd1='0'+dd1;} 
if(dd2<10){dd2='0'+dd2;} 
if(mm1<10){mm1='0'+mm1;} 
if(mm2<10){mm2='0'+mm2;} 
let todayStr = yyyy1+'-'+mm1+'-'+dd1;
let maxDateStr = yyyy2+'-'+mm2+'-'+dd2;
document.getElementsByName("firstDeadline")[0].setAttribute("min", todayStr);
document.getElementsByName("finalDeadline")[0].setAttribute("min", todayStr);
document.getElementsByName("firstDeadline")[0].setAttribute("max", maxDateStr);
document.getElementsByName("finalDeadline")[0].setAttribute("max", maxDateStr);

function monthToString(monthInt){
    if(monthInt == "01"){return "Jan";}
    if(monthInt == "02"){return "Feb";}
    if(monthInt == "03"){return "Mar";}
    if(monthInt == "04"){return "Apr";}
    if(monthInt == "05"){return "May";}
    if(monthInt == "06"){return "Jun";}
    if(monthInt == "07"){return "Jul";}
    if(monthInt == "08"){return "Aug";}
    if(monthInt == "09"){return "Sep";}
    if(monthInt == "10"){return "Oct";}
    if(monthInt == "11"){return "Nov";}
    if(monthInt == "12"){return "Dec";}
}