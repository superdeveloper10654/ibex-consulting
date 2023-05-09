<?php

namespace AppTenant\Models;

use App\Services\Helpers\Str as HelpersStr;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class BaseModel extends Model
{
    /** @var array Cached items for object attributes */
    protected $cached_attrs = [];

    /** @var string (optional) permission prefix */
    protected static $permission_prefix = '';

    /** @var string (optional) resource prefix for route */
    protected static $route_prefix = '';

    /** @var string resource activity icon */
    public static $activity_icon = '<i class="mdi mdi-book-edit-outline"></i>';

    /**
     * Check if resource can be updated
     * @return bool
     */
    public function canBeUpdated()
    {
        if (method_exists(static::class, 'status')) {
            if (($this->isDraft() && $this->hasAuthor(t_profile())) || $this->isSubmitted() || $this->isNotified()) {
                return true;
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if resource can be deleted
     * @return bool
     */
    public function canBeDeleted()
    {
        if (method_exists(static::class, 'status')) {
            if ($this->isSubmitted() || $this->isNotified()) {
                return true;
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * If the resource has specific author
     * 
     * @throws Exception
     * @return bool
     */
    public function hasAuthor(User $author_profile)
    {
        if (empty($this->author_profile) && empty($this->created_by) && empty($this->author)) {
            throw new Exception('Author relation is not defined in this model');
        }

        if (!empty($this->author_profile)) {
            return $this->author_profile->id == $author_profile->id;
        } else if (!empty($this->created_by)) {
            return $this->created_by == $author_profile->id;
        } else {
            return $this->author->id == $author_profile;
        }
    }

    /**
     * Link to resource
     * @param string $action create|show|edit etc
     * @param bool $absolute path or not
     * @return
     */
    public function link($action = '', $absolute = true)
    {
        if (empty(static::$route_prefix)) {
            $name = class_basename(static::class);
            $name = HelpersStr::camelToLowerCaseAndSeparateWith('-', $name);
            $name = HelpersStr::singularToPlural($name);
            $route_prefix = $name;
        } else {
            $route_prefix = static::$route_prefix;
        }

        $params = !empty($action) ? $this->id : [];
        $route_name = !empty($action) ? "{$route_prefix}.{$action}" : "{$route_prefix}";

        return Route::has($route_name) ? t_route($route_name, $params, $absolute) : '';
    }

    /**
     * Get name of the resource
     * @return string
     */
    public static function resourceName()
    {
        return HelpersStr::camelCaseSeparateWith(' ', ((new \ReflectionClass(static::class))->getShortName()));
    }

    /**
     * Get dashed name of the resource
     * @return string
     */
    public static function resourceNameDashed()
    {
        return HelpersStr::camelToLowerCaseAndSeparateWith('-', ((new \ReflectionClass(static::class))->getShortName()));
    }

    /**
     * Get permission
     * @return string $action
     * @return string
     */
    public static function permission($action)
    {
        if (empty(static::$permission_prefix)) {
            $class_name_plural = HelpersStr::singularToPlural((new \ReflectionClass(static::class))->getShortName());
            $permission_prefix = HelpersStr::camelToLowerCaseAndSeparateWith('-', $class_name_plural);
        } else {
            $permission_prefix = static::$permission_prefix;
        }

        return "$permission_prefix.{$action}";
    }
}
