<?php 
require_once 'config/ini.php';
require_once 'config/security.php';
require_once 'config/str_convert.php';
include_once 'head.php';



if(!empty($_POST['submit']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['message'])){
    if(empty($_POST['g-recaptcha-response'])){
        $_SESSION['session_msg'] = '<div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close" 
        style="position:relative; top:-2px;">×</a>
        Please fill in captcha.</div>';
    }else{

        $to      = 'info@sepandco.com.my';
        $subject = 'Website Enquiry';
        $headers[] = 'From: sepandco.com.my';
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $message = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>'.$subject.'</title>
        </head>
        <body>
            Dear Staff,
            '.$_POST['name'].' sent a message to you from sepandco.com.my. You can login CMS to view or view below:<br><br>            
            Name: '.$_POST['name'].'<br><br>
            Product: '.$_POST['product'].'<br><br>
            Email: '.$_POST['email'].'<br><br>
            Message: '.$_POST['message'].'<br><br>
        </body>
        </html>';
        
        unset($_POST['submit'], $_POST['g-recaptcha-response']);
        $_POST['status'] = 'New';
        $_POST['date'] = date('Y-m-d H:i:s');
        if(sql_save('message', $_POST)){

            $_SESSION['session_msg'] = '<div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close" 
            style="position:relative; top:-2px;">×</a>
            Thank you for sent us the message, we will reply you through email soon.</div>';

            mail($to, $subject, $message, implode("\r\n", $headers));
        }
        
    }
}

?>



<html lang="en">

