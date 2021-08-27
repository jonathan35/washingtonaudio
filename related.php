<div class="pt-5"><br><br><br></div>
<div class="col-12 pl-5 pl-md-0">
    <h2>Related Products of Interest</h2>
</div>
<div class="row">
    <?php 
    $relateds = sql_read("select id, name, photo from product where category=? or sub_category=? order by created desc limit 6", 'ii', array($product['category'], $product['sub_category']));
    
    foreach($relateds as $related){?>
        
        <div class="col-12 col-md-4 p-2">
        <a href="<?php echo ROOT?>product_details/<?php echo $str_convert->to_url($related['name']);?>" style="text-decoration:none;">
            <div style="border:1px solid #CCC; ">
                <div class="list-zoom" style="height: 200px; border-bottom:1px solid #CCC; " >
                    <div class="bg-cover list-thum" style="background-image:url('<?php echo ROOT.$related['photo'];?>'); height: 200px;"></div>
                </div>
                <div style="padding:5px 10px; text-align:center; height:60px; overflow:hidden;"><?php echo $related['name']?></div>
            </div></a>
        </div>
        
    <?php }?>
</div>