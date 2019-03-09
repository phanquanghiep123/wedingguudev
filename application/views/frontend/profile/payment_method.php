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
                    <?php 
                        if($this->session->flashdata('message')){
                            echo  $this->session->flashdata('message');
                        }
                    ?>
                    <div class="row">
                        <?php if(isset($list_payment_method) && $list_payment_method != null): ?>
                            <?php foreach ($list_payment_method as $key => $item): ?>
                                <div class="col-sm-4">
                                    <div class="panel panel-default panel-payment-method">
                                        <div class="panel-body">
                                            <p class="payment-info"><?php echo str_replace(@$item['Card_Number'], str_repeat('X', strlen(@$item['Card_Number']) - 4) . substr(@$item['Card_Number'], -4), @$item['Card_Number']); ?></p>
                                            <p class="payment-date"><?php echo @$item['Expires_MM']; ?>/<?php echo @$item['Expires_YYYY']; ?></p>
                                            <div style="height:20px;"></div>
                                            <div class="row">
                                                <div class="col-sm-7">
                                                    <p>
                                                        <?php if(@$item['Default'] == 1): ?>
                                                           Default Card
                                                        <?php else: ?>
                                                          <a href="<?php echo base_url('/profile/set_card_default/'.@$item['ID']); ?>">Set Default</a>
                                                        <?php endif; ?>
                                                        <br /><a href="<?php echo base_url('/profile/remove_card_default/'.@$item['ID']); ?>" onclick="return confirm('Do you really want to delete?');">Remove</a>
                                                    </p>
                                                </div>
                                                <div class="col-sm-5">
                                                    <span class="icon-payment">VISA</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if(($key+1)%3 == 0): ?>
                                    </div><div class="row">
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        
                        <div class="col-sm-4">
                            <a data-toggle="modal" data-target="#invite-modal" href="#">
                                <div class="panel panel-default panel-payment-method">
                                    <div class="panel-body">
                                        <p class="icon-add-method text-center">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </p>
                                        <p class="text-center">Add Payment Method</p>
                                        <div style="height:8px;"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>   
                </div>
            </div>
        </main>
    </div>
