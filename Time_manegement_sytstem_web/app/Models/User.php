<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\mail_notifications;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'Firstname',
        'Lastname',
        'email',
        'role',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }




    
    public function senNotifications(){

        $users = User::all();

        //details de la notification
        $details = [
            'subject'=>'Nouvelle mise à jour',
            'body'=> 'Nouvelles fonctions ajoutées',
            'url' => ''
        ];

        //envoie des notifications
        foreach($users as $user){
            $user->notify(new mail_notifications($details));
        }
        return response()->json(['message' => 'Notifications envoyées']);
    }
}
