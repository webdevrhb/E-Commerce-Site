<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Symfony\Component\HttpKernel\Profiler\Profile;

class ProductReview extends Model
{
    use HasFactory;
    protected $fillable=[
        'product_id',
        'customer_id',
        'description',
        'rating'
    ];
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'customer_id');
    }
}