</div>
<div class="modal fade" id="invite-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="" method="post">
            <div class="modal-content" style="background-color: #f5f5f5;">
                <div class="modal-body" style="padding:0;">
                    <div class="panel-header">
                        <a href="#" class="panel-close" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></a>
                        Add New Payment Method
                    </div>
                    <div class="panel-body">
                        <p><img src="<?php echo skin_url('/frontend/images/card.png'); ?>" class="img-responsive"></p>
                        <div class="form-group">
                            <label>Card number <sup style="color:#ff0000;">*</sup></label>
                            <input type="text" name="card_number" class="form-control required">
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Expires on <sup style="color:#ff0000;">*</sup></label>
                                            <select class="form-control required" name="mm">
                                                <option value="">MM</option>
                                                <?php for($i = 1;$i <= 12; $i++): ?>
                                                    <option value="<?php echo ($i < 10 ? '0' : '').$i; ?>"><?php echo ($i < 10 ? '0' : '').$i; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="hidden-xs">&nbsp;</label>
                                            <select class="form-control required" name="yyyy">
                                                <option value="">YYYY</option>
                                                <?php for($i = 2000;$i <= 2020; $i++): ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Security code <sup style="color:#ff0000;">*</sup></label>
                                    <input type="text" name="security_code" class="form-control required">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>First name</label>
                                    <input type="text" name="first_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Last name</label>
                                    <input type="text" name="last_name" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Postal code</label>
                                    <input type="text" name="postal_code" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Country</label>
                                    <select name="country" class="form-control">
                                       <option value="AF">Afghanistan</option>
                                       <option value="AX">Åland Islands</option>
                                       <option value="AL">Albania</option>
                                       <option value="DZ">Algeria</option>
                                       <option value="AS">American Samoa</option>
                                       <option value="AD">Andorra</option>
                                       <option value="AO">Angola</option>
                                       <option value="AI">Anguilla</option>
                                       <option value="AQ">Antarctica</option>
                                       <option value="AG">Antigua and Barbuda</option>
                                       <option value="AR">Argentina</option>
                                       <option value="AM">Armenia</option>
                                       <option value="AW">Aruba</option>
                                       <option value="AU">Australia</option>
                                       <option value="AT">Austria</option>
                                       <option value="AZ">Azerbaijan</option>
                                       <option value="BS">Bahamas</option>
                                       <option value="BH">Bahrain</option>
                                       <option value="BD">Bangladesh</option>
                                       <option value="BB">Barbados</option>
                                       <option value="BY">Belarus</option>
                                       <option value="BE">Belgium</option>
                                       <option value="BZ">Belize</option>
                                       <option value="BJ">Benin</option>
                                       <option value="BM">Bermuda</option>
                                       <option value="BT">Bhutan</option>
                                       <option value="BO">Bolivia</option>
                                       <option value="BA">Bosnia and Herzegovina</option>
                                       <option value="BW">Botswana</option>
                                       <option value="BV">Bouvet Island</option>
                                       <option value="BR">Brazil</option>
                                       <option value="IO">British Indian Ocean Territory</option>
                                       <option value="VG">British Virgin Islands</option>
                                       <option value="BN">Brunei</option>
                                       <option value="BG">Bulgaria</option>
                                       <option value="BF">Burkina Faso</option>
                                       <option value="BI">Burundi</option>
                                       <option value="KH">Cambodia</option>
                                       <option value="CM">Cameroon</option>
                                       <option value="CA">Canada</option>
                                       <option value="CV">Cape Verde</option>
                                       <option value="BQ">Caribbean Netherlands</option>
                                       <option value="KY">Cayman Islands</option>
                                       <option value="CF">Central African Republic</option>
                                       <option value="TD">Chad</option>
                                       <option value="CL">Chile</option>
                                       <option value="CN">China</option>
                                       <option value="CX">Christmas Island</option>
                                       <option value="CC">Cocos [Keeling] Islands</option>
                                       <option value="CO">Colombia</option>
                                       <option value="KM">Comoros</option>
                                       <option value="CG">Congo</option>
                                       <option value="CK">Cook Islands</option>
                                       <option value="CR">Costa Rica</option>
                                       <option value="HR">Croatia</option>
                                       <option value="CW">Curaçao</option>
                                       <option value="CY">Cyprus</option>
                                       <option value="CZ">Czech Republic</option>
                                       <option value="CD">Democratic Republic of the Congo</option>
                                       <option value="DK">Denmark</option>
                                       <option value="DJ">Djibouti</option>
                                       <option value="DM">Dominica</option>
                                       <option value="DO">Dominican Republic</option>
                                       <option value="TL">East Timor</option>
                                       <option value="EC">Ecuador</option>
                                       <option value="EG">Egypt</option>
                                       <option value="SV">El Salvador</option>
                                       <option value="GQ">Equatorial Guinea</option>
                                       <option value="ER">Eritrea</option>
                                       <option value="EE">Estonia</option>
                                       <option value="ET">Ethiopia</option>
                                       <option value="FK">Falkland Islands [Islas Malvinas]</option>
                                       <option value="FO">Faroe Islands</option>
                                       <option value="FJ">Fiji</option>
                                       <option value="FI">Finland</option>
                                       <option value="FR">France</option>
                                       <option value="GF">French Guiana</option>
                                       <option value="PF">French Polynesia</option>
                                       <option value="TF">French Southern Territories</option>
                                       <option value="GA">Gabon</option>
                                       <option value="GM">Gambia</option>
                                       <option value="GE">Georgia</option>
                                       <option value="DE">Germany</option>
                                       <option value="GH">Ghana</option>
                                       <option value="GI">Gibraltar</option>
                                       <option value="GR">Greece</option>
                                       <option value="GL">Greenland</option>
                                       <option value="GD">Grenada</option>
                                       <option value="GP">Guadeloupe</option>
                                       <option value="GU">Guam</option>
                                       <option value="GT">Guatemala</option>
                                       <option value="GG">Guernsey</option>
                                       <option value="GN">Guinea</option>
                                       <option value="GW">Guinea-Bissau</option>
                                       <option value="GY">Guyana</option>
                                       <option value="HT">Haiti</option>
                                       <option value="HM">Heard Island and McDonald Islands</option>
                                       <option value="HN">Honduras</option>
                                       <option value="HK">Hong Kong</option>
                                       <option value="HU">Hungary</option>
                                       <option value="IS">Iceland</option>
                                       <option value="IN">India</option>
                                       <option value="ID">Indonesia</option>
                                       <option value="IQ">Iraq</option>
                                       <option value="IE">Ireland</option>
                                       <option value="IM">Isle of Man</option>
                                       <option value="IL">Israel</option>
                                       <option value="IT">Italy</option>
                                       <option value="CI">Ivory Coast</option>
                                       <option value="JM">Jamaica</option>
                                       <option value="JP">Japan</option>
                                       <option value="JE">Jersey</option>
                                       <option value="JO">Jordan</option>
                                       <option value="KZ">Kazakhstan</option>
                                       <option value="KE">Kenya</option>
                                       <option value="KI">Kiribati</option>
                                       <option value="XK">Kosovo</option>
                                       <option value="KW">Kuwait</option>
                                       <option value="KG">Kyrgyzstan</option>
                                       <option value="LA">Laos</option>
                                       <option value="LV">Latvia</option>
                                       <option value="LB">Lebanon</option>
                                       <option value="LS">Lesotho</option>
                                       <option value="LR">Liberia</option>
                                       <option value="LY">Libya</option>
                                       <option value="LI">Liechtenstein</option>
                                       <option value="LT">Lithuania</option>
                                       <option value="LU">Luxembourg</option>
                                       <option value="MO">Macau</option>
                                       <option value="MK">Macedonia</option>
                                       <option value="MG">Madagascar</option>
                                       <option value="MW">Malawi</option>
                                       <option value="MY">Malaysia</option>
                                       <option value="MV">Maldives</option>
                                       <option value="ML">Mali</option>
                                       <option value="MT">Malta</option>
                                       <option value="MH">Marshall Islands</option>
                                       <option value="MQ">Martinique</option>
                                       <option value="MR">Mauritania</option>
                                       <option value="MU">Mauritius</option>
                                       <option value="YT">Mayotte</option>
                                       <option value="MX">Mexico</option>
                                       <option value="FM">Micronesia</option>
                                       <option value="MD">Moldova</option>
                                       <option value="MC">Monaco</option>
                                       <option value="MN">Mongolia</option>
                                       <option value="ME">Montenegro</option>
                                       <option value="MS">Montserrat</option>
                                       <option value="MA">Morocco</option>
                                       <option value="MZ">Mozambique</option>
                                       <option value="MM">Myanmar [Burma]</option>
                                       <option value="NA">Namibia</option>
                                       <option value="NR">Nauru</option>
                                       <option value="NP">Nepal</option>
                                       <option value="NL">Netherlands</option>
                                       <option value="NC">New Caledonia</option>
                                       <option value="NZ">New Zealand</option>
                                       <option value="NI">Nicaragua</option>
                                       <option value="NE">Niger</option>
                                       <option value="NG">Nigeria</option>
                                       <option value="NU">Niue</option>
                                       <option value="NF">Norfolk Island</option>
                                       <option value="MP">Northern Mariana Islands</option>
                                       <option value="NO">Norway</option>
                                       <option value="OM">Oman</option>
                                       <option value="PK">Pakistan</option>
                                       <option value="PW">Palau</option>
                                       <option value="PS">Palestinian Territories</option>
                                       <option value="PA">Panama</option>
                                       <option value="PG">Papua New Guinea</option>
                                       <option value="PY">Paraguay</option>
                                       <option value="PE">Peru</option>
                                       <option value="PH">Philippines</option>
                                       <option value="PN">Pitcairn Islands</option>
                                       <option value="PL">Poland</option>
                                       <option value="PT">Portugal</option>
                                       <option value="PR">Puerto Rico</option>
                                       <option value="QA">Qatar</option>
                                       <option value="RE">Réunion</option>
                                       <option value="RO">Romania</option>
                                       <option value="RU">Russia</option>
                                       <option value="RW">Rwanda</option>
                                       <option value="BL">Saint Barthélemy</option>
                                       <option value="SH">Saint Helena</option>
                                       <option value="KN">Saint Kitts and Nevis</option>
                                       <option value="LC">Saint Lucia</option>
                                       <option value="MF">Saint Martin</option>
                                       <option value="PM">Saint Pierre and Miquelon</option>
                                       <option value="VC">Saint Vincent and the Grenadines</option>
                                       <option value="WS">Samoa</option>
                                       <option value="SM">San Marino</option>
                                       <option value="ST">São Tomé and Príncipe</option>
                                       <option value="SA">Saudi Arabia</option>
                                       <option value="SN">Senegal</option>
                                       <option value="RS">Serbia</option>
                                       <option value="SC">Seychelles</option>
                                       <option value="SL">Sierra Leone</option>
                                       <option value="SG">Singapore</option>
                                       <option value="SX">Sint Maarten</option>
                                       <option value="SK">Slovakia</option>
                                       <option value="SI">Slovenia</option>
                                       <option value="SB">Solomon Islands</option>
                                       <option value="SO">Somalia</option>
                                       <option value="ZA">South Africa</option>
                                       <option value="GS">South Georgia and the South Sandwich Islands</option>
                                       <option value="KR">South Korea</option>
                                       <option value="SS">South Sudan</option>
                                       <option value="ES">Spain</option>
                                       <option value="LK">Sri Lanka</option>
                                       <option value="SR">Suriname</option>
                                       <option value="SJ">Svalbard and Jan Mayen</option>
                                       <option value="SZ">Swaziland</option>
                                       <option value="SE">Sweden</option>
                                       <option value="CH">Switzerland</option>
                                       <option value="TW">Taiwan</option>
                                       <option value="TJ">Tajikistan</option>
                                       <option value="TZ">Tanzania</option>
                                       <option value="TH">Thailand</option>
                                       <option value="TG">Togo</option>
                                       <option value="TK">Tokelau</option>
                                       <option value="TO">Tonga</option>
                                       <option value="TT">Trinidad and Tobago</option>
                                       <option value="TN">Tunisia</option>
                                       <option value="TR">Turkey</option>
                                       <option value="TM">Turkmenistan</option>
                                       <option value="TC">Turks and Caicos Islands</option>
                                       <option value="TV">Tuvalu</option>
                                       <option value="UM">U.S. Outlying Islands</option>
                                       <option value="VI">U.S. Virgin Islands</option>
                                       <option value="UG">Uganda</option>
                                       <option value="UA">Ukraine</option>
                                       <option value="AE">United Arab Emirates</option>
                                       <option value="GB">United Kingdom</option>
                                       <option value="US">United States</option>
                                       <option value="UY">Uruguay</option>
                                       <option value="UZ">Uzbekistan</option>
                                       <option value="VU">Vanuatu</option>
                                       <option value="VA">Vatican City</option>
                                       <option value="VE">Venezuela</option>
                                       <option value="VN">Vietnam</option>
                                       <option value="WF">Wallis and Futuna</option>
                                       <option value="EH">Western Sahara</option>
                                       <option value="YE">Yemen</option>
                                       <option value="ZM">Zambia</option>
                                       <option value="ZW">Zimbabwe</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-secondary">Add Card</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<style type="text/css">
    .panel-payment-method p{
        font-size: 14px;
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
    #invite-modal .panel-header {
        background-color: #edefed;
        color: #484848;
        font-size: 16px;
        padding: 12px 20px;
        border-bottom: 1px solid #dce0e0;
        position: relative;
    }
    #invite-modal .panel-header .panel-close{
        float: right;
        cursor: pointer;
        line-height: 0.7;
        vertical-align: middle;
        font-style: normal;
        font-weight: normal;
        color: #bbb;
        background-color: transparent;
        border: none;
        padding: 0;
        margin: 0;
    }
    #invite-modal .panel-header .contact-search {
        padding: 10px;
        -webkit-border-radius: 0;
        -moz-border-radius: 0;
        border-radius: 0;
        padding-left: 37px;
        width: 100%;
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