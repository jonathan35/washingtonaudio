<?php 
require_once '../../config/ini.php'; 
require_once '../../config/security.php';
require_once '../../config/str_convert.php';
require_once '../../config/image.php';
//include '../row/savelog.php';



session_start();
if($_SESSION['validation']=='YES'){
}else{
	header("Location:../authentication/login.php");
}

$table = 'row';
$module_name = 'Row Layout';
$php = 'row';
$folder = 'content';
$add = true;
$edit = true;
$tinymce_photo = true;
$list = true;
$list_method = 'list';
$sort = ' order by position ASC, id DESC';

$keyword = false;//Component to search by keyword
$keywordMustFullWord=false;
$keywordFields=array('name', 'username');

$actions=array('Delete', 'Display', 'Hide');//'Display', 'Hide'
$msg['Delete']='Are you sure you want to delete?';
$msg['Display']='Are you sure you want to display?';	$db['Display']=array('status', '1');
$msg['Hide']='Are you sure you want to hide?';			$db['Hide']=array('status', '2');
$msg['Activate']='Are you sure you want to activate?';	$db['Activate']=array('status', '1');
$msg['Suspend']='Are you sure you want to suspend?';	$db['Suspend']=array('status', '0');

$unique_validation=array();


$fields = array('id', 'layout', 'position', 'status');//navigator
$value = array();
$type = array();
$width = array();//width for input field
$placeholder = array();

#####Design part#######
$back = false;// "Back to listing" button, true = enable, false = disable
$fic_1 = array(0=>array(4));//fic = fiels in column, number of fields by column $fic_1 normally for add or edit template
$fic_2 = array('5', '1');//fic = fiels in column, number of fields by column $fic_2 normally for list template

foreach((array)$fields as $field){
	$value[$field] = '';
	$type[$field] = 'text';
	$placeholder[$field] = '';
	$required[$field] = '';
}
/* Tag module uses session*/
$type['tag'] = 'tag';
$_SESSION['tag_name']='tag';//name for input table field.
$_SESSION['tag_module']=$table;
$_SESSION['module_row_id']='';
if(!empty($_GET['id'])){
	$_SESSION['module_row_id']=base64_decode($_GET['id']);
}

$attributes['position'] = array('placeholder' => 'A number for sorting');
//$placeholder['title'] = 'Title for profile row';
//$required['title'] = 'required';

$label['desktop_column'] = 'Number of Column (Desktop)';
$label['mobile_column'] = 'Number of Column (Mobile)';


//$placeholder['post_content'] = 'Description for profile row';

$type['id'] = 'hidden';
$type['password'] = 'password';
$type['position'] = 'number';
//$type['publish_date'] = 'date';
$type['content'] = 'textarea'; $tinymce['content']=true;  $labelFullRow['content']=true; $height['content'] = '500px;'; $width['content'] = '100%;';
$type['group_id'] = 'select'; $option['group_id'] = array('1'=>'Master Admin', '2'=>'Admin');
$type['status'] = 'select'; $option['status'] = array('1'=>'Display','2'=>'Hide'); $default_value['status'] = '1';
$type['layout'] = 'select'; $option['layout'] = array('D1x2-M2x1'=>'Desktop 1 rows x 2 columns & Mobile 2 rows x 1 column', 'D1x3-M3x1'=>'Desktop 1 row x 3 columns & Mobile 3 rows x 1 column'); $default_value['layout'] = '1';



//$type['thumbnail_align'] = 'select'; $option['thumbnail_align'] = array('left'=>'Image align left','right'=>'Image align right');
//$type['thumbnail_photo'] = 'image';


$type['navigator'] = 'select'; $option['navigator'] = array();
$results = sql_read('select * from navigator where status=1 order by position ASC');
foreach((array)$results as $a){
	$option['navigator'][$a['id']] = ucwords($a['section']);
}


/*if(empty($id)){
	$required['photo01'] = 'required';
}*/
/*
echo '<div style="margin-left:20%;">';
foreach((array)$fields as $field){
	echo $field;
	echo $width[$field];
	echo '<br>';
	print_r($fic_1);
}
echo '</div>';
*/
$cols = $items =array();
$cols = array('Row Layout' => 8, 'Position' => 4);//Column title and width
$items['Row Layout'] = array('layout');
$items['Position'] = array('position');
//$items['Programme'] = array('programme','experience','experience_detail');
//$items['Condition'] = array('illnesses','bankrupt','court');




