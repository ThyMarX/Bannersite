<?php 
$order_ID = mysqli_real_escape_string($conn, $_POST["order_ID"]);
$job_nr = mysqli_real_escape_string($conn, $_POST["job_nr"]);
$order_status = mysqli_real_escape_string($conn, $_POST["order_status"]);
$cust_name = strtolower(mysqli_real_escape_string($conn, $_POST["cust_name"]));
$date_of_order = strtolower(mysqli_real_escape_string($conn, $_POST["date_of_order"]));

?>
<div class="content-inner">
    <div id="fws_5eba91e20f9ec" data-column-margin="default" data-midnight="dark" data-bg-mobile-hidden=""
        class="wpb_row vc_row-fluid vc_row standard_section " style="padding-top: 0px; padding-bottom: 0px; ">
        <div class="row-bg-wrap" data-bg-animation="none" data-bg-overlay="false">
            <div class="inner-wrap">
                <div class="row-bg" style=""></div>
            </div>
            <div class="row-bg-overlay"></div>
        </div>
        <div class="col span_12 dark left">
            <div class="vc_col-sm-12 wpb_column column_container vc_column_container col no-extra-padding instance-0"
                data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation=""
                data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color=""
                data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1"
                data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
                <div class="vc_column-inner">
                    <div class="column-bg-overlay-wrap" data-bg-animation="none">
                        <div class="column-bg-overlay"></div>
                    </div>
                    <div class="wpb_wrapper">
                        <div class="col span_12 section-title text-align-center extra-padding">
                            <h2>
                            </h2>
                            <h1><?= "$cust_name Banner bestilling job nr. $job_nr";?></h1>
                        </div>
                        <div class="clear"></div>
                        <div class="col span_12 section-title text-align-center extra-padding">
                            <h2>
                            </h2>
                            <h4>Bestilt den. <?=dateDisplay($date_of_order);?> </h4>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="images-container" data-column-margin="default" data-midnight="dark" data-bg-mobile-hidden=""
        class="wpb_row vc_row-fluid vc_row standard_section " style="padding-top: 0px; padding-bottom: 0px; ">
        <div class="row-bg-wrap" data-bg-animation="none" data-bg-overlay="false">
            <div class="inner-wrap">
                <div class="row-bg" style=""></div>
            </div>
            <div class="row-bg-overlay"></div>
        </div>
        <div class="col span_12 dark left">
            <div class="vc_col-sm-12 wpb_column column_container vc_column_container col no-extra-padding instance-1"
                data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation=""
                data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color=""
                data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1"
                data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
                <div class="vc_column-inner">
                    <div class="column-bg-overlay-wrap" data-bg-animation="none">
                        <div class="column-bg-overlay"></div>
                    </div>
                    <div class="wpb_wrapper">
                        <div id="q8case1img1" data-midnight="" data-column-margin="default" data-bg-mobile-hidden=""
                            class="wpb_row vc_row-fluid vc_row inner_row standard_section   image-div "
                            style="padding-top: 0px; padding-bottom: 0px; ">
                            <div class="row-bg-wrap">
                                <div class="row-bg   " style=""></div>
                            </div>
                            <div class="col span_12  left">
                                <div class="vc_col-sm-12 wpb_column column_container vc_column_container col child_column no-extra-padding instance-2"
                                    data-t-w-inherits="default" data-shadow="none" data-border-radius="none"
                                    data-border-animation="" data-border-animation-delay="" data-border-width="none"
                                    data-border-style="solid" data-border-color="" data-bg-cover=""
                                    data-padding-pos="all" data-has-bg-color="false" data-bg-color=""
                                    data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation=""
                                    data-delay="0">
                                    <div class="vc_column-inner">
                                        <div class="column-bg-overlay-wrap" data-bg-animation="none">
                                            <div class="column-bg-overlay"></div>
                                        </div>
                                        <div class="wpb_wrapper">

                                            <div class="wpb_text_column wpb_content_element  image-details">
                                                <div class="wpb_wrapper">
                                                    <p>Adobe Animation</p>
                                                    <p>TubeMogul</p>
                                                    <p>120 x 600</p>
                                                </div>
                                            </div>




                                            <div class="wpb_text_column wpb_content_element  image-nr">
                                                <div class="wpb_wrapper">
                                                    <h5>1</h5>
                                                </div>
                                            </div>




                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="q8case1img2" data-midnight="" data-column-margin="default" data-bg-mobile-hidden=""
                            class="wpb_row vc_row-fluid vc_row inner_row standard_section   image-div "
                            style="padding-top: 0px; padding-bottom: 0px; ">
                            <div class="row-bg-wrap">
                                <div class="row-bg   " style=""></div>
                            </div>
                            <div class="col span_12  left">
                                <div class="vc_col-sm-12 wpb_column column_container vc_column_container col child_column no-extra-padding instance-3"
                                    data-t-w-inherits="default" data-shadow="none" data-border-radius="none"
                                    data-border-animation="" data-border-animation-delay="" data-border-width="none"
                                    data-border-style="solid" data-border-color="" data-bg-cover=""
                                    data-padding-pos="all" data-has-bg-color="false" data-bg-color=""
                                    data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation=""
                                    data-delay="0">
                                    <div class="vc_column-inner">
                                        <div class="column-bg-overlay-wrap" data-bg-animation="none">
                                            <div class="column-bg-overlay"></div>
                                        </div>
                                        <div class="wpb_wrapper">

                                            <div class="wpb_text_column wpb_content_element  image-details">
                                                <div class="wpb_wrapper">
                                                    <p>GIF</p>
                                                    <p>Google</p>
                                                    <p>160 x 600</p>
                                                </div>
                                            </div>




                                            <div class="wpb_text_column wpb_content_element  image-nr">
                                                <div class="wpb_wrapper">
                                                    <h5>2</h5>
                                                </div>
                                            </div>




                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="q8case1img3" data-midnight="" data-column-margin="default" data-bg-mobile-hidden=""
                            class="wpb_row vc_row-fluid vc_row inner_row standard_section   image-div "
                            style="padding-top: 0px; padding-bottom: 0px; ">
                            <div class="row-bg-wrap">
                                <div class="row-bg   " style=""></div>
                            </div>
                            <div class="col span_12  left">
                                <div class="vc_col-sm-12 wpb_column column_container vc_column_container col child_column no-extra-padding instance-4"
                                    data-t-w-inherits="default" data-shadow="none" data-border-radius="none"
                                    data-border-animation="" data-border-animation-delay="" data-border-width="none"
                                    data-border-style="solid" data-border-color="" data-bg-cover=""
                                    data-padding-pos="all" data-has-bg-color="false" data-bg-color=""
                                    data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation=""
                                    data-delay="0">
                                    <div class="vc_column-inner">
                                        <div class="column-bg-overlay-wrap" data-bg-animation="none">
                                            <div class="column-bg-overlay"></div>
                                        </div>
                                        <div class="wpb_wrapper">

                                            <div class="wpb_text_column wpb_content_element  image-details">
                                                <div class="wpb_wrapper">
                                                    <p>GIF</p>
                                                    <p>Google</p>
                                                    <p>300 x 600</p>
                                                </div>
                                            </div>




                                            <div class="wpb_text_column wpb_content_element  image-nr">
                                                <div class="wpb_wrapper">
                                                    <h5>3</h5>
                                                </div>
                                            </div>




                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="q8case1img4" data-midnight="" data-column-margin="default" data-bg-mobile-hidden=""
                            class="wpb_row vc_row-fluid vc_row inner_row standard_section   image-div "
                            style="padding-top: 0px; padding-bottom: 0px; ">
                            <div class="row-bg-wrap">
                                <div class="row-bg   " style=""></div>
                            </div>
                            <div class="col span_12  left">
                                <div class="vc_col-sm-12 wpb_column column_container vc_column_container col child_column no-extra-padding instance-5"
                                    data-t-w-inherits="default" data-shadow="none" data-border-radius="none"
                                    data-border-animation="" data-border-animation-delay="" data-border-width="none"
                                    data-border-style="solid" data-border-color="" data-bg-cover=""
                                    data-padding-pos="all" data-has-bg-color="false" data-bg-color=""
                                    data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation=""
                                    data-delay="0">
                                    <div class="vc_column-inner">
                                        <div class="column-bg-overlay-wrap" data-bg-animation="none">
                                            <div class="column-bg-overlay"></div>
                                        </div>
                                        <div class="wpb_wrapper">

                                            <div class="wpb_text_column wpb_content_element  image-details">
                                                <div class="wpb_wrapper">
                                                    <p>GIF</p>
                                                    <p>Google</p>
                                                    <p>300 x 250</p>
                                                </div>
                                            </div>




                                            <div class="wpb_text_column wpb_content_element  image-nr">
                                                <div class="wpb_wrapper">
                                                    <h5>4</h5>
                                                </div>
                                            </div>




                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="q8case1img5" data-midnight="" data-column-margin="default" data-bg-mobile-hidden=""
                            class="wpb_row vc_row-fluid vc_row inner_row standard_section   image-div "
                            style="padding-top: 0px; padding-bottom: 0px; ">
                            <div class="row-bg-wrap">
                                <div class="row-bg   " style=""></div>
                            </div>
                            <div class="col span_12  left">
                                <div class="vc_col-sm-12 wpb_column column_container vc_column_container col child_column no-extra-padding instance-6"
                                    data-t-w-inherits="default" data-shadow="none" data-border-radius="none"
                                    data-border-animation="" data-border-animation-delay="" data-border-width="none"
                                    data-border-style="solid" data-border-color="" data-bg-cover=""
                                    data-padding-pos="all" data-has-bg-color="false" data-bg-color=""
                                    data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation=""
                                    data-delay="0">
                                    <div class="vc_column-inner">
                                        <div class="column-bg-overlay-wrap" data-bg-animation="none">
                                            <div class="column-bg-overlay"></div>
                                        </div>
                                        <div class="wpb_wrapper">

                                            <div class="wpb_text_column wpb_content_element  image-details">
                                                <div class="wpb_wrapper">
                                                    <p>GIF</p>
                                                    <p>Google</p>
                                                    <p>728 x 90</p>
                                                </div>
                                            </div>




                                            <div class="wpb_text_column wpb_content_element  image-nr">
                                                <div class="wpb_wrapper">
                                                    <h5>5</h5>
                                                </div>
                                            </div>




                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="q8case1img6" data-midnight="" data-column-margin="default" data-bg-mobile-hidden=""
                            class="wpb_row vc_row-fluid vc_row inner_row standard_section   image-div "
                            style="padding-top: 0px; padding-bottom: 0px; ">
                            <div class="row-bg-wrap">
                                <div class="row-bg   " style=""></div>
                            </div>
                            <div class="col span_12  left">
                                <div class="vc_col-sm-12 wpb_column column_container vc_column_container col child_column no-extra-padding instance-7"
                                    data-t-w-inherits="default" data-shadow="none" data-border-radius="none"
                                    data-border-animation="" data-border-animation-delay="" data-border-width="none"
                                    data-border-style="solid" data-border-color="" data-bg-cover=""
                                    data-padding-pos="all" data-has-bg-color="false" data-bg-color=""
                                    data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation=""
                                    data-delay="0">
                                    <div class="vc_column-inner">
                                        <div class="column-bg-overlay-wrap" data-bg-animation="none">
                                            <div class="column-bg-overlay"></div>
                                        </div>
                                        <div class="wpb_wrapper">

                                            <div class="wpb_text_column wpb_content_element  image-details">
                                                <div class="wpb_wrapper">
                                                    <p>GIF</p>
                                                    <p>Google</p>
                                                    <p>930 x 180</p>
                                                </div>
                                            </div>




                                            <div class="wpb_text_column wpb_content_element  image-nr">
                                                <div class="wpb_wrapper">
                                                    <h5>6</h5>
                                                </div>
                                            </div>




                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="fws_5eba91e210c04" data-column-margin="default" data-midnight="dark" data-bg-mobile-hidden=""
        class="wpb_row vc_row-fluid vc_row standard_section " style="padding-top: 0px; padding-bottom: 0px; ">
        <div class="row-bg-wrap" data-bg-animation="none" data-bg-overlay="false">
            <div class="inner-wrap">
                <div class="row-bg" style=""></div>
            </div>
            <div class="row-bg-overlay"></div>
        </div>
        <div class="col span_12 dark left">
            <div class="vc_col-sm-12 wpb_column column_container vc_column_container col no-extra-padding instance-8"
                data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation=""
                data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color=""
                data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1"
                data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
                <div class="vc_column-inner">
                    <div class="column-bg-overlay-wrap" data-bg-animation="none">
                        <div class="column-bg-overlay"></div>
                    </div>
                    <div class="wpb_wrapper">

                        <div class="wpb_text_column wpb_content_element  vc_custom_1580390373276">
                            <div class="wpb_wrapper">
                                <h3>Fortæl os om i godkender designet af bannerene, eller om der er noget der skal laves
                                    om.</h3>
                                <h3>Hvis i godkender det, så koder vi dem og sender dem til jer inden den givet
                                    deadline.</h3>
                                <h3>Hvis i ikke godkender designet, så fortæl os hvad der skal laves om, og vi vil
                                    hurtigst muligt sende det nye design.</h3>
                                <h3>Mange tak.</h3>
                            </div>
                        </div>




                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="fws_5eba91e210da7" data-column-margin="default" data-midnight="dark" data-bg-mobile-hidden=""
        class="wpb_row vc_row-fluid vc_row standard_section " style="padding-top: 0px; padding-bottom: 0px; ">
        <div class="row-bg-wrap" data-bg-animation="none" data-bg-overlay="false">
            <div class="inner-wrap">
                <div class="row-bg" style=""></div>
            </div>
            <div class="row-bg-overlay"></div>
        </div>
        <div class="col span_12 dark left">
            <div class="vc_col-sm-12 wpb_column column_container vc_column_container col no-extra-padding instance-9"
                data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation=""
                data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color=""
                data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1"
                data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
                <div class="vc_column-inner">
                    <div class="column-bg-overlay-wrap" data-bg-animation="none">
                        <div class="column-bg-overlay"></div>
                    </div>
                    <div class="wpb_wrapper">

                        <div class="wpb_raw_code wpb_raw_js">
                            <div class="wpb_wrapper">
                                <script src="/wp-content/themes/salient-child/ads/ads.js"></script>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/wp-content/themes/salient-child/bannerform/banner.js"></script>