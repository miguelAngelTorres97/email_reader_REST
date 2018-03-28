<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \DateTime;
use App\Config;

class Email extends Model
{
    protected $seen, $sender, $mailDate, $subject, $message;
    
    public function __construct($con, $email_number){
        $overview = imap_fetch_overview($con, $email_number, 0 )[0];
        
        $this->seen = $overview->seen;
        $this->sender = $overview->from;
        $this->subject = isset($overview->subject) ? $overview->subject : '' ;
        $this->mailDate = new DateTime($overview->date);
        $this->mailDate = $this->mailDate->format( Config::$dateFormat );

        $this->message = imap_fetchbody($con,$email_number,1.1, FT_PEEK); 
        if(empty($this->message)) $this->message = quoted_printable_decode(imap_fetchbody($con,$email_number,1, FT_PEEK));
        
        $this->message = strip_tags($this->message);
    }
    
    public function getSeen(){
        return $this->seen;
    }
    
    public function getSender(){
        return imap_utf8(mb_decode_mimeheader($this->sender));
    }
    
    public function getDate(){
        return $this->mailDate;
    }
    
    public function getSubject(){
        return imap_utf8($this->subject);
    }
    
    public function getMessage(){
        return imap_utf8($this->message);
    }
    
    
}
