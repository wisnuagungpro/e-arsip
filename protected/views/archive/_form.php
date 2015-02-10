<?php
/* @var $this ArchiveController */
/* @var $model Archive */
/* @var $form CActiveForm */
//print_r($_SESSION['fk_gudang']);
?>
<style>
.errorMessage {
	color : red;
}
</style>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'archive-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
<table width=100% border="0" align="center" bordercolor="#ccc">
	<tr align="">
		<td><?php echo $form->labelEx($model,'fk_skpd'); ?></td>
		<td>Nama SKPD</td>
		
	</tr>
		<tr align="">
		<td>
        <?php
$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
    'name'=>'Archive[fk_skpd]',
    'source'=>$this->createUrl('request/suggestSKPD'),
   'options'=>array(
        'delay'=>30,
        'minLength'=>1,
        'showAnim'=>'fold',
        'select'=>"js:function(event, ui) {
            $('#label').val(ui.item.label);
            $('#code').val(ui.item.code);
            $('#nis').val(ui.item.nis);
            $('#nama').val(ui.item.nama);
        }"
       ),
        'htmlOptions'=>array(
        'size'=>'25',
        'placeholder'=>'Cari kode/nama disini !',
       // 'value'=>$model->fk_skpd,

    ),
));
?>

</td>
		<td width="66.5%"><input type="text" readonly id="nama"></td>
		
	</tr>
		<tr>
		<td><?php echo $form->error($model,'fk_skpd'); ?></td>
		<td></td>
		<td></td>
	</tr>
</table>

<table width=100%>
	<tr>
		<td><?php echo $form->labelEx($model,'fk_gudang'); ?></td>
		<td ><?php echo $form->labelEx($model,'fk_lajur'); ?></td>
		<td ><?php echo $form->labelEx($model,'fk_box'); ?></td>
		
	</tr>	
	<tr>
	<?php                                   
  echo '<td>'.CHtml::dropDownList('Archive[fk_gudang]',$model->fk_gudang, 
	  CHtml::listData(Gudang::model()->findAll(),'id' ,'nama'),
	 
	  array(
	    'prompt'=>'Select Gudang',

	    'ajax' => array(
	    'type'=>'POST', 
	    'url'=>Yii::app()->createUrl('archive/loadlajur'), //or $this->createUrl('loadcities') if '$this' extends CController
	    'update'=>'#Archive_fk_lajur', //or 'success' => 'function(data){...handle the data in the way you want...}',
	  'data'=>array('id'=>'js:this.value'),
	  )))
 
.'</td>'; 
 
 
 
echo '<td>'.CHtml::dropDownList('Archive[fk_lajur]',$model->fk_lajur, $model->getLajur(), array('prompt'=>'Select Lajur', 
		'ajax' => array(
	    'type'=>'POST', 
	    'url'=>Yii::app()->createUrl('archive/loadbox'), //or $this->createUrl('loadcities') if '$this' extends CController
	    'update'=>'#Archive_fk_box', //or 'success' => 'function(data){...handle the data in the way you want...}',
	  'data'=>array('id'=>'js:this.value'),
	  ))).'</td>';
echo '<td>'.CHtml::dropDownList('Archive[fk_box]',$model->fk_box, $model->getBox(), array('prompt'=>'Select Box / Rack')).'</td>';

?>

	</tr>
	<tr>
		<td><?php echo $form->error($model,'fk_gudang'); ?></td>
		<td ><?php echo $form->error($model,'fk_lajur'); ?></td>
		<td ><?php echo $form->error($model,'fk_box'); ?></td>
		
	</tr>	

</table>
<table width="100%" align="left">
	<tr>
		<td><?php echo $form->labelEx($model,'file'); ?></td>
		<td><?php echo $form->labelEx($model,'kelengkapan'); ?></td>
	</tr>
	<tr>
		<td><?php echo CHtml::activeFileField($model,'file'); ?>
		<td width="66.5%"><?php echo CHtml::activeFileField($model,'kelengkapan'); ?>	
	</tr>
	<tr>
		<td><?php echo $form->error($model,'file'); ?></td>
		<td><?php echo $form->error($model,'kelengkapan'); ?></td>
	</tr>				
