<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DealerApplication extends Model
{
    protected $fillable = [
        'name',
        'surname',
        'company',
        'address',
        'city',
        'district',
        'phone',
        'email',
        'website',
        'tax_department',
        'tax_no',
        'field_of_activity',
        'company_references',
        'dealer_type',
        'message',
        'is_read',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function getFullNameAttribute(): string
    {
        return trim($this->name . ' ' . ($this->surname ?? ''));
    }

    public function getDealerTypeLabelAttribute(): string
    {
        return match ($this->dealer_type) {
            'domestic' => 'Yurtiçi bayilik',
            'abroad' => 'Yurtdışı bayilik',
            default => (string) $this->dealer_type,
        };
    }
}