if(empty($_POST['get_config_only'])){
?>

<link href="<?php echo ROOT?>cms/css/bootstrap.4.5.0.css" rel="stylesheet">
<link href="<?php echo ROOT?>cms/css/cms.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!--For date picker use - start -->
<link rel="stylesheet" href="<?php echo ROOT?>js/datepicker/jquery-ui.css">
<link rel="stylesheet" href="<?php echo ROOT?>js/datepicker/style.css">
<script src="<?php echo ROOT?>js/datepicker/jquery-1.12.4.js"></script>
<script src="<?php echo ROOT?>js/datepicker/jquery-ui.js"></script>
<script>
$( function() {
    $( ".datepicker" ).datepicker({ /*minDate: +7,*/ maxDate: "+10Y +6M +1D", dateFormat: 'dd/mm/yy' });
} );
</script>
<!--For date picker use - end -->
<style>
label {width:30%;}
.div_input {width:69%;}
</style>


<div class="row">
	<?php if($add==true || $_GET['id']){?>
		
	<div class="col-5 <?php if($_GET['no_list'] != 'true'){?> add_row<?php }?>">
		<div>Define row's layout</div>
		<?php include '../layout/add.php';?>
	</div>
	<?php }?>

	<div class="col-6 offset-1">
		<?php include '../layout/list.php';?>
	</div>
</div>



<br><br>
<div class="row">
	<div class="col" style="border-top:1px solid #CCC;"><br><br><br></div>
</div>


<div class="row">
	<div class="col-12">
		<h3>List of Home Row</h3>

		<?php 
		$layout = array('D1x2-M2x1'=>'Desktop 1 rows x 2 columns & Mobile 2 rows x 1 column', 'D1x3-M3x1'=>'Desktop 1 row x 3 columns & Mobile 3 rows x 1 column');


		$rls = sql_read("select * from row order by position asc");

		foreach($rls as $rl){?>
		<div class="row-block">
		<div class="maintitle"><?php echo $layout[$rl['layout']]?></div>
			<?php if($rl['layout'] == 'D1x2-M2x1'){?>
				<div class="row pb-5">
					<div class="col-8">
						<div class="subtitle">Desktop Layout</div>
						<div class="row pl-3">
							<div class="col lay">
								<div link="content.php?row=<?php echo ($rl['id'])?>&pos=d1" class="homerowmodal mymodal-btn btn btn-xs btn-default list-edit ref-btn"><img src="../../cms/images/edit.png" width="22"></div>
							</div>
							<div class="col lay">
								<div link="content.php?row=<?php echo ($rl['id'])?>&pos=d2" class="homerowmodal mymodal-btn btn btn-xs btn-default list-edit ref-btn"><img src="../../cms/images/edit.png" width="22"></div>
							</div>
						</div>
					</div>
					<div class="col-3 offset-1">
						<div class="subtitle">Mobile Layout</div>
						<div class="row pl-3">
							<div class="col lay-m">
								<div link="content.php?row=<?php echo ($rl['id'])?>&pos=m1" class="homerowmodal mymodal-btn btn btn-xs btn-default list-edit ref-btn"><img src="../../cms/images/edit.png" width="22"></div>
							</div>
						</div>
						<div class="row pl-3">
							<div class="col lay-m">
								<div link="content.php?row=<?php echo ($rl['id'])?>&pos=m2" class="homerowmodal mymodal-btn btn btn-xs btn-default list-edit ref-btn"><img src="../../cms/images/edit.png" width="22"></div>
							</div>
						</div>
					</div>
				</div>
			<?php }elseif($rl['layout'] == 'D1x3-M3x1'){?>
				<div class="row pb-5">
					<div class="col-8">
						<div class="subtitle">Desktop Layout</div>
						<div class="row pl-3">
							<div class="col lay">
								<div link="content.php?row=<?php echo ($rl['id'])?>&pos=d1" class="homerowmodal mymodal-btn btn btn-xs btn-default list-edit ref-btn"><img src="../../cms/images/edit.png" width="22"></div>
							</div>
							<div class="col lay">
								<div link="content.php?row=<?php echo ($rl['id'])?>&pos=d2" class="homerowmodal mymodal-btn btn btn-xs btn-default list-edit ref-btn"><img src="../../cms/images/edit.png" width="22"></div>
							</div>
							<div class="col lay">
								<div link="content.php?row=<?php echo ($rl['id'])?>&pos=d3" class="homerowmodal mymodal-btn btn btn-xs btn-default list-edit ref-btn"><img src="../../cms/images/edit.png" width="22"></div>
							</div>
						</div>
					</div>
					<div class="col-3 offset-1">
						<div class="subtitle">Mobile Layout</div>
						<div class="row pl-3">
							<div class="col lay-m">
								<div link="content.php?row=<?php echo ($rl['id'])?>&pos=m1" class="homerowmodal mymodal-btn btn btn-xs btn-default list-edit ref-btn"><img src="../../cms/images/edit.png" width="22"></div>
							</div>
						</div>
						<div class="row pl-3">
							<div class="col lay-m">
								<div link="content.php?row=<?php echo ($rl['id'])?>&pos=m2" class="homerowmodal mymodal-btn btn btn-xs btn-default list-edit ref-btn"><img src="../../cms/images/edit.png" width="22"></div>
							</div>
						</div>
						<div class="row pl-3">
							<div class="col lay-m">
								<div link="content.php?row=<?php echo ($rl['id'])?>&pos=m3" class="homerowmodal mymodal-btn btn btn-xs btn-default list-edit ref-btn"><img src="../../cms/images/edit.png" width="22"></div>
							</div>
						</div>
					</div>
				</div>


			<?php }?>
		</div>
		<?php }?>
		
		

	</div>
</div>

<script>
function chkAll(frm, arr, mark){
  for (i = 0; i <= frm.elements.length; i++){
   try{
     if(frm.elements[i].name == arr){
       frm.elements[i].checked = mark;
     }
   } catch(er) {}
  }
}

$('.homerowmodal').click(function(){
	
	$('.mymodal').css('display', 'block').fadeIn();
	var link = $(this).attr('link')+'&no_list=true';
	if(link){
		$('.mymodal-iframe').attr('src', link);
	}
});
</script>



<style>
.row-block {
	padding-bottom:50px;
	
}
.maintitle {
	background:#518f8b;
	padding:3px 8px;	
    font-size:20px;
    color:#FFF;
	margin-bottom:5px;
}
.subtitle {
    font-size:16px;
    color:#366b68;
}
.lay, .lay-m {
	border:1px dashed green;
	text-align:center;
	min-height:100px;
	padding-top:40px;
}
.homerowmodal {
	cursor:pointer;
}

</style>

<script type="text/javascript" src="<?php echo ROOT?>js/jquery-1.js"></script>
<script type="text/javascript" src="<?php echo ROOT?>js/content.js"></script>
<script type="text/javascript" src="<?php echo ROOT?>js/functions.jquery.js"></script>
<?php include '../../config/session_msg.php';?>



</html>
<?php }?>