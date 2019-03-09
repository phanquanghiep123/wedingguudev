<a id="menu">dfgfdgfdg</a>
<a id="menu2">dfgfdgfdg</a>
<script type="text/javascript" src="<?php echo skin_url("/filemanager/filemanager.js")?>"></script>
<script type="text/javascript">
  $(document).ready (function(){
    $('#menu').Scfilemanagers({
    	base_url : "<?php echo base_url();?>",
    	query    : {
    		max_file : 1,
    		type_file : "image",

    	},
    	beforchoose : function(val){
    		console.log(val);
    	}
    });
    $('#menu2').Scfilemanagers({
    	base_url : "<?php echo base_url();?>",
    	beforchoose : function(){
    		alert("#menu2");
    	}
    });
  });
</script>