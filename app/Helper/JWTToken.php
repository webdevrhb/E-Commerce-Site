<?php
namespace App\Helper;
use Exception;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use function PHPUnit\Framework\returnArgument;

class JWTToken
{
    public static function CreateToken($UserEmail,$UserID):string
    {
        $key =env('JWT_KEY');
        $payload=[
            'iss'=>'laravel-token',
            'iat'=>time(),
            'exp'=>time()+24*60*60,
            'userEmail'=>$UserEmail,
            'userID'=>$UserID
        ];
        return JWT::encode($payload,$key,'HS256');
    }

    public static function ReadToken($token): string|object
    {
        try {
            if($token==null){
                return 'unauthorized';
            }
            else{
                $key =env('JWT_KEY');
                return JWT::decode($token,new Key($key,'HS256'));
            }
        }
        catch (Exception $e){
            return 'unauthorized';
        }
    }

}
