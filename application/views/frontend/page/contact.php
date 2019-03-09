<div class="section-map">
    <iframe style="width:100%;max-width:100%;height:400px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6674.020313449921!2d-115.52338467606876!3d33.24003732333852!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80da3dd51e7ffed7%3A0xf2846eebb0ea6881!2sCA-111%2C+Niland%2C+CA+92257!5e0!3m2!1svi!2s!4v1492566227298" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h2 class="page-title">Contact Us</h2>
            <form method="post" action="">
                <?php 
                    if($this->session->flashdata('message')){
                        echo  $this->session->flashdata('message');
                    }
                ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="label-control">Full name:</label>
                            <input type="text" class="form-control" name="full_name" required>
                        </div>
                        <div class="form-group">
                            <label class="label-control">Email:</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label class="label-control">Subject:</label>
                            <input type="text" class="form-control" name="subject" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="label-control">Message:</label>
                            <textarea rows="9" class="form-control" name="message" required></textarea>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<style type="text/css">
    .page-title{position: relative;margin-bottom: 20px;}
    .page-title:after{content: '';position: absolute;top:100%;left: 0;width: 50px; border-bottom: 3px solid #ccc;}
    .page-content{padding-bottom: 30px;}
</style>
