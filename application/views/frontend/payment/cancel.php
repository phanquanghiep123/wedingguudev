<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
            	<div class="notify successbox text-center">
				    <h1><span>Thất bại!</span></h1>
				    <span class="alerticon"><img src="<?php echo skin_url('frontend/images/error.png'); ?>" alt="checkmark" /></span>
				    <p class="text-center">
				    	<?php 
				    		if($this->session->flashdata('message')){
                                echo  $this->session->flashdata('message');
                            }
                            else {
                            	echo 'Không thể nâng cấp tài khoản lên gói dịch vụ này.';
                            }
				    	?>
				    </p>
				</div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
.notify {
    display: block;
    background: #fff;
    padding: 12px 18px;
    max-width: 600px;
    margin: 0 auto;
    cursor: pointer;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    margin-bottom: 20px;
    box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 2px 
}
.successbox h1 {
    color: #6f423b;
    margin-bottom: 15px;
    position: relative;
    overflow: hidden;
    white-space: nowrap;
    text-align: center;
    font-size: 2.5em;
    line-height: 1.5em;
    letter-spacing: -0.05em
}
.successbox h1 span{
	position: relative;
	padding-left: 20px;
	padding-right: 20px;
	z-index: 2;
	background-color: #fff;
}
.successbox h1:after{
	content: "";
    position: absolute;
    display: inline-block;
    width: 100%;
    left: 0;
    top: 56%;
    height: 1px;
    vertical-align: middle;
    background: #d6b8b7;
    z-index: 1;
}
.notify .alerticon {
    display: block;
    text-align: center;
    margin-bottom: 30px;
}
</style>