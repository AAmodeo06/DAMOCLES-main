<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhishingEmailPhishingCampaign extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'phishing_emails_phishing_campaigns';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phishing_campaign_id',
        'subject',
        'body',
    ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Define a one-to-one relationship with PhishingCampaign model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function phishingCampaign()
    {
        return $this->belongsTo(PhishingCampaign::class, 'phishing_campaign_id');
    }
}