<body class="container-fluid p-0">
    <div class="my-container">

        <?php include 'header.php';?>
        <div style="height:66px;">
            <div class="page_title">
                Product
            </div>
        </div>

        <div class="row"><div class="col-12"><br></div></div>
        
        <?php 
        if(!empty($_GET['p'])){
            $product_name = $str_convert->to_query($_GET['p']);
            $product = sql_read("select * from product where status=1 and name like ? limit 1", 's', '%'.$product_name.'%');
            $photos = sql_read("select * from photos where parent_table=? and parent_id=?", 'si', array('product', $product['id']));
      
        }
        ?>
        <div class="row wave_rec">
            <div class="col-12">
                <div class="p-2">
                    <a href="../product" style="text-decoration:none;">
                        <i class="fa fa-chevron-circle-left" aria-hidden="true" style="font-size:28px; opacity:.5; vertical-align: middle; top:-2px; position:relative;"></i>
                        Back to Listing
                    </a>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="row p-4">

                            <?php 
                            if(empty($_GET['p'])){?>
                                <div class="col-12">No product found</div>
                            <?php }else{?>
                                <div class="col-12 col-md-7">
                                    <div class="row">
                                        <div class="col-12 p-0 zoom-outter" style="border:1px solid #CCC; ">
                                            <img src="<?php echo ROOT.$product['photo'];?>" class="img-fluid pro-bg zoom-inner">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3 col-md-2 zoom-outter thum-frame  p-0">
                                            <div class="bg-cover pro-thum zoom-inner" style="height:90px;background-image:url('<?php echo ROOT.$product['photo'];?>');"></div>
                                        </div>
                                        <?php foreach((array)$photos as $photo){?>
                                            <div class="col-3 col-md-2 zoom-outter thum-frame p-0">
                                                <div class="bg-cover pro-thum zoom-inner" style="height:90px;background-image:url('<?php echo ROOT.$photo['photo'];?>');"></div>
                                            </div>
                                        <?php }?>
                                        <script>
                                        $('.pro-thum').hover(function(){
                                            switch_photo(this);
                                        });
                                        $('.pro-thum').click(function(){
                                            switch_photo(this);
                                        });
                                        function switch_photo(target){
                                            var bg = $(target).css('background-image');
                                            var bg_to_src = bg.replace('url("','').replace('")','');
                                            $('.pro-bg').attr('src', bg_to_src);
                                        }
                                        </script>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col d-none d-md-block pt-5">
                                            <?php include 'related.php';?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-5 pt-5 pt-md-0 pr-md-5 pl-md-4 text-left">
                                    <?php if(!empty($product['name'])){?>
                                        <div class="row">
                                            <h2 class="p-1"><?php echo $product['name'];?></h2>
                                        </div>
                                    <?php }?>
                                    <?php if($product['new_arrival'] == 'Yes'){?>
                                        <div class="row">
                                            <div class="p-1">New Arrival</div>
                                        </div>
                                    <?php }?>
                                   
                                    <?php if(!empty($product['promotion_until'])){?>
                                        <div class="row">
                                            <div class="p-1">
                                            Promotion end at <?php echo date('d/m/Y', strtotime($product['promotion_until']));?>
                                            </div>
                                        </div>
                                    <?php }?>
                                    
                                    <div class="row">
                                        <div class="p-1">
                                        Stock: <?php if(!empty($product['in_stock'])) echo 'Yes'; else echo 'No';?>
                                        </div>
                                    </div>
                                    <?php if(!empty($product['pdf'])){?>
                                    <div class="row">
                                        <div class="p-1">
                                            <a href="<?php echo ROOT.$product['pdf'];?>" target="_blank" style="text-decoration:none;">
                                                <div style="border:2px solid #ff8a8a; padding:2px 4px 1px 2px;">
                                                    <img src="<?php echo ROOT?>images/pdf-24.png" style="position:relative; top:-3px;">
                                                    DOWNLOAD PDF
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <?php }?>
                                   
                                    <div class="row">
                                        <div class="p-1">
                                            <?php if(strtotime($product['clearance_sale_date']) >= strtotime(date('Y-m-d'))){?>
                                                <div class="feature-icon"><img src="<?php echo ROOT?>images/clear-20.png" title="Clearance Sale"></div>
                                                CLEARANCE:<br> 
                                                <?php echo $product['clearance_sale_title'];?>
                                                <br>
                                                END DATE: 
                                                <?php echo $product['clearance_sale_date'];?>
                                            <?php }?>
                                        </div>
                                    </div>
                                    <?php if($product['qr_code']){?>
                                    <div class="text-center">
                                        <img src="<?php echo ROOT.$product['qr_code'];?>" class="img-fluid">
                                    </div>
                                    <?php }?>

                                    <?php if(!empty($product['description'])){?>
                                        <div class="row">
                                            <div class="col-12 pt-4">
                                                <?php 
                                                $product['description'] = str_replace(array('../../', '<img'), array(ROOT, '<img class="img-fluid"'), $product['description']);                
                                                echo $product['description'];?>                                    
                                            </div>
                                        </div>
                                    <?php }?>


                                    <div class="row"><div class="col-12"><br></div></div>
                                    <div class="row">
                                        <div class="col-12 p-2 pl-4 pr-4">
                                            <h1>Leave a message</h1>
                                        </div>
                                    </div>
                                    <form action="" class="form-group" method="post">
                                        <div class="row">
                                            <div class="col-12 p-2 pl-4 pr-4">
                                                <input type="text" name="product" value="<?php echo $product['name'];?>" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 p-2 pl-4 pr-4">
                                                <input type="text" name="name" placeholder="Name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 p-2 pl-4 pr-4">
                                                <input type="email" name="email" placeholder="Email" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 p-2 pl-4 pr-4">
                                                <input type="text" name="contact" placeholder="Contact number" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 p-2 pl-4 pr-4">
                                                <textarea type="text" name="message" placeholder="Message" class="form-control" required></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 p-2 pl-4 pr-4">
                                                <div id="recaptcha" title="no"></div>
                                            </div>
                                        </div>

                                        

                                        <div class="row">
                                            <div class="col-12 p-2 pl-4 pr-4">
                                                <input type="submit" name="submit" value="Send Message" class="btn btn-primary pl-4 pr-4">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php }?>

                        </div>
                    </div>

                    <div class="d-md-none p-5">
                        <?php include 'related.php';?>
                    </div>
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
<?php include 'config/session_msg.php';?>
