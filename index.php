<?php 
require_once 'config/ini.php';
require_once 'config/security.php';
include_once 'head.php';

?>


<html lang="en">

<body class="container-fluid p-0">
    <div class=""><!--my-container pb-1-->

        <?php include 'header.php';?>

        <?php include 'banner.php';?>
    </div>

    <div class="row p-5" style="background:#EFEFEF; box-shadow: inset 0 0 4px rgba(0,0,0,.3); font-family: 'avenir-next', Arial, Sans-serif !important; ">
        <div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3 text-center p-0">
            <strong style="font-size: 1rem; color:#064480;">ABOUT US</strong>
            <br><br>
           
            <div style=" font-size:45px; color: black; line-height:1.2;">
                <strong>Washington Audio</strong> the 
                <strong>Leading</strong> Brand in 
                Home and office Audio, Video and Automation solutions.
            </div>
            <div class="col-10 offset-1 pt-4">
            Your dream, our passion to deliver!  We are passionate about bringing good sound and vivid images to your home entertaining room. 
            </div>
            <div class="pt-4">
                <a href="<?php echo ROOT?>page/About-Us" style="text-decoration:none;"><div style="background:#064480; color:white; padding:3px; width:110px; font-size:14px;border-radius:20px; margin:0 auto;">Read More</div></a>
            </div>
         
            
            <div class="p-4"></div>
        </div>
    </div>


    <div class="row"><div class="col-12"><br><br></div></div>
    <div class="row"><div class="col-12 d-none d-md-inline"><br><br></div></div>

    <div class="row ">
        <div class="col-12 text-center" style=" font-family: 'avenir-next', Arial, Sans-serif !important;">
            <div style=" font-size:45px; color: black; line-height:1.2; font-weight: 600;">
                Our Brands
            </div>
            <div class="">
                <?php include 'home_developers.php';?>
            </div>
        </div>
    </div>


    <div class="row"><div class="col-12"><br><br></div></div>
    <div class="row"><div class="col-12 d-none d-md-inline"><br><br></div></div>


    <?php include 'home_row.php';?>
    

           
    <div class="row" style="background:#F0F1F1; font-family: 'avenir-next', Arial, Sans-serif !important;">
        <div class="col-12 p-5">
            <div class="row">
                <div class="col-12 text-center pb-4 mb-3">
                    <div style=" font-size:45px; color: black; line-height:1.2; font-weight: 600;">
                        What's New
                    </div>
                </div>
            </div>

            <div class="row">
                <?php 
                $latests = sql_read("select photo, name, created, description from product order by id desc limit 4");
                foreach($latests as $latest){?>
                <div class="col-12 col-md-3">
                    <div class="square zoom-outter">
                        <div class="square-inner zoom-inner" style="background-image:url('<?php echo $latest['photo'];?>'); background-position:center; background-size:cover; background-repeat:no-repeat; border-radius:4px;">
                        </div>
                    </div>
                    <div class="square" style="">
                        <div class="square-inner">
                            <div style="font-size: 22px; text-transform: capitalize;  margin-bottom: 16px; color: #064480; max-height:72px; overflow:hidden;">
                                <?php echo $latest['name'];?>
                            </div>
                            <div style="color: #09185c; font-size:15px;">
                                <div style="max-height:72px; overflow:hidden;">
                                    <?php echo strip_tags($latest['description']);?>
                                </div>
                            </div>
                            <div class="pt-5">
                                <a href="<?php echo ROOT?>product_details/<?php echo $str_convert->to_url($latest['name'])?>" style="color: #064480; border-bottom:2px solid #064480; font-size:15px; padding-bottom:4px; text-decoration:none;">Read more </a>
                            </div>
                            <div class="pt-4">
                                <img src="<?php echo ROOT?>images/clock.png" class="d-inline">
                                <span style="text-transform: uppercase; font-size:14px; color: #888;">
                                <?php echo date("d.M.Y", strtotime($latest['created']));?>
                                </span>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <?php }?>
                
            </div>
        </div>
    </div>




    <div class="row">
        <div class="col-12">
            <? include 'footer.php';?>        
        </div>
    </div>                
            

</body>

</html>
