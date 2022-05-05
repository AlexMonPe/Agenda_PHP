<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function getAllContacts()
    {
        // $contacts = DB::table('contacts')
        // ->select('name', 'surname as apellido')
        // ->where('id_user',"=", 1)
        // ->get()
        // ->toArray();

        $contacts = Contact::where('id_user', 1)->get()->toArray();

        return response()->json(["success" => "response success"],200);
    }
    
    public function getContactById($id)
    {
        // $contact = DB::table('contacts')->where('id_user',"=", 1)->where('id', "=", $id)->get()->toArray();
        $contact = Contact::where('id', $id)->where('id_user', 1)->first();

        if(empty($contact)) {
            return response()->json([
                "error" => "Contact not found"
            ]
            , 404);
        }

        return response()->json($contact,200);
    }

    public function createContact(Request $request)
    {
        $newContact = new Contact();

        $newContact->name = $request->name;
        $newContact->surname = $request->surname;
        $newContact->email = $request->email;
        $newContact->phone_number = $request->phone_number;
        $newContact->id_user = $request->id_user;


        $newContact->save();

        return response()->json(["data" => $newContact, "success" => "Contact created"],200);
    }

    public function updateContact(Request $request, $id)
    {
        

        
        return 'update CONTACT by id: '.$id;
    }

    public function deleteContact($id)
    {
        return 'DELETE CONTACT by id: '.$id;
    }    
}
