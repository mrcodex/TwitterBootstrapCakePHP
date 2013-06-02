<?php
$messages = is_array($message) ? $message : array($message);
$class = 'alert alert-block';
if ( isset($style) && !empty($style) ) {
	$class .= ' alert-' . $style;
}
foreach ($messages as $message ) {?>
<div class="<?php echo $class;?>">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo h($message);?>
</div>
<?php
}
?>