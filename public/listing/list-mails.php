<?php

namespace App;

use App\Email;
use App\Config;
use App\EmailReader;

global $reader;

if($reader->emails) :
            rsort($reader->emails);
?>
<div id="mails">
    <?php
	foreach($reader->emails as $i => $email_number) :
        if($reader->n === 0 || Config::$maxEmails <= $i)  break;
    
        $email = new Email($reader->con, $email_number);
    
        
            $reader->n--;
?>      
        <div class="card card-nav-tabs mail-fields">
            <a data-toggle="collapse" href="#msg<?php echo $i?>" role="button" aria-expanded="false" aria-controls="msg<?php echo $i?>">
            <div class="card-header card-header-primary">
                <div class="nav-tabs-navigation">
                    
                        <div class="nav-tabs-wrapper mail-fields" >
                            <div class="row">

                                <div class="mail-field-sm tx-center mx-2">
                                    <?php echo ($email->getSeen() ? "<i class=\"material-icons\">done</i>" : "<i class=\"material-icons\">email</i>");?>
                                </div>
                                <div class="mail-field-md ml-4">
                                    <?php echo $email->getSender();?>
                                </div>
                                <div class="mail-field-sm ml-2 mr-1 tx-center">
                                    <?php echo $email->getDate();?>
                                </div>
                                <div class="mx-5">
                                    <?php echo $email->getSubject();?>
                                </div>

                            </div>
                        </div>
                    
                </div>
            </div>
            </a>
            <div class="collapse" id="msg<?php echo $i?>" data-parent="#mails" >
                <div class="card-body ">
                    <div class="tab-content mail-msg">
                        <div class="tab-pane active" id="profile">
                            <?php echo $email->getMessage();?>
                        </div>

                    </div>
                </div>
            </div>
            
        </div>

<?php endforeach;?>
    </div>
<?php endif;?>