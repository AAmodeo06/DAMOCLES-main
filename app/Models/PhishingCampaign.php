<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhishingCampaign extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'phishing_campaigns';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'numberEmails',
        'context_id',
        'emotionalTriggers',
        'persuasions',
        'llm_id',
        'prompt',
        'evaluator_id',
        'state', //Draft - In bozza, Ready - Pronto, Ongoing - Avviato, Finished - Concluso
        'expirationDate',
        'timingEmail'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'emotionalTriggers' => 'array',
        'persuasions' => 'array',
    ];

    /**
     * Define a belongsTo relationship with PhishingContext model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function phishingContext()
    {
        return $this->belongsTo(PhishingContext::class, 'context_id');
    }

    /**
     * Define a one-to-many relationship with PhishingPersuasion model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function phishingPersuasions()
    {
        return $this->hasMany(PhishingPersuasion::class);
    }

    /**
     * Define a one-to-many relationship with PhishingEmotionalTrigger model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function phishingEmotionalTriggers()
    {
        return $this->hasMany(PhishingEmotionalTrigger::class);
    }

    /**
     * Define a belongsTo relationship with LLM model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function llm()
    {
        return $this->belongsTo(LLM::class);
    }

    /**
     * Define a one-to-one relationship with PhishingEvaluator model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function phishingEvaluator()
    {
        return $this->hasOne(PhishingEmailPhishingCampaign::class, 'phishing_campaign_id');
    }

    /*
    /**
     * Define a one-to-one relationship with PhishingEmailPhishingCampaign model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function phishingEmails()
    {
        return $this->hasMany(PhishingEmailPhishingCampaign::class, 'phishing_campaign_id');
    }
}
