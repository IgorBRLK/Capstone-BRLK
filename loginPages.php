<?php
//This file is the next page after login here is the actual main page of logged in user either guest or actual admin
require_once 'core/init.php';
$user = new User();
if(!$user->isLoggedIn()) {
    Redirect::to('index.php');
}
?>

<!DOCTYPE html>
<html lang="en-US" xmlns="http://www.w3.org/1999/html">

<head>

    <title>UC IT Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8" />
    <!-- Font Used, She wants it to be changed -->
    <link href="CDN/Font.css" rel="stylesheet" type="text/css">
    <!-- CQ Initialization and design files -->

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>

    <script src="js/jquery-min.js"></script>
    <script type="text/javascript" src="js/modernizr-min.js"></script>
    <script src="js/bootstrap.js"></script>


    <link rel="stylesheet" type="text/css" href="css/demo.css" />

    <!-- Bootstrap -->
    <link href="css/bootstrap3.css" rel="stylesheet" media="screen">


    <!-- base styles -->

    <link rel="stylesheet" href="css/br.css" type="text/css">

    <link rel="stylesheet" href="css/print.css" media="print" type="text/css"/>

    <link rel="stylesheet" href="css/static.css" media="screen" type="text/css"/>


    <link rel="stylesheet" href="css/colorbox.css"/>


    <!-- upgrade your browser -->
    <!--[if lt IE 9]>
    <script src="/etc/designs/uc/resources/bootstrap/js/html5shiv.js"></script>
    <script src="/etc/designs/uc/resources/bootstrap/js/respond.js"></script>
    <![endif]-->


    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script>
        $(function(){

// The height of the content block when it's not expanded
            var adjustheight = 80;
// The "more" link text
            var moreText = "+  More";
// The "less" link text
            var lessText = "- Less";

// Sets the .more-block div to the specified height and hides any content that overflows
            $(".more-less .more-block").css('height', adjustheight).css('overflow', 'hidden');

// The section added to the bottom of the "more-less" div
            $(".more-less").append('<p class="continued">[&hellip;]</p><a href="#" class="adjust"></a>');

            $("a.adjust").text(moreText);

            $(".adjust").toggle(function() {
                $(this).parents("div:first").find(".more-block").css('height', 'auto').css('overflow', 'visible');
                // Hide the [...] when expanded
                $(this).parents("div:first").find("p.continued").css('display', 'none');
                $(this).text(lessText);
            }, function() {
                $(this).parents("div:first").find(".more-block").css('height', adjustheight).css('overflow', 'hidden');
                $(this).parents("div:first").find("p.continued").css('display', 'block');
                $(this).text(moreText);
            });
        });

    </script>



</head>

<body class="responsive  NoNav">

<a class="responsive-only sr-only" href="#main">Skip to main content</a>