</table>	
<table width=100% border="0" align="left" bordercolor="#ccc">
	<tr>		
		<td><?php echo $form->labelEx($model,'kode_klasifikasi'); ?></td>
		<td><?php echo $form->labelEx($model,'unit_pengolah'); ?></td>
	</tr>
	<tr>		
		<td><?php echo $form->textField($model,'kode_klasifikasi',array('size'=>50,'maxlength'=>50)); ?></td>
		<td width="66.5%"><?php echo $form->textField($model,'unit_pengolah',array('size'=>50,'maxlength'=>50)); ?></td>
	</tr>
	<tr>		
		<td><?php echo $form->error($model,'kode_klasifikasi'); ?></td>
		<td><?php echo $form->error($model,'unit_pengolah'); ?></td>
	</tr>
</table>	
<table width="100%">
	<tr><td><?php echo $form->labelEx($model,'isi_berkas'); ?></td></tr>
	<tr><td><?php echo $form->textArea($model,'isi_berkas',array('rows'=>5, 'cols'=>60,'style'=>'margin: 0px 0px 10px; width: 100%;')); ?></td></tr>
	<tr><td><?php echo $form->error($model,'isi_berkas'); ?></td></tr>
	
</table>
<table width="100%">
	<tr>
		
		<td><?php echo $form->labelEx($model,'month'); ?></td>
		<td><?php echo $form->labelEx($model,'years'); ?></td>
	</tr>
	<tr>
		
		
		<td><?php echo CHtml::dropDownList('Archive[month]', $model->month, 
              $model->getMonth(),
              array('empty' => 'Select Bulan')); ?>
			<?php //echo $form->textField($model,'bln_thn'); ?></td>
		
		<td width="66.5%">
			<select name="Archive[years]">
<?php 
$years = range(date("Y"), date("Y", strtotime("now - 100 years"))); 
foreach($years as $year){ 
	if($model->isNewRecord)
    echo'<option value="'.$year.'" >'.$year.'</option>'; 
	else 
		echo'<option value="'.$year.'" ';
	if($year==$model->years){
	echo 'selected="selected"'; } 
	echo '>'.$year.'</option>'; 
} 
?> 
</select>
		
		</td>
	</tr>
	<tr>
		
		<td><?php echo $form->error($model,'month'); ?></td>
		<td><?php echo $form->error($model,'years'); ?></td>
	</tr>
	
</table>
<table width="100%">
	<tr>
		<td><?php echo $form->labelEx($model,'media'); ?></td>
		<td><?php echo $form->labelEx($model,'bentuk_redaksi'); ?></td>
	</tr>
	<tr>
		<td >
			<?php echo CHtml::dropDownList('Archive[media]', $model->media, 
              $model->getMedia(),
              array('empty' => 'Select Media')); ?>
			<?php //echo $form->textField($model,'media',array('size'=>50,'maxlength'=>50)); ?></td>
		<td width="66.5%">
			<?php echo CHtml::dropDownList('Archive[bentuk_redaksi]', $model->bentuk_redaksi, 
              $model->getRedaksi(),
              array('empty' => 'Select Redaksi')); ?>
			<?php //echo $form->textField($model,'bentuk_redaksi',array('size'=>50,'maxlength'=>50)); ?></td>
	</tr>
	<tr>
		<td><?php echo $form->error($model,'media'); ?></td>
		<td><?php echo $form->error($model,'bentuk_redaksi'); ?></td>
	</tr>
	<tr><td><?php echo $form->labelEx($model,'kode_mslh'); ?></td></tr>
	<tr><td> <?php
