<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function getAllContacts()
    {
        // $contacts = DB::table('contacts')
        // ->select('name', 'surname as apellido')
        // ->where('id_user',"=", 1)
        // ->get()
        // ->toArray();
        $userId = auth()->user()->id;

        // $contacts = Contact::where('id_user', 1)->get()->toArray();

        //trae los contactos del usuario $userId
        //$user = User::find($userId)->contacts;

        //trae el usuario del contacto 7
        $contacts = Contact::find(7)->user;

        return response()->json(["data" => $contacts, "success" => "response success"], 200);
    }

    public function getContactById($id)
    {
        // $contact = DB::table('contacts')->where('id_user',"=", 1)->where('id', "=", $id)->get()->toArray();
        $contact = Contact::where('id', $id)->where('id_user', 1)->first();

        if (empty($contact)) {
            return response()->json(
                [
                    "error" => "Contact not found"
                ],
                404
            );
        }

        return response()->json($contact, 200);
    }

    public function createContact(Request $request)
    {
        try {
            $newContact = new Contact();

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'surname' => 'required|string',
                'email' => 'required|email',
                'phone_number' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }


            $newContact->name = $request->name;
            $newContact->surname = $request->surname;
            $newContact->email = $request->email;
            $newContact->phone_number = $request->phone_number;
            $newContact->id_user = $request->id_user;


            $newContact->save();

            return response()->json(["data" => $newContact, "success" => "Contact created"], 200);
        } catch (\Throwable $th) {
            return 'Error';
        }
    }

    public function updateContact(Request $request, $id)
    {
        $contact = Contact::where('id', $id)->where('id_user', 1)->firstOrFail();

        if (empty($contact)) {
            return response()->json(
                [
                    "error" => "Contact not found"
                ],
                404
            );
        }

        if (isset($request->name)) {
            $contact->name = $request->name;
        }
        if (isset($request->surname)) {
            $contact->surname = $request->surname;
        }
        if (isset($request->email)) {
            $contact->email = $request->email;
        }
        if (isset($request->phone_number)) {
            $contact->phone_number = $request->phone_number;
        }
        return response()->json(["data" => $contact, "success" => "Contact updated"], 200);
    }

    public function deleteContact($id)
    {
        $contact = Contact::where('id', $id)->where('id_user', 1)->first();

        if (empty($contact)) {
            return response()->json(
                [
                    "error" => "Contact not found"
                ],
                404
            );
        }

        $contact->delete();

        return response()->json(["data" => $contact, "success" => "Contact deleted"], 200);;
    }
}
