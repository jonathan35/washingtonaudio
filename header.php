<style>
.header {
    z-index: 10;
    width: 100%;
    position: relative;
    background: white; 
    box-shadow: 2px 2px 2px rgba(0,0,0,0.2);
}
.menu-inner a {
    color: black;
}
@media (max-width: 575px) {
    .menu-inner a {
        color:white;
    }
}


<?php if(basename($_SERVER["SCRIPT_FILENAME"], '.php') == 'index'){?>
    .header {
        position: absolute;
        background: linear-gradient(180deg, rgba(0, 2, 128, 0.8) 0%, rgba(0,2,128,.3) 50%, rgba(0,0,0,0) 100%);
        text-shadow: 0 0 10px rgba(0,0,0,1);
        box-shadow: none;
    }
    .menu-inner a {
        color:white;
        text-shadow: 0 0 10px rgba(0,0,0,1);
    }
    .burger-menu {
        color:#FFF;
    }
<?php }?>
</style>
<div class="header">
    <div class="row">
        <div class="col-4 p-3 pt-md-4 d-md-none">
            <button class="navbar-toggler menu-toggler pb-3" type="button" onclick="$('#toggleMenu, .page_title').fadeToggle();">
                <!--data-toggle="collapse" data-target="#toggleMenu" aria-controls="toggleMenu" aria-expanded="false" aria-label="Toggle navigation"-->
                <span class="navbar-toggler-icon">
                    <i class="fas fa-bars burger-menu"></i>
                </span>
                <!--
                <span class="burger-menu-txt d-none d-md-inline">Menu</span>-->
            </button>
        </div>

        <div class="col-4 col-md-3 p-2 offset-md-1 text-center text-md-left">
            <a href="<?php echo ROOT?>home">
                <img src="<?php echo ROOT?>images/logo.png" alt="" class="d-none d-md-inline img-responsive" style="-webkit-filter: drop-shadow(2px 2px 5px rgba(0,0,0,.8));
                filter: drop-shadow(2px 2px 5px rgba(0,0,0,.8)); <?php if(basename($_SERVER["SCRIPT_FILENAME"], '.php') != 'index'){?>max-height:66px;<?php }?>">

                <img src="<?php echo ROOT?>images/logo.png" alt="" class="d-md-none" style="-webkit-filter: drop-shadow(2px 2px 5px rgba(0,0,0,.8));
                filter: drop-shadow(2px 2px 5px rgba(0,0,0,.8)); max-height:55px; ">


            </a>
        </div>
        
        <!--
        <div class="col-4 text-right social-icon p-3 pl-0 pt-4">
            <div class="pt-md-2">
                <a href="https://m.facebook.com/" target="_blank"><img src="<?php echo ROOT?>images/facebook-circle.svg"></a>
                <a href="https://www.instagram.com/" target="_blank"><img src="<?php echo ROOT?>images/instagram-circle.svg"></a>
                <a href="https://wa.link/60168653947" target="_blank"><img src="<?php echo ROOT?>images/whatsapp-circle.svg"></a>
            </div>
        </div>-->


        <div class="col-12 col-md-7 collapse d-md-inline" id="toggleMenu" style="padding-top:20px;"><!-- -->
            <div class="menu-inner">
                <div class="row">
                    <!--<div class="d-none d-md-inline col-md"></div>-->
                    <div class="col-12 col-md p-2">
                        <a href="<?php echo A_ROOT?>home">Home</a>
                    </div>  
                    <div class="col-12 col-md p-2">
                        <a href="<?php echo ROOT?>products">Products</a>
                        
                    </div>
                    <div class="col-12 col-md p-2" id="gallery-menu">
                        <a href="<?php echo ROOT?>gallery">Gallery</a>
                        <div class="sub-menu" id="gallery-album">
                            <div class="sub-menu-inner">
                            <?php 
                            $albums = sql_read("select * from album order by album asc");
                            
                            foreach($albums as $album){?>
                                <a href="<?php echo ROOT?>gallery/<?php echo $str_convert->to_url($album['album'])?>">
                                    <div class="pb-1 pt-1">
                                    <?php echo strtolower($album['album']);?></div>
                                </a>
                            <?php }?>
                            </div>
                        </div>
                    </div>
                    <?php /*
                    <div class="col-12 col-md p-2">
                        <a href="<?php echo ROOT?>news">News</a>
                    </div>     */?>                  
                    <div class="col-12 col-md p-2">
                    <a href="<?php echo ROOT?>contact_us">Contact Us</a>
                    </div>
                    <?php 
                    $pages = sql_read('select * from pages where status = ? order by position asc, id desc', 'i', 1);
                    foreach((array)$pages as $page){?>
                    <div class="col-12 col-md p-2">
                        <a href="<?php echo ROOT.'page/'.$str_convert->to_url($page['title'])?>" style="text-transform: capitalize;"><?php echo $page['title']?></a>
                    </div>
                    <?php }?>
                    <!--<div class="d-none d-md-inline col-md"></div>-->
                </div>
            </div>

        </div>


    </div>
    <script>

$('#gallery-menu').hover(function(){
    
    //var i = $(this).attr('child');
    $('#gallery-album').fadeToggle();
})

    </script>

    
</div>