$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
    'name'=>'Archive[kode_mslh]',
    'source'=>$this->createUrl('request/suggestMasalah'),
   'options'=>array(
        'delay'=>30,
        'minLength'=>1,
        'showAnim'=>'fold',
        'select'=>"js:function(event, ui) {
            $('#label').val(ui.item.label);
            $('#code').val(ui.item.code);
            $('#Archive_masalah').val(ui.item.nama);
        }"
       ),
        'htmlOptions'=>array(
        'size'=>'25',
        'placeholder'=>'Cari kode/nama disini !',

    ),
));
?></td></tr>
	<tr><td><?php echo $form->error($model,'kode_mslh'); ?></td></tr>
	
	<tr><td><?php echo $form->labelEx($model,'masalah'); ?></td></tr>
	<tr><td><?php echo $form->textField($model,'masalah',array('size'=>60,'maxlength'=>100)); ?></td></tr>
	<tr><td><?php echo $form->error($model,'masalah'); ?></td></tr>


</table>
	<table width="100%">
	<tr><td><?php echo $form->labelEx($model,'uraian_masalah'); ?></td></tr>
	<tr><td><?php echo $form->textArea($model,'uraian_masalah',array('rows'=>5, 'cols'=>60,'style'=>'margin: 0px 0px 10px; width: 100%;')); ?></td></tr>
	<tr><td><?php echo $form->error($model,'uraian_masalah'); ?></td></tr>
	
</table>
<!--
	<div class="row">
		<?php echo $form->labelEx($model,'kode_mslh'); ?>
		<?php echo $form->textField($model,'kode_mslh'); ?>
		<?php echo $form->error($model,'kode_mslh'); ?>
	</div>
-->
	<table width="100%">
		<tr>
			<td><?php echo $form->labelEx($model,'r_aktif'); ?></td>
			<td><?php echo $form->labelEx($model,'r_inaktif'); ?></td>
			<td><?php echo "Jumlah Retensi"; ?></td>
		</tr>
		<tr>
			<td><?php echo $form->textField($model,'r_aktif'); ?></td>
			<td><?php echo $form->textField($model,'r_inaktif'); ?></td>
			<td><input type="text" name="jumlahretensi" id="jmlres" readonly value='1'/></td>

		</tr>
		<tr>
			<td><?php echo $form->error($model,'r_aktif'); ?></td>
			<td><?php echo $form->error($model,'r_inaktif'); ?></td>
		
		</tr>
	</table>
<table width="100%">
	<tr>
		<!--<td><?php echo $form->labelEx($model,'thn_retensi'); ?></td>-->
		<td><?php echo $form->labelEx($model,'nilai_guna'); ?></td>
		<td style="width: 66.5%"><?php echo $form->labelEx($model,'tingkat_perkembangan'); ?></td>	
	</tr>
	<tr>
		<!--<td>Tssss</td>-->
		<!--<td>
		<select name="Archive[thn_retensi]">
<?php 
$years = range(date("Y"), date("Y", strtotime("now - 100 years"))); 
foreach($years as $year){ 
    echo'<option value="'.$year.'">'.$year.'</option>'; 
} 
?> 
</select>
		<?php //echo $form->textField($model,'thn_retensi',array('size'=>4,'maxlength'=>4)); ?></td>
		--><td>
		
			<?php echo CHtml::dropDownList('Archive[nilai_guna]', $model->nilai_guna, 
              $model->getNG(),
              array('empty' => 'Select Nilai Guna')); ?>
			<?php //echo $form->textField($model,'nilai_guna',array('size'=>50,'maxlength'=>50)); ?></td>
		<td>
<?php echo CHtml::dropDownList('Archive[tingkat_perkembangan]', $model->tingkat_perkembangan, 
              $model->getTk(),
              array('empty' => 'Select Tk. Perkembangan')); ?>
			<?php //echo $form->textField($model,'tingkat_perkembangan',array('size'=>50,'maxlength'=>50)); ?></td>	
	</tr>
	<tr>
		<!--<td><?php echo $form->error($model,'thn_retensi'); ?></td>		-->
		<td><?php echo $form->error($model,'nilai_guna'); ?></td>
		<td><?php echo $form->error($model,'tingkat_perkembangan'); ?></td>	
	</tr>


</table>


	<div class="row buttons" style="margin-left: 1%">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->