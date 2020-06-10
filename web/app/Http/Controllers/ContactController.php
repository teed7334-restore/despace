<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DTO\ContactDTO;
use App\DTO\ResultObjectDTO;
use App\Services\ContactService;

class ContactController extends Controller
{
    private $ro;

    public function __construct()
    {
        $this->ro = new ResultObjectDTO();
    }

    public function save(Request $request)
    {
        $contact = new ContactDTO();
        $contact->name = strip_tags($request->input('name') ?? null);
        $contact->company = strip_tags($request->input('company') ?? null);
        $contact->title = strip_tags($request->input('title') ?? null);
        $contact->businessEmail = strip_tags($request->input('businessEmail') ?? null);
        $industry = "";
        $accept = ['AI人工智慧', '大數據', 'IoT物聯網', '金融科技', '雲端運算', '區塊鏈'];
        foreach ($request->input('industry') as $value) {
            if (in_array($value, $accept)) {
                $industry .= $value . " ,";
            }
        }
        $contact->industry = $industry;
        $contact->content = strip_tags($request->input('content') ?? null);
        
        $cs = new ContactService();
        $this->ro = $cs->doSave($contact);
        if ($this->ro->status === 0) {
            $response = ['redirectMessage' => 1, 'message' => $this->ro->message, 'url' => '/'];
            return view('flashMessage', $response);
        }

        $this->ro = $cs->doSendMail($contact);
        if ($this->ro->status === 0) {
            $response = ['redirectMessage' => 1, 'message' => $this->ro->message, 'url' => '/'];
            return view('flashMessage', $response);
        }

        $response = ['redirectMessage' => 1, 'message' => "謝謝您的回應", 'url' => '/'];
        return view('flashMessage', $response);
    }
}
