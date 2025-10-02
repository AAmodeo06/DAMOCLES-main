<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionnaireQuestionnaireCampaign extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'questionnaires_questionnaires_campaigns';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'q_id', 'q_c_id'
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
     * Define a belongsTo relationship with Questionnaire model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }

    /**
     * Define a belongsTo relationship with QuestionnaireCampaign model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function questionnaireCampaign()
    {
        return $this->belongsTo(QuestionnaireCampaign::class, 'questionnaire_campaign_id');
    }
}
