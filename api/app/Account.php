<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends APIModel
{
    // protected $hidden = array('password');
    protected $fillable = ['email', 'username', 'password','company_id'];

    public function account_information(){
      return $this->hasOne('App\AccountInformation');
    }

    public function account_type(){
      return $this->belongsTo('App\AccountType');
    }

    public function account_position(){
      return $this->hasOne('App\AccountPosition');
    }
    public function company_branch_employee(){
      return $this->hasOne('App\CompanyBranchEmployee')->with("company_branch");
    }
}