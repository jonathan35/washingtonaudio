<?php 
require_once 'config/ini.php';
require_once 'config/security.php';
include_once 'head.php';



$als = sql_read("select * from album where status =? order by position asc, album asc", 's', 1);

$album_cond = '';
if(!empty($_GET['al'])){//This is tour type
    $album_name = $_GET['al'].'%';
    $album = sql_read("select id from album where album like ? limit 1", 's', $album_name);
    $album_cond = " where album = '".$album['id']."' ";   
}

$photos = sql_read("select album, photo from album_photo $album_cond order by position asc, id desc");


foreach((array)$als as $al){
    $albums[$al['id']] = $defender->encrypt('encrypt', $al['album']);
}

?>





<html lang="en">

<script>


</script>

<body class="container-fluid p-0">


    <?php include 'header.php';?>

    
    <div class="my-container">

        <div class="row wave_rec">

                      

            <div class="col-12 p-4 pl-2 pr-md-5"><!-- pl-md-5-->
                <div class="row gallery clearfix">

                <?php        
                               
                $itemCount=1;
                $maxPerPage=30;

                foreach((array)$photos as $photo){?>
                   
                    <div class="col-12 col-md-3 page page<?php echo $itemCount?> mb-4" style="">
                        <a href="<?php echo ROOT.$photo['photo']?>" rel="prettyPhoto[<?php echo $photo['album']?>]">
                            <div class="bg-cover" style="width:100%; height:220px; background-image:url('<?php echo ROOT.$photo['photo']?>');"></div>
                        </a>
                    </div>
                <?php 
                $itemCount++;
                }?>
                </div>
                <div class="row pt-5">
                    <?php include ROOT.'paging.php';?>
                </div>
            </div>

      

    
    
    <script type="text/javascript" charset="utf-8">
    $(document).ready(function(){
        $("area[rel^='prettyPhoto']").prettyPhoto();
        
        $(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: true});
        $(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});

        $("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
            custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
            changepicturecallback: function(){ initialize(); }
        });

        $("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
            custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
            changepicturecallback: function(){ _bsap.exec(); }
        });
    });
    </script>



        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="row"><div class="col-12"><br><br><br><br><br></div></div>
            <? include 'footer.php';?>        
        </div>
    </div>                
            




</body>

</html>
