<?php

namespace App\Http\Controllers;

use App\Models\DailyTimeRecord;
use App\Models\Payroll\Payroll;
use App\Models\Payroll\Setting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class PayrollController extends Controller
{
    public function __construct()
    {
        $this->user = new User();
        $this->dtr = new DailyTimeRecord();
        $this->payroll = new Payroll();
        $this->today = date('Y-m-d');
        $this->payroll_settings = [];
        foreach (Setting::payroll()->get() as $key => $value) {
            data_fill($this->payroll_settings, $value['key'], str_replace("%", "", $value['value']));
        }
        // dd($this->payroll_settings);
        $this->ot = [
            "regular" => ['count' => 0],
            "restday" => ['count' => 0],
            "NW-SH" => ['count' => 0],
            "SH" => ['count' => 0],
            "SH & RD" => ['count' => 0],
            "NW-RH" => ['count' => 0],
            "RH" => ['count' => 0],
            "RH & RD" => ['count' => 0],
            "ND" => ['count' => 0],
            "ND & RD" => ['count' => 0],
            "ND & NW-SH" => ['count' => 0],
            "ND & SH" => ['count' => 0],
            "ND & SH & RD" => ['count' => 0],
            "ND & NW-RH" => ['count' => 0],
            "ND & RH" => ['count' => 0],
            "ND & RH & RD" => ['count' => 0],
        ];
        $this->work = [
            "regular" => ['count' => 0],
            "restday" => ['count' => 0],
            "NW-SH" => ['count' => 0, 'value' => 0],
            "SH" => ['count' => 0],
            "SH & RD" => ['count' => 0],
            "NW-RH" => ['count' => 0, 'value' => 0],
            "RH" => ['count' => 0],
            "RH & RD" => ['count' => 0],
            "ND" => ['count' => 0],
            "ND & RD" => ['count' => 0],
            "ND & NW-SH" => ['count' => 0, 'value' => 0],
            "ND & SH" => ['count' => 0],
            "ND & SH & RD" => ['count' => 0],
            "ND & NW-RH" => ['count' => 0, 'value' => 0],
            "ND & RH" => ['count' => 0],
            "ND & RH & RD" => ['count' => 0],
        ];
        $this->payroll_values = [
            'work_days' => null,
            'allowance' => null,
            'absences' => null,
            'late' => null,
            'ut' => null,
            'ot' => null,
            'sl' => [
                'paid' => 0,
                'unpaid' => 0,
            ],
            'vl' => [
                'paid' => 0,
                'unpaid' => 0,
            ],
            'SH' => null,
            'RH' => null,
        ];
        $this->totals = [
            'total_work_days' => 0,
            'total_allowance' => 0,
            'total_absences' => 0,
            'total_late' => 0,
            'total_ut' => 0,
            'total_ot' => 0,
            'total_sl' => 0,
            'total_vl' => 0,
            'total_paid_sl' => 0,
            'total_paid_vl' => 0,
            'total' => 0,
        ];
    }

    public function process($row)
    {
        // $user = $this->user->find(2);
        // $toProcess = $user->unprocessedPayrolls()->where("range_from", "<=", $this->today)->get();
        // foreach ($toProcess as $row) {
        $this->getTotalWorkingHours($row);
        $this->getTotalOTHours($row);
        $this->getLeaves($row);
        $this->getAbsences($row);
        $this->getAllowances($row);
        $this->getLate($row);
        $this->getUndertime($row);
        $this->getSH($row);
        $this->getRH($row);
        if ($row->type == "monthly") {
            $toSubtract = array_sum(Arr::only($this->totals, ['total_absences', 'total_late', 'total_ut', 'total_sl', 'total_vl']));
            $toAdd = array_sum(Arr::only($this->totals, ['total_allowance', 'total_ot']));
            $this->totals['total'] = ($row->half - $toSubtract) + $toAdd;
        } elseif ($row->type == "daily") {
            $toAdd = array_sum(Arr::only($this->totals, ['total_work_days', 'total_allowance', 'total_ot', 'total_sl', 'total_vl', 'total_paid_sl', 'total_paid_vl']));
            $this->totals['total'] = $toAdd;
        }

        $data = [
            'work_days' => json_encode($this->work),
            // 'work_days' => $this->work,
            'absences' => $this->payroll_values['absences'],
            'late' => $this->payroll_values['late'],
            'ut' => $this->payroll_values['ut'],
            'ot' => json_encode($this->ot),
            'sl' => json_encode($this->payroll_values['sl']),
            'vl' => json_encode($this->payroll_values['vl']),
            'SH' => $this->payroll_values['SH'],
            'RH' => $this->payroll_values['RH'],
            'processed' => (strtotime($row->range_to) > strtotime($this->today)) ? false : true,
        ];
        // dump($data, $this->totals);
        $this->payroll->find($row->id)->update(array_merge($data, $this->totals));
        $this->setDefaults();
        // }
        // dd("");
    }

    private function getTotalWorkingHours($row)
    {
        $dtrs = $this->dtr->where('user_id', $row->user_id)->where('created_at', ">=", $row->range_from)->where("created_at", "<=", $row->range_to)->select('id', 'tag', 'regular')->whereNotNull('total')->get();
        foreach ($dtrs as $key => $dtr) {
            $tag_count = count($dtr->tag);
            $regular = ($dtr->regular == 8) ? 1 : ($dtr->regular / 24);
            if ($tag_count == 1) {
                if (!in_array($dtr->tag[0], ['SH', 'RH', 'paid SL', 'paid VL', 'VL', 'SL'])) {
                    $this->work['regular']['count'] = round($this->work['regular']['count'] += ($regular), 2);
                } elseif (in_array($dtr->tag[0], ['off'])) {
                    $this->work['restday']['count'] = round($this->work['restday']['count'] += ($regular), 2);
                }
            } elseif ($tag_count == 2) {
                if ($dtr->tag[0] == "off") {
                    $new_tag = array_shift($dtr->tag);
                    if (in_array('nd', $new_tag)) $this->work['ND & RD']['count'] = round($this->work['ND & RD']['count'] += ($regular), 2);
                    if (in_array('RH', $new_tag)) $this->work['RH & RD']['count'] = round($this->work['RH & RD']['count'] += ($regular), 2);
                    if (in_array('SH', $new_tag)) $this->work['SH & RD']['count'] = round($this->work['SH & RD']['count'] += ($regular), 2);
                } else {
                    $new_tag = array_shift($dtr->tag);
                    if (in_array('nd', $new_tag)) $this->work['ND']['count'] = round($this->work['ND']['count'] += ($regular), 2);
                    if (in_array('RH', $new_tag)) $this->work['RH']['count'] = round($this->work['RH']['count'] += ($regular), 2);
                    if (in_array('SH', $new_tag)) $this->work['SH']['count'] = round($this->work['SH']['count'] += ($regular), 2);
                }
            } elseif ($tag_count == 3) {
                if ($dtr->tag[0] == "off") {
                    $new_tag = array_shift($dtr->tag);
                    if (in_array('nd', $new_tag) && in_array('RH', $new_tag)) $this->work['ND & RH & RD']['count'] = round($this->work['ND & RH & RD']['count'] += ($regular), 2);
                    if (in_array('nd', $new_tag) && in_array('SH', $new_tag)) $this->work['ND & SH & RD']['count'] = round($this->work['ND & SH & RD']['count'] += ($regular));
                } else {
                    $new_tag = array_shift($dtr->tag);
                    if (in_array('nd', $new_tag) && in_array('RH', $new_tag)) $this->work['ND & RH']['count'] = round($this->work['ND']['count'] += ($regular), 2);
                    if (in_array('nd', $new_tag) && in_array('SH', $new_tag)) $this->work['ND & SH']['count'] = round($this->work['SH']['count'] += ($regular), 2);
                }
            }
        }
        // dd($this->work);
        $sub_total = [
            // regular
            'regular' => $this->work['regular']['count'] * $row->daily,
            'restday' => $this->work['restday']['count'] * ($row->daily * ($this->payroll_settings['payroll']['restday'] / 100)),
            'SH' => $this->work['SH']['count'] * ($row->daily * ($this->payroll_settings['payroll']['sh']['worked'] / 100)),
            'SH & RD' => $this->work['SH & RD']['count'] * ($row->daily * ($this->payroll_settings['payroll']['sh']['worked&rd'] / 100)),
            'RH' => $this->work['RH']['count'] * ($row->daily * ($this->payroll_settings['payroll']['rh']['regular']['worked'] / 100)),
            'RH & RD' => $this->work['RH & RD']['count'] * ($row->daily * ($this->payroll_settings['payroll']['rh']['regular']['worked&rd'] / 100)),
            // nd
            'ND' => $this->work['ND']['count'] * ($row->daily * ($this->payroll_settings['payroll']['nd']['regular'] / 100)),
            'ND & RD' => $this->work['ND & RD']['count'] * ($row->daily * ($this->payroll_settings['payroll']['nd']['restday'] / 100)),
            'ND & NW-SH' => $this->work['ND & NW-SH']['count'] * ($row->daily * ($this->payroll_settings['payroll']['nd']['sh']['unworked'] / 100)),
            'ND & SH' => $this->work['ND & SH']['count'] * ($row->daily * ($this->payroll_settings['payroll']['nd']['sh']['worked'] / 100)),
            'ND & SH & RD' => $this->work['ND & SH & RD']['count'] * ($row->daily * ($this->payroll_settings['payroll']['nd']['sh']['worked&rd'] / 100)),
            'ND & NW-RH' => $this->work['ND & NW-RH']['count'] * ($row->daily * ($this->payroll_settings['payroll']['nd']['rh']['unworked'] / 100)),
            'ND & RH' => $this->work['ND & RH']['count'] * ($row->daily * ($this->payroll_settings['payroll']['nd']['rh']['worked'] / 100)),
            'ND & RH & RD' => $this->work['ND & RH & RD']['count'] * ($row->daily * ($this->payroll_settings['payroll']['nd']['rh']['worked&rd'] / 100)),
        ];
        foreach ($sub_total as $key => $value) {
            $this->work[$key]['value'] = round($value, 2);
        }
        $this->totals['total_work_days'] = round(array_sum(Arr::flatten($sub_total)), 2);
        $this->payroll_values['work_days'] = $this->work;
    }

    private function getTotalOTHours($row)
    {
        $dtrs = $this->dtr->where('user_id', $row->user_id)->where('created_at', ">=", $row->range_from)->where("created_at", "<=", $row->range_to)->select('id', 'tag', 'regular', 'otIn', 'otOut')->where('tag', 'like', '%"ot"%')->whereNotNull('total')->get();
        foreach ($dtrs as $key => $dtr) {
            $tag_count = count($dtr->tag);
            if ($tag_count == 2) {
                if ($dtr->tag[0] == "off") {
                    $new_tag = array_shift($dtr->tag);
                    if (in_array('ot', $new_tag)) $this->ot['restday']['count'] = round($this->ot['restday']['count'] += ($dtr->regular / 24), 2);
                } else {
                    $new_tag = array_shift($dtr->tag);
                    if (in_array('ot', $new_tag)) $this->ot['regular']['count'] = round($this->ot['regular']['count'] += ($dtr->regular / 24));
                }
            } elseif ($tag_count == 3) {
                if ($dtr->tag[0] == "off") {
                    $new_tag = array_shift($dtr->tag);
                    if (in_array('nd', $new_tag)) $this->ot['ND & RD']['count'] = round($this->ot['ND & RD']['count'] += ($dtr->regular / 24), 2);
                    if (in_array('RH', $new_tag)) $this->ot['RH & RD']['count'] = round($this->ot['ND & RD']['count'] += ($dtr->regular / 24));
                    if (in_array('SH', $new_tag)) $this->ot['SH & RD']['count'] = round($this->ot['SH & RD']['count'] += ($dtr->regular / 24));
                } else {
                    $new_tag = array_shift($dtr->tag);
                    if (in_array('nd', $new_tag)) $this->ot['ND']['count'] = round($this->ot['ND']['count'] += ($dtr->regular / 24), 2);
                    if (in_array('RH', $new_tag)) $this->ot['RH']['count'] = round($this->ot['ND']['count'] += ($dtr->regular / 24));
                    if (in_array('SH', $new_tag)) $this->ot['SH']['count'] = round($this->ot['SH']['count'] += ($dtr->regular / 24));
                }
            } elseif ($tag_count == 4) {
                $new_tag = array_shift($dtr->tag);
                if ($dtr->tag[0] == "off") {
                    if (in_array('nd', $new_tag) && in_array('RH', $new_tag)) $this->ot['ND & RH & RD']['count'] = round($this->ot['RH & RD']['count'] += ($dtr->regular / 24));
                    if (in_array('nd', $new_tag) && in_array('SH', $new_tag)) $this->ot['ND & SH & RD']['count'] = round($this->ot['SH & SH & RD']['count'] += ($dtr->regular / 24));
                } else {
                    if (in_array('nd', $new_tag) && in_array('RH', $new_tag)) $this->ot['ND & RH & RD']['count'] = round($this->ot['RH & RD']['count'] += ($dtr->regular / 24));
                    if (in_array('nd', $new_tag) && in_array('SH', $new_tag)) $this->ot['ND & SH & RD']['count'] = round($this->ot['SH & SH & RD']['count'] += ($dtr->regular / 24));
                }
            }
        }
        $sub_total = [
            // regular
            'regular' => $this->ot['regular']['count'] * ($row->hourly * ($this->payroll_settings['payroll']['ot']['regular'] / 100)),
            'restday' => $this->ot['restday']['count'] * ($row->hourly * ($this->payroll_settings['payroll']['ot']['restday'] / 100)),
            'SH' => $this->ot['SH']['count'] * ($row->hourly * ($this->payroll_settings['payroll']['ot']['SH'] / 100)),
            'SH & RD' => $this->ot['SH & RD']['count'] * ($row->hourly * ($this->payroll_settings['payroll']['ot']['SH&rd'] / 100)),
            'RH' => $this->ot['RH']['count'] * ($row->hourly * ($this->payroll_settings['payroll']['ot']['RH'] / 100)),
            'RH & RD' => $this->ot['RH & RD']['count'] * ($row->hourly * ($this->payroll_settings['payroll']['ot']['RH&rd'] / 100)),
            // nd
            'ND' => $this->ot['ND']['count'] * ($row->hourly * ($this->payroll_settings['payroll']['ot']['nd']['regular'] / 100)),
            'ND & RD' => $this->ot['ND & RD']['count'] * ($row->hourly * ($this->payroll_settings['payroll']['ot']['nd']['restday'] / 100)),
            'ND & SH' => $this->ot['ND & SH']['count'] * ($row->hourly * ($this->payroll_settings['payroll']['ot']['nd']['SH'] / 100)),
            'ND & SH & RD' => $this->ot['ND & SH & RD']['count'] * ($row->hourly * ($this->payroll_settings['payroll']['ot']['nd']['SH&rd'] / 100)),
            'ND & RH' => $this->ot['ND & RH']['count'] * ($row->hourly * ($this->payroll_settings['payroll']['ot']['nd']['RH'] / 100)),
            'ND & RH & RD' => $this->ot['ND & RH & RD']['count'] * ($row->hourly * ($this->payroll_settings['payroll']['ot']['nd']['RH&rd'] / 100)),
        ];
        foreach ($sub_total as $key => $value) {
            $this->ot[$key]['value'] = round($value, 2);
        }
        $this->totals['total_ot'] = round(array_sum(Arr::flatten($sub_total)), 2);
        $this->payroll_values['ot'] = $this->ot;
    }

    private function getAbsences($row)
    {
        $this->payroll_values['absences'] = $this->dtr->where('user_id', $row->user_id)->where('created_at', ">=", $row->range_from)->where("created_at", "<=", $row->range_to)->where('tag', 'like', '%,"absent"]')->get()->count();

        $this->totals['total_absences'] = round($this->payroll_values['absences'] * $row->daily);
    }

    private function getAllowances($row)
    {
        $allowance = $this->dtr->where('user_id', $row->user_id)->where('created_at', ">=", $row->range_from)->where("created_at", "<=", $row->range_to)->whereNotNull('total')->get()->count();

        $this->totals['total_allowance'] = round($allowance * $row->allowance);
    }

    private function getLate($row)
    {
        $this->payroll_values['late'] = $this->dtr->where('user_id', $row->user_id)->where('created_at', ">=", $row->range_from)->where("created_at", "<=", $row->range_to)->select(DB::raw("SUM(late) as late_total"))->whereNotNull('late')->first()->late_total;

        $this->totals['total_late'] = round($this->payroll_values['late'] * $row->hourly);
    }

    private function getUndertime($row)
    {
        $this->payroll_values['ut'] = $this->dtr->where('user_id', $row->user_id)->where('created_at', ">=", $row->range_from)->where("created_at", "<=", $row->range_to)->select(DB::raw("SUM(undertime) as ut_total"))->whereNotNull('undertime')->first()->ut_total;

        $this->totals['total_ut'] = round($this->payroll_values['ut'] * $row->hourly);
    }

    private function getLeaves($row)
    {
        $this->payroll_values['sl'] = [
            'paid' => $this->getPaidSLeaves($row),
            'unpaid' => $this->getUnpaidSLeaves($row),
        ];
        $this->payroll_values['vl'] = [
            'paid' => $this->getPaidVLeaves($row),
            'unpaid' => $this->getUnpaidVLeaves($row),
        ];
        $this->totals['total_sl'] = round($this->payroll_values['sl']['unpaid'] * $row->daily, 2);
        $this->totals['total_paid_sl'] = round($this->payroll_values['sl']['paid'] * $row->daily, 2);
        $this->totals['total_vl'] = round($this->payroll_values['vl']['unpaid'] * $row->daily, 2);
        $this->totals['total_paid_vl'] = round($this->payroll_values['vl']['paid'] * $row->daily, 2);
    }

    private function getSH($row)
    {
        $dtrs = $this->dtr->where('user_id', $row->user_id)->where('created_at', ">=", $row->range_from)->where("created_at", "<=", $row->range_to)->select('id', 'tag')->where('tag', '["SH"]')->whereNull('total')->get();
        $sh_unworked = $dtrs->count();
        $sh_worked = $this->dtr->where('user_id', $row->user_id)->where('created_at', ">=", $row->range_from)->where("created_at", "<=", $row->range_to)->select('id', 'tag')->where('tag', 'like', '%"SH"]')->whereNotNull('total')->get()->count();

        foreach ($dtrs as $key => $dtr) {
            $new_tag = json_decode($dtr->tag);
            if (in_array('nd', $new_tag)) {
                $this->work['ND & NW-SH']['count'] += 1;
                $this->work['ND & NW-SH']['value'] += ($row->daily * ($this->payroll_settings['payroll']['nd']['sh']['unworked'] / 100));
            } else {
                $this->work['NW-SH']['count'] += 1;
                $this->work['NW-SH']['value'] += ($row->daily * ($this->payroll_settings['payroll']['sh']['unworked'] / 100));
            }
        }
        $this->totals['total_work_days'] += $this->work['NW-SH']['value'] + $this->work['ND & NW-SH']['value'];
        $this->payroll_values['SH'] = $sh_unworked + $sh_worked;
    }

    private function getRH($row)
    {
        $dtrs = $this->dtr->where('user_id', $row->user_id)->where('created_at', ">=", $row->range_from)->where("created_at", "<=", $row->range_to)->where('tag', '["RH"]')->whereNull('total')->get();
        $rh_unworked = $dtrs->count();
        $rh_worked = $this->dtr->where('user_id', $row->user_id)->where('created_at', ">=", $row->range_from)->where("created_at", "<=", $row->range_to)->where('tag', 'like', '%"RH"]')->whereNotNull('total')->get()->count();

        foreach ($dtrs as $key => $dtr) {
            $new_tag = json_decode($dtr->tag);
            if (in_array('nd', $new_tag)) {
                $this->work['ND & NW-RH']['count'] = $rh_unworked;
                $this->work['ND & NW-RH']['value'] = $rh_unworked * ($row->daily * ($this->payroll_settings['payroll']['rh']['regular']['unworked'] / 100));
            } else {
                $this->work['NW-RH']['count'] = $rh_unworked;
                $this->work['NW-RH']['value'] = $rh_unworked * ($row->daily * ($this->payroll_settings['payroll']['rh']['regular']['unworked'] / 100));
            }
        }
        $this->totals['total_work_days'] += $this->work['NW-RH']['value'] + $this->work['ND & NW-RH']['value'];
        $this->payroll_values['RH'] = $rh_unworked + $rh_worked;
    }

    private function getPaidSLeaves($row)
    {
        return $this->dtr->where('user_id', $row->user_id)->where('created_at', ">=", $row->range_from)->where("created_at", "<=", $row->range_to)->where('tag', '["paid SL"]')->get()->count();
    }

    private function getUnpaidSLeaves($row)
    {
        return $this->dtr->where('user_id', $row->user_id)->where('created_at', ">=", $row->range_from)->where("created_at", "<=", $row->range_to)->where('tag', '["SL"]')->get()->count();
    }

    private function getPaidVLeaves($row)
    {
        return $this->dtr->where('user_id', $row->user_id)->where('created_at', ">=", $row->range_from)->where("created_at", "<=", $row->range_to)->where('tag', '["paid VL"]')->get()->count();;
    }

    private function getUnpaidVLeaves($row)
    {
        return $this->dtr->where('user_id', $row->user_id)->where('created_at', ">=", $row->range_from)->where("created_at", "<=", $row->range_to)->where('tag', '["VL"]')->get()->count();
    }

    private function setDefaults()
    {
        $this->ot = [
            "regular" => ['count' => 0],
            "restday" => ['count' => 0],
            "NW-SH" => ['count' => 0],
            "SH" => ['count' => 0],
            "SH & RD" => ['count' => 0],
            "NW-RH" => ['count' => 0],
            "RH" => ['count' => 0],
            "RH & RD" => ['count' => 0],
            "ND" => ['count' => 0],
            "ND & RD" => ['count' => 0],
            "ND & NW-SH" => ['count' => 0],
            "ND & SH" => ['count' => 0],
            "ND & SH & RD" => ['count' => 0],
            "ND & NW-RH" => ['count' => 0],
            "ND & RH" => ['count' => 0],
            "ND & RH & RD" => ['count' => 0],
        ];
        $this->work = [
            "regular" => ['count' => 0],
            "restday" => ['count' => 0],
            "NW-SH" => ['count' => 0, 'value' => 0],
            "SH" => ['count' => 0],
            "SH & RD" => ['count' => 0],
            "NW-RH" => ['count' => 0, 'value' => 0],
            "RH" => ['count' => 0],
            "RH & RD" => ['count' => 0],
            "ND" => ['count' => 0],
            "ND & RD" => ['count' => 0],
            "ND & NW-SH" => ['count' => 0, 'value' => 0],
            "ND & SH" => ['count' => 0],
            "ND & SH & RD" => ['count' => 0],
            "ND & NW-RH" => ['count' => 0, 'value' => 0],
            "ND & RH" => ['count' => 0],
            "ND & RH & RD" => ['count' => 0],
        ];
        $this->payroll_values = [
            'work_days' => null,
            'allowance' => null,
            'absences' => null,
            'late' => null,
            'ut' => null,
            'ot' => null,
            'sl' => [
                'paid' => 0,
                'unpaid' => 0,
            ],
            'vl' => [
                'paid' => 0,
                'unpaid' => 0,
            ],
            'SH' => null,
            'RH' => null,
        ];
        $this->totals = [
            'total_work_days' => 0,
            'total_allowance' => 0,
            'total_absences' => 0,
            'total_late' => 0,
            'total_ut' => 0,
            'total_ot' => 0,
            'total_sl' => 0,
            'total_vl' => 0,
            'total_paid_sl' => 0,
            'total_paid_vl' => 0,
            'total' => 0,
        ];
    }

}
