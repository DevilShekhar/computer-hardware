<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PcBuilderStatusHistory extends Model
{
    protected $fillable = ['pc_builder_id','status','updated_by'];
    public function pcBuilder()
    {
        return $this->belongsTo(PcBuilder::class);
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class,'updated_by');
    }
}
