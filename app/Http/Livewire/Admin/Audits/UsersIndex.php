<?php

namespace App\Http\Livewire\Admin\Audits;

use App\Models\UserAudit;
use Livewire\Component;

class UsersIndex extends Component
{
    public $date;

    public function render()
    {
        $user_audits = UserAudit::when($this->date, function($query, $data){
                                return $query->whereDate('created_at',$data);
                            })
                            ->latest('id')->paginate(15);
        return view('livewire.admin.audits.users-index', compact('user_audits'));
    }
}
