<?php $this->load->view('frontend/profile/nav'); ?>
<div class="container page-container">
    <div id="primary" class="content-area row">
        <aside id="aside" class="site-aside col-sm-3">
            <?php $this->load->view('frontend/profile/sidebar_setting'); ?>
        </aside>
        <main id="main" class="site-main col-sm-9" role="main">
            <div class="panel panel-default">
                <div class="panel-heading">Payment Methods</div>
                <div class="panel-body">
                    <p>When you receive a payment for a reservation, we call that payment to you a "payout". Our secure payment system supports several payout methods, which can be setup and edited here. Your available payout options and currencies differ by country.</p>
                    <div class="table-responsive">
                       <table class="table table-hover table-striped" id="trip-table" style="margin-bottom:0;">
                          <thead>
                             <tr>
                                <th>#</th>
                                <th>Method</th>
                                <th>Details</th>
                                <th>Status</th>
                                <th></th>
                             </tr>
                          </thead>
                          <tbody>
                             <tr class="trip-basic">
                                <td>2</td>
                                <td>Bank Transfer (default)</td>
                                <td>David VanderVeer, *****8365, 121042882 (Checking)</td>
                                <td>Ready</td>
                                <td>Options</td>
                             </tr>
                          </tbody>
                       </table>
                    </div>
                    <div style="height:20px;"></div>
                    <p>
                        <a class="btn btn-secondary">Add Payment Method</a> 
                        &nbsp;&nbsp;Direct Depoit, Paypal, etc...
                    </p>  
                </div>
            </div>
        </main>
    </div>
</div>
<style type="text/css">
    .panel-payment-method p{
        font-size: 18px;
    }
    .panel-payment-method .payment-info{
        margin-bottom: 0;
    }
    .panel-payment-method .icon-payment{
        border: 1px solid #3e75a1;
        padding: 8px 10px;
        color: #3e75a1;
        font-weight: bold;
        font-size: 18px;
    }
    .panel-payment-method .icon-add-method{
        padding: 15px 0;
    }
    .panel-payment-method .icon-add-method i{
        font-size: 40px;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){
        $('a.add-more').click(function(){
            $(this).parent().find('.group').toggleClass('hidden');
            return false;
        });
    });
</script>