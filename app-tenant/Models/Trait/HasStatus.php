<?php

namespace AppTenant\Models\Trait;

use AppTenant\Services\Helper;
use Exception;
use Illuminate\Support\Facades\Auth;

trait HasStatus
{
    /**
     * Generate Status model with namespace
     * 
     * @return string
     */
    public static function getStatusModel()
    {
        static::validateModelStatus();
        $name = ((new \ReflectionClass(static::class))->getShortName());

        if (!class_exists('AppTenant\Models\Status\\' . $name . 'Status')) {

        }

        return 'AppTenant\Models\Status\\' . $name . 'Status';
    }

    /**
     * If the resource has status Accepted
     * @throws Exception
     * @return bool
     */
    public function isAccepted()
    {
        $status_model = static::getStatusModel();

        return $status_model::hasConst('ACCEPTED_ID') && $this->status == $status_model::ACCEPTED_ID;
    }

    /**
     * If the resource has status Closed
     * @throws Exception
     * @return bool
     */
    public function isClosed()
    {
        $status_model = static::getStatusModel();

        return $status_model::hasConst('CLOSED_ID') && $this->status == $status_model::CLOSED_ID;
    }

    /**
     * If the resource has status Drafted
     * @throws Exception
     * @return bool
     */
    public function isDraft()
    {
        $status_model = static::getStatusModel();

        return $status_model::hasConst('DRAFT_ID') && $this->status == $status_model::DRAFT_ID;
    }

    /**
     * If the resource has status Escalated
     * @throws Exception
     * @return bool
     */
    public function isEscalated()
    {
        $status_model = static::getStatusModel();

        return $status_model::hasConst('ESCALATED_ID') && $this->status == $status_model::ESCALATED_ID;
    }

    /**
     * If the resource has status Notified
     * @throws Exception
     * @return bool
     */
    public function isNotified()
    {
        $status_model = static::getStatusModel();

        return $status_model::hasConst('NOTIFIED_ID') && $this->status == $status_model::NOTIFIED_ID;
    }

    /**
     * If the resource has status Rejected
     * @throws Exception
     * @return bool
     */
    public function isRejected()
    {
        $status_model = static::getStatusModel();

        return $status_model::hasConst('REJECTED_ID') && $this->status == $status_model::REJECTED_ID;
    }

    /**
     * If the resource has status Submitted
     * @throws Exception
     * @return bool
     */
    public function isSubmitted()
    {
        $status_model = static::getStatusModel();

        return $status_model::hasConst('SUBMITTED_ID') && $this->status == $status_model::SUBMITTED_ID;
    }

    /**
     * Status object 
     * 
     * @return object<id,value>
     */
    public function status()
    {
        $status_class = static::getStatusModel();

        return $status_class::get($this->status);
    }

    /**
     * Query - condition to get row with status == DRAFT_ID and created_by = t_profile()->id
     * 
     * @param integer $id
     * @return static
     */
    public static function findMineDraftedOrFail($id)
    {
        $item = static::findOrFail($id);

        if (!$item->isDraft() || !$item->hasAuthor(t_profile())) {
            abort(404);
        }

        return $item;
    }

    /**
     * Condition to get row with status <> DRAFT_ID (detected automatically using model name) 
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $q
     * @return void
     */
    public static function scopeNotDrafted($q)
    {
        $status_model = static::getStatusModel();
        $q->where('status', '<>', $status_model::DRAFT_ID);
    }

    /**
     * Condition to get row with status <> DRAFT_ID (detected automatically using model name) 
     * or created_by = t_profile()->id
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $q
     * @return void
     */
    public static function scopeNotDraftedOrMine($q)
    {
        $status_model = static::getStatusModel();
        $q->notDrafted()
            ->orWhere(function ($q) use ($status_model) {
                if (Helper::modelHasAttributes(static::class, 'created_by')) {
                    $author_profile_field = 'created_by';
                } else if (Helper::modelHasAttributes(static::class, 'profile_id')) {
                    $author_profile_field = 'profile_id';
                } else {
                    throw new Exception('Can not determine author field for model ' . static::class);
                }

                $q->where('status', $status_model::DRAFT_ID)
                    ->where($author_profile_field, t_profile()->id);
            });
    }

    /**
     * Check if status exists in the model
     * @return true
     * @throws Exception
     */
    private static function validateModelStatus()
    {
        if (!Helper::modelHasAttributes(static::class, 'status')) {
            throw new Exception('Status is not defined in this resource');
        }

        return true;
    }
}