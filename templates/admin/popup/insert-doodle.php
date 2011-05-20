<div class="title">Doodle Maker <span style="color: red">BETA</span></div>
<div class="box">
<div class="toolbar">
	<div class="right colours">
		<div class="cb" style="background:green"></div>
		<div class="cb selected" style="background:black"></div>
		<div class="cb" style="background:blue"></div>
		<div class="cb" style="background:yellow"></div>
		<div class="cb" style="background:red"></div>
	</div>
<?php $t = "$coredir/admin/res/"; ?>
	<img id="penciltool" src="<?php echo $t; ?>pencil.png" title="Pencil" />
	<img id="brushtool" src="<?php echo $t; ?>brush.png" title="Brush" />
	<img id="clearall" src="<?php echo $t; ?>cross.png" title="Clear All" />
</div>
<div class="container" style="position: relative;cursor:hand">
	<canvas id="pad" style="border: 1px solid #000" height=270 width=720>
		Please update your web browser! We need Canvas support (no icky flash!)
	</canvas>
</div>
<input type="submit" id="submit" value="Add" />
</div>
<script type="text/javascript" src="<?php echo $coredir; ?>/admin/res/insert-doodle.js"></script>
<div id="sheet">
	Please wait...
</div>
<form id="hiddenform" action="insert-doodle.php" method="post">
<input type="hidden" name="doodle" id="data" />
</form>