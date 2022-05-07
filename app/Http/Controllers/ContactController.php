<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function getAllContacts()
    {
        try {
            Log::info('init get all contacts');
            // $contacts = DB::table('contacts')
            // ->select('name', 'surname as apellido')
            // ->where('id_user',"=", 1)
            // ->get()
            // ->toArray();
            $userId = auth()->user()->id;

            //$contacts = Contact::where('id_user', $userId)->get()->toArray();

            //trae los contactos del usuario $userId
            $contacts = User::find($userId)->contacts;

            //trae el usuario del contacto 7
            //$contacts = Contact::find(7)->user;

            return response()->json(["data" => $contacts, "success" => "response success"], 200);
        } catch (\Throwable $th) {
            Log::error('Error en get all contacts ' . $th->getMessage());
            return response()->json([
                "name" => $th->getMessage(),
                "error" => 'Error al obtener todos los contactos'
            ], 500);
        }
    }

    public function getContactById($id)
    {
        try {
            Log::info('init get contacts by id');
            // $contact = DB::table('contacts')->where('id_user',"=", 1)->where('id', "=", $id)->get()->toArray();
            $userId = auth()->user()->id;

            $contact = Contact::where('id_user', $userId)->where('id', $id)->first();

            if (empty($contact)) {
                return response()->json(
                    [
                        "error" => "Contact not found"
                    ],
                    404
                );
            }

            return response()->json($contact, 200);
        } catch (\Throwable $th) {
            Log::error('Error en get contact by id ' . $th->getMessage());
            return response()->json([
                "name" => $th->getMessage(),
                "error" => 'Error al obtener el contacto por id'
            ], 500);
        }
    }

    public function createContact(Request $request)
    {
        try {
            Log::info('init create contact');

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'surname' => 'required|string',
                'email' => 'required|email',
                'phone_number' => 'required|string',
            ]);

            if ($validator->fails()) return response()->json($validator->errors(), 400);
            $userId = auth()->user()->id;

            $newContact = new Contact();

            $newContact->name = $request->name;
            $newContact->surname = $request->surname;
            $newContact->email = $request->email;
            $newContact->phone_number = $request->phone_number;
            $newContact->id_user = $userId;

            $newContact->save();

            // recupera toda la request del body.
            // $contact = $request->all();
            // $newContact = Contact::create($contact);

            return response()->json(["data" => $newContact, "success" => "Contact created"], 200);
        } catch (\Throwable $th) {
            Log::error('Error en create contact' . $th->getMessage());
            return response()->json([
                "name" => $th->getMessage(),
                "error" => 'Error al crear un nuevo contacto'
            ], 500);
        }
    }

    public function updateContact(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'string',
                'surname' => 'string',
                'email' => 'email',
                'phone_number' => 'string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $userId = auth()->user()->id;

            $contact = Contact::where('id', $id)->where('id_user', $userId)->firstOrFail();

            if (empty($contact)) {
                return response()->json(
                    [
                        "error" => "Contact not found"
                    ],
                    404
                );
            }

            if (isset($request->name)) $contact->name = $request->name;
            if (isset($request->surname)) $contact->surname = $request->surname;
            if (isset($request->email)) $contact->email = $request->email;
            if (isset($request->phone_number)) $contact->phone_number = $request->phone_number;

            $contact->save();

            return response()->json(["data" => $contact, "success" => "Contact updated"], 200);
        } catch (\Throwable $th) {
            Log::error('Error en update contact by id ' . $th->getMessage());
            return response()->json([
                "name" => $th->getMessage(),
                "error" => 'Error al actualizar el contacto por id'
            ], 500);
        }
    }

    public function deleteContact($id)
    {
        try {
            $userId = auth()->user()->id;

            $contact = Contact::where('id', $id)->where('id_user', $userId)->first();

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
        } catch (\Throwable $th) {
            Log::error('Error in delete contact by id ' . $th->getMessage());
            return response()->json([
                "name" => $th->getMessage(),
                "error" => 'Error al borrar el contacto por id'
            ], 500);
        }
    }
}
