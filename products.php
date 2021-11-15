<?php 
require_once 'config/ini.php';
require_once 'config/security.php';
include_once 'head.php';



$categories = sql_read("select * from category where status =? order by position asc, category asc", 's', 1);

$key_cond = '';
$params[] = 1;
$sta_cond = ' status=? ';

if(!empty($_POST['keyword'])){//This is tour type
    $key_cond = " and name like ? ";
    $params[] = "%".$_POST['keyword']."%";
}

$products = sql_read("select * from product where $sta_cond $key_cond order by position asc, modified desc", str_repeat('s',count($params)), $params);

foreach((array)$categories as $cat){
    $en_cat[$cat['id']] = $defender->encrypt('encrypt', $cat['id']);
}




if(!empty($_POST['keyword']) && !empty($_POST['user_keyword'])){
    
    //---------------- Update product_keywords ---------------------
    $product = sql_read("select id from product where $sta_cond $key_cond limit 1", str_repeat('s',count($params)), $params);

    $k['product'] = $product['id'];
    $k['user_keyword'] = $_POST['user_keyword'];
    $k['selected_keyword'] = $_POST['keyword'];
    sql_save("product_keywords", $k);
    

    //---------------- Update product_analytic > search ---------------------
    if(!empty($product['id'])){
        $exist = sql_read("select id, search from product_analytic where product=? limit 1", 'i', $product['id']);

        if(!empty($exist['id'])){
            $analytic['id'] = $exist['id'];
            $analytic['search'] = $exist['search'] + 1;
        }else{
            $analytic['product'] = $product['id'];
            $analytic['search'] = 1;
        }        
        sql_save("product_analytic", $analytic);
    }
}

?>

<html lang="en">

<div class="cat-trigger d-sm-none" onclick="$('.category-panel').toggleClass('category-active'); toggleHeight(); window.scrollTo(0, 0);"><i class="fa fa-search" aria-hidden="true"></i></div>

<script>
function toggleHeight() {
    var cur_height = $('.category-panel').css('height');

    if(cur_height == '0px'){
        $('.category-panel').css('height', 'auto');
    }else{
        $('.category-panel').css('height', '0');
    }
}

</script>

<body class="container-fluid p-0">


    <?php include 'header.php';?>

  
    <div class="section-head">
        <div class="section-header">
            Products
            <div style="color:#FFF; font-size:18px;">
                We have more products that are not listed here, please get in touch with us to find your perfect products!
            </div>
        </div>
    </div>
    
    <div class="my-container">

        

        <div id="record_analytic" style="display:none;"></div>  

        <div class="row wave_rec">

            <div class="col-12 col-md-3 pt-3 category-panel">
                <div class="d-inline d-md-none"><br><br></div>
                <?php include 'search.php'?>

                <div class="pro-cat" onclick="filter_product('.fil-cat');">
                    All Products
                </div>
                <?php 
                foreach((array)$categories as $cat){?>
                    <div class="pro-cat" onclick="open_sub('#cat-<?php echo $en_cat[$cat['id']]?>')">
                        <?php echo $cat['category'];?>
                    </div>
                    <div class="subcat" prv="false" id="cat-<?php echo $en_cat[$cat['id']]?>" style="display:none; ">
                    <?php 

                    $scats = sql_read("select * from sub_category where status =? and category=?", 'ii', array(1, $cat['id']));

                    foreach((array)$scats as $scat){
                        $en_scat[$scat['id']] = $defender->encrypt('encrypt', $scat['id']);
                        ?>
                        <div class="pro-scat" 
                        onclick="filter_product('.fil-<?php echo $en_scat[$scat['id']]?>')">
                            <div class="row">
                                <div class="col-1">
                                    <img src="<?php echo ROOT?>images/chair-20.png">
                                </div>
                                <div class="col-10 pr-0">
                                    <?php echo $scat['sub_category'];?>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                    </div>
                <?php }?>

                <script>
                function open_sub(t){
                  
                    //$('.subcat').hide();
                    $('.subcat').slideUp();

                    let current = $(t).attr('prv');

                    if(current == 'false'){
                        //$(t).removeClass('d-none');
                        $(t).attr('prv', 'true');
                        $(t).slideDown();
                    }else{
                        $(t).attr('prv', 'false');
                    }

                }
                function filter_product(cat){
                    $('.fil-cat').hide();
                    $(cat).fadeIn();

                    $('.category-panel').removeClass('category-active');
                    $('.category-panel').css('height', '0');

                    recordAnalytic();

                }

                function recordAnalytic(){
                    var showlist = [];
                    $( ".fil-cat" ).each(function( index ) {
                        if($( this ).css('display') != 'none'){
                            showlist.push($( this ).attr('ivalue'));
                        }
                    });
                    $( "#record_analytic" ).load( "record_analytic.php", { "showlist": showlist } );
                }

                </script>
            </div>

                      

            <div class="col-12 col-md-9 p-4 pl-2 pr-md-5"><!-- pl-md-5-->
                <div class="row">

                <?php        
                               
                $itemCount=1;
                $maxPerPage=30;

                foreach((array)$products as $product){?>
                    
                    <div class="col-12 col-sm-4 pb-4 ani_card fil-cat fil-<?php echo $en_scat[$product['sub_category']];?> page page<?php echo $itemCount?>" style=" <?php if($itemCount>$maxPerPage){?> display:none;<?php }?>" ivalue="<?php echo $product['id']?>">
                
                    <div style="height:0; ">
                        <div class="p-1 text-right">

                            <?php 
                            if($product['hot_item'] == 'Yes'){?>
                                <div class="feature-icon"><img src="<?php echo ROOT?>images/hot-20.png" title="Hot Item"></div>
                            <?php }?>
                            <?php if($product['best_deal'] == 'Yes'){?>
                            <div class="feature-icon"><img src="<?php echo ROOT?>images/best-20.png" title="Best Deal"></div>
                            <?php }?>
                            <?php if(strtotime($product['clearance_sale_date']) >= strtotime(date('Y-m-d'))){?>
                            <div class="feature-icon"><img src="<?php echo ROOT?>images/clear-20.png" title="Clearance Sale"></div>
                            <?php }?>
                        </div>
                    </div>

                        <div class="product-item">
                            <a href="product_details/<?php echo $str_convert->to_url($product['name']);?>" style="text-decoration:none;">
                            <div class="col-12 mb-2 list-zoom">
                                <div class="bg-cover list-thum" style="background-image:url('<?php echo ROOT.$product['photo'];?>')"></div>
                            </div>
                            <div class="col-12 text-center" style="height:80px;">
                                <div class="truancate">
                                    <?php echo $product['name']; ?>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                <?php 
                $itemCount++;
                }?>
                </div>
                <div class="row pt-5">
                    <?php include ROOT.'paging.php';?>
                </div>
            </div>

            
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
