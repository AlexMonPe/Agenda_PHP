<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function getAllContacts()
    {
        return 'GET ALL CONTACTS';
    }
    
    public function getContactById($id)
    {
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
