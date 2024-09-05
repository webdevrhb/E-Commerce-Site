<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Symfony\Component\HttpKernel\Profiler\Profile;

class User extends Model
{
    use HasFactory;
    protected $fillable=['email','otp'];
    public function profile():HasOne
    {
        return $this->hasOne(CustomerProfile::class);
    }
}
