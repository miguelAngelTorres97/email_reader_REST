<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmailReader;
use App\Email;

class EmailController extends BaseController
{
    public $restful = true;
    private $resp;
    
    public function printEmails(){
        $reader = new EmailReader();

        $data;
        if($reader->emails) {
            rsort($reader->emails);

            foreach($reader->emails as $i => $email_number) {
                if($reader->n === 0 || Config::$maxEmails <= $i)  break;

                $email = new Email($reader->con, $email_number);
                $data[] = $email;
                $reader->n--;
            }
            $this->resp['status'] = 'success';
            $this->resp['data'] = $data;
            
            return json_encode($this->resp);
        }
    }
}
