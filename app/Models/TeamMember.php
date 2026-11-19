<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title_degree',
        'identifier',
        'position',
        'type',
        'expertise',
        'academic_rank',
        'photo',
        'bio',
        'email',
        'phone',
        'order_index',
        'is_active',
    ];

    protected $casts = [
        'order_index' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Scope active members
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope dosen (tenaga pendidik)
     */
    public function scopeDosen($query)
    {
        return $query->where('type', 'dosen');
    }

    /**
     * Scope tendik (tenaga kependidikan)
     */
    public function scopeTendik($query)
    {
        return $query->where('type', 'tendik');
    }

    /**
     * Scope ordered
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index', 'asc')->orderBy('id', 'asc');
    }

    /**
     * Get label for type
     */
    public function getTypeLabelAttribute(): string
    {
        return $this->type === 'tendik' ? 'Tenaga Kependidikan' : 'Dosen';
    }

    public function getFullTitleAttribute(): string
    {
        return $this->name . ($this->title_degree ? ', ' . $this->title_degree : '');
    }
}
