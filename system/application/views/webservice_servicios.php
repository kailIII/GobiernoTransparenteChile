<?php $blacklist=array('id','servicios_id','mes','ano')?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'?>
<datos_ta xmlns="http://www.gobiernotransparentechile.cl" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.gobiernotransparentechile.cl /assets/xml/datos_ta.xsd">
<?php foreach($datos_ta as $pag=>$v)?>
	<?php foreach($v as $ano=>$val) foreach ($val as $mes=>$registros){?>
	<<?=$pag ?> <?=($ano)?'ano="'.$ano.'"':''?> <?=($mes)?'mes="'.$mes.'"':''?>>
		<?php foreach ($registros as $r) {?>
			<registro>
				<?php foreach ($r as $key=>$value)
					if (!in_array($key,$blacklist))
						echo ($value!='')?'<'.$key.'>'.$value.'</'.$key.'>':'';
				?>

			</registro>
		<?php }?>
	</<?=$pag ?>>
	<?php }?>
</datos_ta>