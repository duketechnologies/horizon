<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStorage extends Model
{
    protected $fillable = [
        'phone',
        'name',
        'sms',
        'telegram_id',
        'lang',
    ];

    public $timestamps = [];

    public function get($key = null) {
        if (is_null($key)) {
            return $this;
        }

        return $this->$key;
    }

    public function set($key = null, $value = null) {
        if (is_array($key)) {
            $this->update($key);
        }

        if ($key && $value) {
            $this->update([$key => $value]);
        }

        return $this;
    }
}
