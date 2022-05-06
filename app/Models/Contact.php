<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    //Se utiliza para hacer asignamiento masivo con el metodo de eloquent
    //create en el post contacts.
    protected $fillable = [
        'name',
        'surname',
        'phone_number',
        'email',
        'id_user',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }
}
