<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PayrollExport implements FromCollection, WithHeadings
{
    protected $from;
    protected $to;

    public function __construct($from,$to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function collection()
    {
        $attendance = DB::table('attendances')
            ->join('users','users.id','=','attendances.user_id')
            ->whereBetween('attendances.date',[$this->from,$this->to])
            ->select(
                'users.id',
                'users.name',
                'users.weekday_rate',
                'users.weekend_rate',
                'attendances.date'
            )
            ->get();

        $leaves = DB::table('leaves')
            ->join('users','users.id','=','leaves.user_id')
            ->where('leaves.status','approved')
            ->whereBetween('leaves.date',[$this->from,$this->to])
            ->select(
                'users.id',
                'users.name',
                'users.weekday_rate',
                'users.weekend_rate',
                'leaves.date'
            )
            ->get();

        $rows = $attendance->merge($leaves);

        $overtimeRate = DB::table('settings')
            ->where('key','overtime_rate')
            ->value('value') ?? 0;

        $overtimes = DB::table('overtimes')
            ->whereBetween('date',[$this->from,$this->to])
            ->select('user_id',DB::raw('SUM(hours) as total'))
            ->groupBy('user_id')
            ->pluck('total','user_id');

        $recap = [];

        foreach($rows as $r){

            if(!isset($recap[$r->id])){
                $recap[$r->id]=[
                    'Nama'=>$r->name,
                    'Weekday'=>0,
                    'Weekend'=>0,
                    'Cuti'=>0,
                    'Lembur Jam'=>$overtimes[$r->id] ?? 0,
                    'Total'=>0,
                    'weekday_rate'=>$r->weekday_rate,
                    'weekend_rate'=>$r->weekend_rate
                ];
            }

            $day = date('w',strtotime($r->date));

            if($day==0 || $day==6){
                $recap[$r->id]['Weekend']++;
            }else{
                $recap[$r->id]['Weekday']++;
            }
        }

        foreach($leaves as $l){
            if(isset($recap[$l->id])){
                $recap[$l->id]['Cuti']++;
            }
        }

        foreach($recap as &$r){

            $total =
                (($r['Weekday']+$r['Cuti']) * $r['weekday_rate']) +
                ($r['Weekend'] * $r['weekend_rate']) +
                ($r['Lembur Jam'] * $overtimeRate);

            $r['Total'] = $total;

            unset($r['weekday_rate']);
            unset($r['weekend_rate']);
        }

        return collect(array_values($recap));
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Weekday',
            'Weekend',
            'Cuti',
            'Lembur Jam',
            'Total'
        ];
    }
}
