<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function getAllContacts()
    {
        $contacts = DB::table('contacts')->where('id_user',"=", 1)->get()->toArray();

        return $contacts;
    }
    
    public function getContactById($id)
    {
        $contact = DB::table('contacts')->where('id_user',"=", 1)->where('id', "=", $id)->get()->toArray();
        $contact = DB::table('contacts')->where('id_user', "=", 1)->find($id);

        return 'GET CONTACT BY ID ->'.$id;
    }

    public function createContact(Request $request)
    {
        dump($request->input('name'));
        return 'CREATE CONTACT';
    }

    public function updateContact(Request $request, $id)
    {
        dump($request->input('name'));
        return 'update CONTACT by id: '.$id;
    }

    public function deleteContact($id)
    {
        return 'DELETE CONTACT by id: '.$id;
    }    
}
