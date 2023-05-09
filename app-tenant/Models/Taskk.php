<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Taskk extends BaseModel
{
    use SoftDeletes;
    
    protected $appends = ["open"];
 
    public function getOpenAttribute(){
        return true;
    }
}