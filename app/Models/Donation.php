<?php

namespace App\Models;

use App\Enums\DonationStatusEnum;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'status' => DonationStatusEnum::class,
    ];

    public function setStatusPending()
    {
        $this->attributes['status'] = DonationStatusEnum::PENDING;
        self::save();
    }

    public function setStatusSuccess()
    {
        $this->attributes['status'] = DonationStatusEnum::SUCCESS;
        self::save();
    }

    public function setStatusFailed()
    {
        $this->attributes['status'] = DonationStatusEnum::FAILED;
        self::save();
    }

    public function setStatusExpired()
    {
        $this->attributes['status'] = DonationStatusEnum::EXPIRED;
        self::save();
    }
}
