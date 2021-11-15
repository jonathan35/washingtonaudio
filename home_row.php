<?php


function convert_editor_content($str){
    $from = array(
        '../../photo',
        '<img'
    );
    $to = array(
        ROOT.'photo',
        '<img class="img-fluid"'
    );

    $str = str_replace($from, $to, $str);
    return $str;

}

$layout = array('D1x2-M2x1'=>'Desktop 1 rows x 2 columns & Mobile 2 rows x 1 column', 'D1x3-M3x1'=>'Desktop 1 row x 3 columns & Mobile 3 rows x 1 column');


$rls = sql_read("select * from row where status=? order by position asc", 'i', array(1));

foreach($rls as $rl){?>
<div class="row" style="box-shadow:inset 1px 1px 3px rgba(0,0,0,.2); ">
    <div class="container p-4 p-md-3">
        <?php if($rl['layout'] == 'D1x2-M2x1'){?>
            <div class="row pt-5 pb-5" >
                <div class="col-12 col-md-6">
                    <?php 
                    $pos1 = sql_read("select content from content where row=? and pos=? order by modified desc limit 1", 'is', array($rl['id'], 'd1'));
                    echo convert_editor_content($pos1['content']);?>
                </div>
                <div class="col-12 col-md-6">
                <?php 
                    $pos2 = sql_read("select content from content where row=? and pos=? order by modified desc limit 1", 'is', array($rl['id'], 'd2'));
                    echo convert_editor_content($pos2['content']);?>
                </div>
            </div>
        <?php }elseif($rl['layout'] == 'D1x3-M3x1'){?>
            <div class="row pt-5 pb-5">
                <div class="col-12 col-md-4">
                    <?php 
                    $pos1 = sql_read("select content from content where row=? and pos=? order by modified desc limit 1", 'is', array($rl['id'], 'd1'));
                    echo convert_editor_content($pos1['content']);?>
                </div>
                <div class="col-12 col-md-4">
                <?php 
                    $pos2 = sql_read("select content from content where row=? and pos=? order by modified desc limit 1", 'is', array($rl['id'], 'd2'));
                    echo convert_editor_content($pos2['content']);?>
                </div>
                <div class="col-12 col-md-4">
                <?php 
                    $pos2 = sql_read("select content from content where row=? and pos=? order by modified desc limit 1", 'is', array($rl['id'], 'd3'));
                    echo convert_editor_content($pos2['content']);?>
                </div>
            </div>
            


        <?php }?>
    </div>
</div>
<?php }?>

