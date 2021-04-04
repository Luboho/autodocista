<?php

namespace App\Models;

use App\Models\User;
use App\Models\ContactFormMessage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function messages()
    {
        return $this->hasMany(ContactFormMessage::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
