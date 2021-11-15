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
    

    <div class="row"><div class="col-12"><br><br><br></div></div>

           
    <div class="my-container why_choose_us scroll_animate" ani-sub=".choose-block" style="border-top:1px solid #CCC; border-bottom:1px solid #CCC; background-color: #eeeeee; background-image:url('images/sound-wave.jpg');  background-repeat: repeat;">
        <div class="row"><div class="col-12"><br><br></div></div>
        <div class="row"><div class="col-12 d-none d-md-inline"><br><br></div></div>
        <div class="row">
            <div class="col-10 offset-1 text-center">
                <div class="h1"><span style="color:white;">WHY CHOOSE US</span></div>

                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <?php 
                            $home_blocks = sql_read('select * from home_block where status=? order by position asc', 'i', 1);
                            foreach((array)$home_blocks as $home_block){

                                $cl = array('#ff9f38', '#abcf29', '#48b867', '#38ab96', '#3d77a1', '#584aa1', '#8e47a8', '#d959b2', '#bd4646');
                                $cl2 = array('#ffc44f', '#b8d453', '#63c77f', '#6bc2b2', '#78a2bf', '#9084d1', '#c68cdb', '#e889cb', '#eb6060');
                            $bg = 'background-image: linear-gradient(to right top, '.$cl[rand(0,8)].', '.$cl2[rand(0,8)].');';
                            ?>
                            <div class="col-12 col-md-4">
                                <div class="choose-block" style="<?php echo $bg?>; opacity:1; background: url('<?php echo $home_block['background']?>'); background-size:cover; background-position:center;">
                                    <?php echo $home_block['block_text']?>
                                </div>
                            </div>
                            <? }?>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="row"><div class="col-12"><br><br></div></div>
        <div class="row"><div class="col-12 d-none d-md-inline"><br><br></div></div>
    </div>


    <div class="my-container">
        <?php include 'row3.php' ?>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="row"><div class="col-12"><br><br><br></div></div>
            <div class="row"><div class="col-12 d-none d-md-inline"><br><br></div></div>

            <? include 'footer.php';?>        
        </div>
    </div>                
            

</body>

</html>
