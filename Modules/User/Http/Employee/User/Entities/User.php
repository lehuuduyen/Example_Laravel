<?php

    namespace Modules\User\Entities;

    use Hash;
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Tymon\JWTAuth\Contracts\JWTSubject;

    class User extends Authenticatable implements JWTSubject
    {
        public static $TYPE_USER     = 1;//is user
        public static $TYPE_CUSTOMER = 2;//is customer
        //Type work
        public static $TYPE_WORK_FULL_TIME = 1;//is full time
        public static $TYPE_WORK_PART_TIME = 2;//is part time
        //Type level
        public static $TYPE_LEVEL_TRY      = 1;// Thu viẹc
        public static $TYPE_LEVEL_OFFICIAL = 2;// Chinh thuc
        //Gender
        public static $TYPE_GENDER_MALE   = 1;//Nam
        public static $TYPE_GENDER_FEMALE = 2;//Nu
        public static $TYPE_GENDER_OTHER  = 3;//Khac
        //
//        use EntrustUserTrait; // add this trait to your user model
        use Notifiable;
        use Notifiable;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name',
            'email',
            'password',
            'level',
            'phone'
        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'password',
            'remember_token',
        ];

        /**
         * Automatically creates hash for the user password.
         *
         * @param  string $value
         * @return void
         */
        public function setPasswordAttribute($value)
        {
            $this->attributes['password'] = Hash::make($value);
        }

        /**
         * Get the identifier that will be stored in the subject claim of the JWT.
         *
         * @return mixed
         */
        public function getJWTIdentifier()
        {
            return $this->getKey();
        }

        /**
         * Return a key value array, containing any custom claims to be added to the JWT.
         *
         * @return array
         */
        public function getJWTCustomClaims()
        {
            return [];
        }
    }