<div class="ContentLayout">

    <header class="TopLayout">
        <div id="header">
            <div class="parsys iparsys PageTop"><div class="iparys_inherited"><div class="parsys iparsys PageTop">
            </div>
            </div><div class="GlobalNavResponsive section">
                <link rel="stylesheet" href="css/clientlibrary.css" type="text/css">

                <div class="navbar navbar-inverse globalnav" role="navigation">
                    <div class="navbar-header visible-xs">
                        <button type="button" class="nav-toggle navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="sr-only">Toggle Tools navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <!-- responsive header DD -->
                        <button type="button" class="toggle-topnav navbar-toggle" data-toggle="collapse" data-target=".navbar-topnav-collapse">
                            <span class="sr-only">Toggle Site Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <button type="button" class="search-toggle navbar-toggle" data-toggle="collapse" data-target=".navbar-search-collapse">
                            <span class="glyphicon glyphicon-search"></span>
                            <span class="sr-only">Toggle Search</span>
                        </button>


                        <a class="navbar-brand visible-xs" href="http://uc.edu" target="_top">University of Cincinnati</a>
                    </div>
                    <div class="">
                        <ul class="nav navbar-nav collapse navbar-collapse navbar-ex1-collapse">
                            <li><a class="NavLink" href="http://www.uc.edu?from=globalnav">UC Home</a></li>
                            <li><a class="NavLink" href="http://www.uc.edu/visitors.html?from=globalnav">Visit UC</a></li><li><a class="NavLink" href="http://www.uc.edu/foundation.html?from=globalnav">Support&nbsp;UC&nbsp;<span class="glyphicon glyphicon-play"></span></a></li><li><a class="NavLink" href="https://ucdirectory.uc.edu/?from=globalnav">Directories</a></li><li class="dropdown">
                            <a href="#" class="dropdown-toggle NavLink" data-toggle="dropdown">UC Tools <b class="caret"></b></a>
                            <ul class="dropdown-menu">

                                <li class="ToolDropItem"><a class="ToolDropLink" href="https://canopy.uc.edu?from=uctools">Canopy & Blackboard</a></li>

                                <li class="ToolDropItem"><a class="ToolDropLink" href="http://onestop.uc.edu?from=uctools">OneStop</a></li>

                                <li class="ToolDropItem"><a class="ToolDropLink" href="https://mail.uc.edu?from=uctools">Student Email</a></li>
                                <li class="ToolDropItem"><a class="ToolDropLink" href="https://ucowa.uc.edu/?from=uctools">UCMail</a></li>
                                <li class="ToolDropItem"><a class="ToolDropLink" href="https://uc.doublemap.com/map/">Shuttle Tracker</a></li>
                                <li class="ToolDropItem"><a class="ToolDropLink" href="https://ucfilespace.uc.edu/?from=uctools">UCFileSpace</a></li>
                                <li class="ToolDropItem"><a class="ToolDropLink" href="https://www.ucflex.uc.edu/">UC Flex/ESS</a></li>
                                <li class="ToolDropItem"><a class="ToolDropLink" href="http://www.uc.edu/pss/?from=uctools">Password Help</a></li>
                                <li class="ToolDropItem"><a class="ToolDropLink" href="https://sslvpn.uc.edu?from=uctools">UC VPN</a></li>
                            </ul>
                        </li>
                        </ul>


                        <form method="get" class="navbar-form navbar-right collapse navbar-collapse navbar-search-collapse" action="http://search.uc.edu/search">
                            <div class="form-group">
                                <label class="sr-only" for="q">Query String</label><input type="text" class="search-query form-control gsaSearch span2" name="q" maxlength="256" id="q" placeholder="Search Clermont" />
                            </div>
                            <input type="submit" name="btnG" value="Go" class="btn btn-danger" />
                            <input type="hidden" name="site" value="clermont" />
                            <input type="hidden" name="client" value="clermont_frontend" />
                            <input type="hidden" name="output" value="xml_no_dtd" />
                            <input type="hidden" name="proxystylesheet" value="clermont_frontend" />
                            <input type="hidden" name="oe" value="utf8" />
                            <input type="hidden" name="ie" value="utf8" />
                            <script type="text/javascript">

                                var peopleAction = "http://ucdirectory.uc.edu/PeopleSearch.asp";
                                var searchAction = "http://search.uc.edu/search";



                                jQuery("input[name='site']").val(jQuery("input[name='site']").val().toUpperCase());

                                function setAction(action,method)
                                {
                                    jQuery(".navbar-form ").attr("action",action);
                                    jQuery(".navbar-form ").attr("method",method);

                                }
                                function setWatermark(watermark)
                                {
                                    jQuery(".gsaSearch").attr("placeholder",watermark);
                                }
                                function setCollection(frontend)
                                {
                                    jQuery("input[name='client']").val(frontend + "_frontend");
                                    jQuery("input[name='proxystylesheet']").val(frontend + "_frontend");
                                    jQuery("input[name='site']").val(frontend.toUpperCase());
                                }


                                var theDiv = jQuery("<ul class='dropdown-menu searchChoice' role='menu' aria-labelledby='dropdownMenu'></ul>");


                                if("clermont" != "")
                                {
                                    theDiv.append("<li><a  href='#' id='dept' class='gsa' _collection='clermont' _watermark='Search Clermont'><b class='icon-search'></b>&nbsp;Search Clermont</a></li>");
                                }

                                theDiv.append("    <li><a href='#' id='mainselector' class='gsa' _collection='ucmain' _watermark='Search UC'><b class='icon-asterisk'></b>&nbsp;Search UC Web</a></li>");
                                theDiv.append("   <li><a  href='#' id='peopleselector' class='people'  _watermark='Last Name, First Name'><b class='icon-user'></b>&nbsp;Search people</a></li>");
                                theDiv.append("    <li><a  href='#' id='noselector' class='close'>&nbsp;close</a></li>");



                                jQuery("body").append(theDiv);
                                theDiv.css("position","absolute");

                                theDiv.css("display","none");



                                jQuery(".searchChoice a").click(function(){



                                    theDiv.hide();


                                    jQuery(".gsaSearch").focus();
                                    if(jQuery(this).hasClass("close"))
                                        return;
                                    if(jQuery(this).hasClass("gsa"))
                                    {
                                        setCollection(jQuery(this).attr("_collection"));
                                        setAction(searchAction,"get");
                                        jQuery(".gsaSearch").attr("name","q");
                                    }
                                    if(jQuery(this).hasClass("people"))
                                    {
                                        setAction(peopleAction,"post");
                                        jQuery(".gsaSearch").attr("name","formInputBox");

                                    }
                                    setWatermark(jQuery(this).attr("_watermark"));
                                    //give searchbox focus

                                    return false;
                                });


                                jQuery(".gsaSearch").click(function(){

                                    theDiv.slideDown(200);
                                    theDiv.css("top",jQuery(".gsaSearch").eq(0).offset().top + 30);
                                    theDiv.css("left",jQuery(".gsaSearch").eq(0).offset().left);

                                });

                                jQuery(".gsaSearch").keydown(function(k) {

                                    if(k.which != 40)
                                        return;

                                    theDiv.slideDown(200);
                                    theDiv.find("a").eq(0).focus();
                                });

                            </script>


                        </form>

                    </div><!-- /.nav-collapse -->
                </div><!-- /.navbar-inner -->

                <script>
                    jQuery(document).ready(function() {

                        if(jQuery("#respbanner .theNav").length > 0 || jQuery(".NavLayout .navBase").length > 0 || jQuery(".DropdownNav").length > 0 || jQuery(".activateMenuLink").length > 0)
                        {
                            jQuery(".activateMenuLink div").hide(0);
                            jQuery(".cq-wcm-edit .activateMenuLink div").show(0);

                            if(!jQuery("body").hasClass("NoNav") || jQuery("#respbanner").hasClass("bannerNav") || jQuery("#respbanner").hasClass("navigation") || jQuery(".DropdownNav").length > 0 || jQuery(".activateMenuLink").length > 0)
                            {

                                jQuery("header .GlobalNavResponsive button.toggle-topnav").css("display","block");
                                jQuery("header .GlobalNavResponsive button.toggle-topnav").addClass("visible-xs");
                                giveFocus();
                            }
                        }



                        function giveFocus()
                        {
                            if(jQuery("header .GlobalNavResponsive .navbar-search-collapse").css("display") == "block")
                                jQuery("header .GlobalNavResponsive .form-group input").eq(0).focus();
                        }
                    });

                </script>
            </div>
                <div class="ResponsiveHeader section">


                    <div id="respbanner" class="banner clearfix black banner bannerNav">
                        <h1><a href="http://uc.edu">University of Cincinnati</a></h1>


                        <div class="theBanner"><a href="http://www.ucclermont.edu/.html">
                            <img class="visible-xs" src="images/banner-cler-tnr-full.png" alt="UC Clermont"/>

                            <img class="hidden-xs" src="images/banner-cler-tnr.png" alt="UC Clermont"/>
                        </a></div>
                        <div class="theNav">
                            <nav class="navbar navbar-default" role="navigation">
                                <!-- Brand and toggle get grouped for better mobile display -->

                                <!-- Collect the nav links, forms, and other content for toggling -->
                                <div class="collapse navbar-collapse navbar-topnav-collapse">
                                    <ul class="nav navbar-nav">
                                        <li class=""><a href="http://www.ucclermont.edu/admissions.html">Admissions</a></li><li class=""><a href="http://www.ucclermont.edu/academics.html">Academics</a></li><li class=""><a href="http://www.ucclermont.edu/about.html">About</a></li><li class=""><a href="http://www.ucclermont.edu/library.html">Library</a></li><li class=""><a href="http://www.ucclermont.edu/athletics.html">Athletics</a></li><li class=""><a href="http://www.ucclermont.edu/community_arts.html">Community Arts</a></li>
                                    </ul>
                                </div><!-- /.navbar-collapse -->
                            </nav>
                        </div>


                    </div></div>

            </div>

            <div class="PageContent parsys"><div class="parbase image section globalcomponent">
                <div class="clearfixresponsive">
                    <div class="image clearnoBottomPadding noBottomPaddingImage imagecomponent">
                        <img title="UC Clermont Students" alt="UC Clermont Students" class="cq-dd-image" src="http://www.ucclermont.edu/_jcr_content/PageContent/image/image.img.jpg/1426613019432.jpg">
                    </div>

                </div>

                <div class="clear"></div>
            </div>
            </div>

            <div class="parsys iparsys PageTopBottom"><div class="section"><div class="new"></div>
            </div><div class="iparys_inherited"><div class="parsys iparsys PageTopBottom">
            </div>
            </div>
            </div>

        </div>
    </header>
    <div id="content" class="clearfix">
        <div class="NavLayout">
            <div class="collapse navbar-collapse navbar-topnav-collapse">
                <div class="parsys NavTop iparsys"><div class="iparys_inherited"><div class="parsys NavTop iparsys">
                </div>
                </div><div class="parbase responsiveParsys section globalcomponent">

                    <div id="responsiveparsys" class="noborder " ><div class="parsys"><div class="RecursiveNavigation section">
                        <div class="recursiveNav1 navBase"
                                ></div>
                        <script language="javascript">

                        </script></div>
                    </div>
                    </div></div>

                </div>

            </div>
        </div>
        <main id="main">
            <div class="MainLayout">

                <div class="MainTop parsys iparsys"><div class="section breadcrumb"></div>
                    <div class="section"><div class="new"></div>
                    </div><div class="iparys_inherited"><div class="MainTop parsys iparsys">
                    </div>
                    </div>
                </div>

                <?php
                if($user->hasPermission('student')){ ?>
                <h1 class="unsuppressed"><a href="loginPages.php">Welcome to UC Clermont IT!</a>
                <?php } ?>

                    <?php
                    if($user->hasPermission('student')){ ?>

                       <div id="cssmenu" style="float: right !important;">
                           <ul id="navigation">
                               <li><a href="#page1">Freshman</a></li>
                               <li><a href="#page2">Sophmore</a></li>
                               <li><a href="#page3">Alumni</a></li>
                               <li class="last"><a href="logout.php">Logout</a></li>
                               <li id="noHover"><img id="loading" src="images/ajax_load.gif" alt="loading" />
                               </li>
                           </ul>
                       </div>

                        <?php } ?>
                      </h1>

                <!--this script is the ajax one that changes pages-->

                <div class="parsys MainContent" id="pageContent">

                    <?php
                    if(Session::exists('updated')){
                        echo '<h3>' . Session::flash('updated') . '</h3>' ; } ?>

                   <?php if($user->hasPermission('admin')){ ?>


                       <h1>Administrative Tools

                           <div id="cssmenu" style="float: right !important;">
                               <ul id="navigation">
                                   <li><a href="SMF/index.php">Forum</a> </li>
                                   <li class="last"><a href="logout.php">Logout</a></li>

                               </ul>
                           </div>

                       </h1>

                       <div class="row" style="padding-left: 10px;">

                           <div class="col-md-6">

                               <p>Run your file here first to check if a users already exists.</p>
                               <form action="checkUser.php" method="post" enctype="multipart/form-data">
                                   <input style="padding-bottom: 10px;" type="file" name="file" />
                                   <input type="submit" value="Check" />
                               </form>
                           </div>

                           <div class="col-md-6">

                               <p>Once the file gets the ok, upload in this section to the database</p>
                               <form action="upload.php" method="post" enctype="multipart/form-data">
                                   <label">Select Group</label>
                                   <select name="formGroup" required title="Please select a group carefully">
                                       <option value="">Group</option>
                                       <option value="2">Admin</option>
                                       <option value="1">Student</option>
                                   </select>

                                   <input style="padding-bottom: 10px; padding-top: 10px;" type="file" name="file" />

                                   <input type="submit" value="upload" />
                               </form>

                           </div>

                       </div>


                       <?php

                       if(Session::exists('adminTools')){
                           echo '<h3 style="color: #940116">' . Session::flash('adminTools') . '</h3>' ; } ?>

                   <?php } ?>

                    <?php
                   if($user->hasPermission('guest')){ ?>
                        <h1> Hello Guest</h1>
                       <p>not sure what to show you yet Muhahaahahaha.</p>
                       <a href="logout.php">Logout</a>
                  <?php  } ?>

                    <?php
                   if ($user->hasPermission('student')){ ?>
                      <h1> Hello Student</h1>



                    <?php } ?>


                </div>



                <div class="clear"></div>



                </div>


                    <div style="clear:both"></div>



        </main>


        <!--body end tag-->
    </div>

    <footer class="FooterLayout">
        <div id="footer">

            <div class="parsys iparsys FooterTop"><div class="iparys_inherited"><div class="parsys iparsys FooterTop">
            </div>
            </div>
            </div>

            <div class="parsys FooterLeftContent"><div class="par section">
            </div>
                <div class="parbase script section globalcomponent"><style>
                    .hidespecial
                    {
                        display: none
                    }
                </style></div>
            </div>

            <div class="FooterBottom">
                <div class="parsys PageBottom iparsys"><div class="text parbase section">
                    <div class="textcomponent">

                        <div class="text"><p><a href="mailto: clermont.information@uc.edu">Contact Us</a>&nbsp;|&nbsp;<a href="http://www.ucclermont.edu/">UC Clermont College</a>&nbsp;| 4200 Clermont College Drive, Batavia, Ohio 45103<br>
                            College Information: 513-732-5200</p>
                        </div></div></div>
                    <div class="section"><div class="new"></div>
                    </div><div class="iparys_inherited"><div class="parsys PageBottom iparsys">
                    </div>
                    </div>
                </div>

                    

<span class="copyright"><a href="http://www.ipo.uc.edu/index.cfm?fuseaction=home.infringement">
    Copyright Information</a> &copy; 2014 <a href="http://www.uc.edu/">University of Cincinnati</a></span>
            </div>
        </div>
    </footer>

</div>



</body>
</html>