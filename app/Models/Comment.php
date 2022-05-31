<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    /**
     * @mixin Builder
     */
    class Comment extends Model
    {
        use HasFactory;

        public function user() {
            return $this->belongsTo(User::class);
        }
    }
