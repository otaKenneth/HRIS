<?php

namespace App;

use App\Models\Admin;
use App\Models\SuperAdmin;
use App\Models\InOut;
use App\Models\DailyTimeRecord;
use App\Models\Salary;
use App\Models\SalaryHistory;
use App\Models\Schedule;
use App\Models\UserAddress;
use App\Models\Payroll\Payroll;
use App\Models\Request\Leave;
use App\Models\Request\Override;
use App\Models\Request\Overtime;
use App\Models\Navigation\UsersNavigations;
use App\Models\Navigation\UserNavigationsConnections;
use Illuminate\Notifications\Notifiable;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'username', 'email', 'userlvl', 'password',
    // ];

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function receivesBroadcastNotificationsOn()
    // {
    //     return 'users.' . $this->id;
    // }

    public function scopeLowerUser ($query)
    {
        return $query->where('userlvl', '>=', auth()->user()->userlvl);
    }

    public function addresses () {
        return $this->hasMany(UserAddress::class);
    }

    public function salary () {
        return $this->hasOne(Salary::class);
    }

    public function salaryHistory ()
    {
        return $this->hasManyThrough(SalaryHistory::class, Salary::class);
    }

    public function gender()
    {
        return $this->hasOne(Lookup::class, 'id', 'gender');
    }

    public function religion()
    {
        return $this->hasOne(Lookup::class, 'id', 'religion');
    }

    public function cstatus()
    {
        return $this->hasOne(Lookup::class, 'id', 'cstatus');
    }

    public function nationality()
    {
        return $this->hasOne(Lookup::class, 'id', 'nationality');
    }

    public function position () {
        return $this->hasOne(Lookup::class, 'id', 'job_position');
    }

    public function status () {
        return $this->hasOne(Lookup::class, 'id', 'job_status');
    }

    public function user_level()
    {
        return $this->hasOne(Lookup::class, 'id', 'userlvl');
    }

    public function navigations()
    {
        return 
            $this->hasManyThrough(UsersNavigations::class, UserNavigationsConnections::class, 'user_id', 'id', 'id', 'main_nav_id')
            ->groupBy('user_navigations_connections.main_nav_id')
            ->with('sub_navigations');
    }

    public function admin ()
    {
        return $this->hasOne(Admin::class);
    }

    public function super_admin ()
    {
        return $this->hasOne(SuperAdmin::class);
    }

    public function inouts ()
    {
        return $this->hasMany(InOut::class);
    }

    public function ins ()
    {
        return $this->hasMany(InOut::class)->where('type', 0);
    }

    public function breakOuts ()
    {
        return $this->hasMany(InOut::class)->where('type', 2);
    }

    public function breakIns ()
    {
        return $this->hasMany(InOut::class)->where('type', 3)->orderBy('created_at', 'DESC');
    }

    public function outs ()
    {
        return $this->hasMany(InOut::class)->where('type', 1)->orderBy('created_at', 'DESC');
    }

    public function schedules ()
    {
        return $this->hasMany(Schedule::class)->orderBy('effectivitydate', 'DESC');
    }

    public function latestSchedule()
    {
        return $this->hasMany(Schedule::class)->whereRaw("effectivitydate <= CURDATE()")->orderBy('created_at', 'DESC')->orderBy('day')->limit(7);
    }

    public function dtrs ()
    {
        return $this->hasMany(DailyTimeRecord::class);
    }


    public function userNames () 
    {
        return $this->select('id', DB::raw("concat(lastname, ', ', firstname, ' ', middlename) as name"))->where('userlvl', '>=', auth()->user()->userlvl)->orderBy('lastname')->get();
    }

    public function leaves ()
    {
        return $this->hasMany(Leave::class)->orderBy('created_at');
    }

    public function leaveCredits ()
    {
        // $credits = DB::table('users')->select('sl_credits', 'vl_credits')->get();
        // return $credits;
        return [
            'SL' => $this->sl_credits,
            'VL' => $this->vl_credits
        ];
    }

    public function overrides ()
    {
        return $this->hasMany(Override::class);
    }

    public function overtimes ()
    {
        return $this->hasMany(Overtime::class);
    }

    public function payrolls ()
    {
        return $this->hasMany(Payroll::class);
    }

    public function unprocessedPayrolls ()
    {
        return $this->hasMany(Payroll::class)->where("processed", false);
    }

    public function userArrayFillable () {
        return [
            'profile' => null,
            'employee_id' => null,
            'firstname' => null,
            'middlename' => null,
            'lastname' => null,
            'username' => null,
            'age' => null,
            'birthdate' => null,
            'gender' => null,
            'cstatus' => null,
            'religion' => null,
            'nationality' => null,
            'userlvl' => 0,
            'email' => null,
            'mnum' => null,
            'tnum' => null,
            'tax' => null,
            'sss' => null,
            'philhealth' => null,
            'pagibig' => null,
            'job_position' => null,
            'job_status' => null,
            'emp_status' => null,
            'hire_date' => null,
            'training_start' => null,
            'training_evaluation' => null,
            'probi_start' => null,
            'probi_evaluation' => null,
            'reg_start' => null,
            'reg_end' => null,
            'sl_credits' => null,
            'vl_credits' => null,
            'rol' => null,
            'remarks' => null,
            'addresses' => [],
        ];
    }
}
