<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'customer_id');
    }

    public function paket()
    {
        return $this->hasOne(Paket::class, 'id', 'paket_id');
    }

    public function server()
    {
        return $this->hasOne(Server::class, 'id', 'server_id');
    }
}
