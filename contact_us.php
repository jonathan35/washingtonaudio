<?php 
include_once 'head.php';

$contact_us = sql_read("select * from contact_us where id = ? limit 1", 'i', 1);




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
            <title>Document</title>
        </head>
        <body>
            Dear Staff,
            '.$_POST['name'].' sent a message to you from sepandco.com.my. You can login CMS to view or view below:<br><br>
            Company/Organisation: '.$_POST['company'].'<br><br>
            Name: '.$_POST['designation'].' '.$_POST['name'].'<br><br>
            Property: '.$_POST['property'].'<br><br>
            Email: '.$_POST['email'].'<br><br>
            Address: '.$_POST['address'].'<br><br>
            Message: '.$_POST['message'].'<br><br>
        </body>
        </html>';
        
        unset($_POST['submit'], $_POST['g-recaptcha-response']);
        $_POST['status'] = 'New';
        $_POST['date'] = date('Y-m-d H:i:s');
        if(sql_save('message_contact', $_POST)){

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


    <?php include 'header.php';?>

    <div class="section-head">
        <div class="section-header">
            Contact Us
        </div>
    </div>
    
    <div class="my-container">
        <div class="row wave_rec">        
            <div class="col-12 p-4">


                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.4189545444347!2d110.36279531419127!3d1.5175373614378205!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31fba717c2313b5f%3A0x49d570dec075c958!2sWashington%20Audio!5e0!3m2!1sen!2smy!4v1635303860098!5m2!1sen!2smy" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>

                <div class="row pt-5">
                    <div class="col-12 col-md-7 p-4">
                        <?php
                        $contact_us['content'] = str_replace(array('../../', '<img'), array(ROOT, '<img class="img-fluid"'), $contact_us['content']);                
                        echo $contact_us['content'];?>
                    </div>
                    <div class="col-12 col-md-4 offset-md-1">

                        <form action="" class="form-group" method="post">
                            <div class="row">
                                <div class="col-12 p-2 pl-4 pr-4">
                                    <input type="text" name="company" placeholder="Company / Organisation" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 p-2 pl-4 pr-4">
                                    <select name="designation" class="form-control">
                                        <option value="Mr.">Mr.</option>
                                        <option value="Ms.">Ms.</option>
                                        <option value="Mdm.">Mdm.</option>
                                        <option value="Dr.">Dr.</option>
                                    </select>
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
                                    <input type="text" name="address" placeholder="Address" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 p-2 pl-4 pr-4">
                                    <input type="text" name="contact" placeholder="Contact number" class="form-control">
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

