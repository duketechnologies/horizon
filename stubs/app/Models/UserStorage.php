<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Orbit\Concerns\Orbital;

class UserStorage extends Model
{
    use Orbital;

    public static $driver = 'json';

    public static function schema(Blueprint $table)
    {
        $table->id();

        $table->string('phone')->default('-');
        $table->string('sms')->default('-');
        $table->string('name')->default('-');
        $table->foreignId('city_id')->nullable()->constrained();


        $table->string('telegram_id');
        $table->string('lang')->default('ru');
    }

    protected $fillable = [
        'phone',
        'name',
        'sms',
        'telegram_id',
        'lang',
    ];

    public $timestamps = [];

    public static function get($key = null) {
        $chat = message_chat();
        $user_storage = self::where('telegram_id', $chat['id'])->first();

        if($key) return $user_storage->$key;
        return $user_storage;
    }

    public static function set($arr = null) {
        $chat = message_chat();
        $user_storage = self::where('telegram_id', $chat['id'])->first();

        if ($arr && is_array($arr)) $user_storage->update($arr);
        return $user_storage;
    }
}
