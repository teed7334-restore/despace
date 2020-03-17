<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

use App\Contact;
use App\DTO\ResultObjectDTO;
use App\DTO\SendMailDTO;

class ContactService {

    public $ro;

    public function __construct() {
        $this->ro = new ResultObjectDTO();
    }

    public function doSave(\App\DTO\ContactDTO $contact) : \App\DTO\ResultObjectDTO {
        $db = new Contact();
        $db->name = $contact->name;
        $db->company = $contact->company;
        $db->title = $contact->title;
        $db->mail = $contact->businessEmail;
        $db->industry = $contact->industry;
        $db->content = $contact->content;
        $db->save();

        $insertId = $db->id;
        if (empty($insertId)) {
            $this->ro->status = 0;
            $this->ro->message = '無法寫入資料庫';
            return $this->ro;
        }

        $this->ro->status = 1;
        $this->ro->message = '已寫入資料庫';

        return $this->ro;
    }

    public function doSendMail(\App\DTO\ContactDTO $contact) : \App\DTO\ResultObjectDTO {
        $url = env('COUNTER_URL') .  '/Mail/SendMail';
        $mail = new SendMailDTO();
        $mail->To = 'hazeltseng@taipay.com';
        $mail->Cc = 'petercheng@taipay.com';
        $mail->Subject = 'Despace 聯絡資料';
        $content = '
            姓名: %s<br />
            公司: %s<br />
            行業: %s<br />
            職稱: %s<br />
            信箱: %S<br />
            內文: %s<br />
        ';
        $mail->Content = sprintf($content, $contact->name, $contact->company, $contact->industry, $contact->title, $contact->businessEmail, nl2br($contact->content));
        $client = new Client();
        $response = $client->post($url, [\GuzzleHttp\RequestOptions::JSON => $mail]);
        if ($response->getStatusCode() !== 200) {
            $this->ro->status = 0;
            $this->ro->message = $response->getBody();
            return $this->ro;
        }
        $this->ro->status = 1;
        $this->ro->message = '';
        return $this->ro;
    }
}