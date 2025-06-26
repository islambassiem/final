<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Tables\Bank;
use Carbon\Carbon;

class LetterController extends Controller
{
  public function index()
  {
    $users = User::where('active', 1)->get();
    return view('admin.letters.index', [
      'letters' => Letter::with('user')->orderByDesc('id')->get(),
      'users' => $users
    ]);
  }

  public function letter(Request $request)
  {
    $validated = $request->validate([
      'user_id' => 'required',
      'type' => 'nullable',
      'addressee' => 'nullable'
    ], [
      'user_id' => __('letters.emplooyee_required')
    ]);

    $user_id = $validated['user_id'];
    $type = $validated['type'] ?? 'letter';
    $addressee = $validated['addressee'] ?? '';
    $user = User::find($user_id);

    if ($user->sponsorship_id === 3 && in_array($type, ['letter', 'loan'])) {
      return redirect()->back()->with(
        ['error' => __('letters.not_sponsered')]
      );
    }

    $root = 'app/private/templates/';
    $branch = $user->sponsorship_id === 2 ? "shining" : "inaya";

    $values = [
      'name'        => $user->getFullArabicNameAttribute,
      'department'  => $user->section->section_ar,
      'joining'     => $user->joining_date,
      'id'          => $user->iqama($user_id)->document_id,
      'nationality' => $user->nationality->country_ar,
      'position'    => $user->position->position_ar,
      'empid'       => $user->empid,
      'basic'       => $user->basic($user_id),
      'housing'     => $user->housing($user_id),
      'trans'       => $user->transportation($user_id),
      'package'     => $user->latestSalary($user_id),
      'package_l'   => $this->NoToTxt($this->float($user->latestSalary($user_id))),
      'addressee'   => $addressee
    ];

    switch ($type) {
      case 'letter':
        $file = 'letter_' . Str::lower($user->gender->gender_en);
        $template =  storage_path($root . $branch . '/' . $file . '.docx');
        break;
      case 'experience':
        $file = 'experience_' . Str::lower($user->gender->gender_en);
        $template =  storage_path($root . $branch . '/' . $file . '.docx');
        $values['resignation'] = $user->resignation_date ?? date('Y-m-d');
        $values['name_en'] = $user->getFullEnglishNameAttribute;
        $values['nationality_en'] = $user->nationality->country_en;
        $values['position_en'] = $user->position->position_en;
        break;
      case 'loan':
        $template =  storage_path($root . 'loan.docx');
        $values['bank'] = Bank::find($user->bank($user_id)->bank_code)->bank_name_ar;
        $values['iban'] = $user->bank($user_id)->iban;
        $values['benefits'] = number_format($this->benefits($user_id), 0);
        $values['benefits_l'] = $this->NoToTxt($this->float($this->benefits($user_id)));
        break;
      case 'contract':
        $template =  storage_path($root . 'contract.docx');
        $values['name_en'] = $user->getFullEnglishNameAttribute;
        $values['nationality_en'] = $user->nationality->country_en;
        $values['passport'] = $user?->passport($user_id)?->document_id;
        $values['mobile'] = $user->mobile($user_id);
        $values['position_en'] = $user->position->position_en;
        $values['food'] = $user->food($user_id);
        $values['vacation'] = $user->vacation_class;
        break;
      case 'poea':
        $file = 'poea_' . Str::lower($user->gender->gender_en);
        $template =  storage_path($root . $branch . '/' . $file . '.docx');
        $values['position_en'] = $user->position->position_en;
        $values['name_en'] = $user->getFullEnglishNameAttribute;
        break;
    }

    $templateProcessor = new TemplateProcessor($template);

    $templateProcessor->setValues($values);
    $tempFile = tempnam(sys_get_temp_dir(), 'word');
    $templateProcessor->saveAs($tempFile);
    ob_end_clean();
    return response()->download($tempFile, 'document.docx')->deleteFileAfterSend(true);
  }

  private function benefits($user_id)
  {
    $user = User::find($user_id);
    $salary = floatval(str_replace(',', '', $user->latestSalary($user_id)));
    $years = $this->years($user_id);

    if ($years < 2) {
      return 0;
    } else if ($years <= 5) {
      return $this->lessThanFiveYears($salary, $years);
    } else if ($years > 5) {
      return $this->lessThanFiveYears($salary, $years) + $this->moreThanFiveYears($salary, $years);
    }
  }

  private function lessThanFiveYears($salary, $years)
  {
    if ($years <= 5) {
      return round($salary * $years / 2, 0);
    }
    return  round($salary * 5 / 2, 0);
  }

  private function moreThanFiveYears($salary, $years)
  {
    return round($salary * ($years - 5), 0);
  }

  private function years($user_id)
  {
    $joining_date = Carbon::parse(User::find($user_id)->joining_date);
    return Carbon::today()->floatDiffInRealDays($joining_date) / 365;
  }

  private function NoToTxt($TheNo, $MyCur = "ريال", $MySubCur = "هللة") {
    $MyArry1 = ["", "مائة", "مائتان", "ثلاثمائة", "أربعمائة", "خمسمائة", "ستمائة", "سبعمائة", "ثمانمائة", "تسعمائة"];
    $MyArry2 = ["", " عشر", "عشرون", "ثلاثون", "أربعون", "خمسون", "ستون", "سبعون", "ثمانون", "تسعون"];
    $MyArry3 = ["", "واحد", "اثنان", "ثلاثة", "أربعة", "خمسة", "ستة", "سبعة", "ثمانية", "تسعة"];

    if ($TheNo > 999999999999.99) return "";

    $TheNo = abs($TheNo);

    if ($TheNo == 0) return "صفر";

    $MyAnd = " و";
    $GetNo = str_pad(number_format($TheNo, 2, '.', ''), 15, '0', STR_PAD_LEFT);

    $Mybillion = $MyMillion = $MyThou = $MyHun = $MyFraction = "";

    for ($I = 0; $I < 15; $I += 3) {
        $Myno = ($I < 12) ? substr($GetNo, $I, 3) : "0" . substr($GetNo, $I + 1, 2);

        if (intval($Myno) > 0) {
            $My100 = $MyArry1[intval($Myno[0])];
            $My1 = $MyArry3[intval($Myno[2])];
            $My10 = $MyArry2[intval($Myno[1])];

            if (substr($Myno, 1, 2) == "11") $My10 = "إحدى عشر";
            if (substr($Myno, 1, 2) == "12") $My10 = "إثنى عشر";
            if (substr($Myno, 1, 2) == "10") $My10 = "عشرة";

            if ($Myno[0] > 0 && substr($Myno, 1, 2) > 0) $My100 .= $MyAnd;
            if ($Myno[2] > 0 && $Myno[1] > 1) $My1 .= $MyAnd;

            $GetTxt = $My100 . $My1 . $My10;

            if ($I == 0) {
                $Mybillion = ($Myno > 10) ? "$GetTxt مليار" : "$GetTxt مليارات";
                if ($Myno == 1) $Mybillion = "مليار";
                if ($Myno == 2) $Mybillion = "ملياران";
            }
            if ($I == 3) {
                $MyMillion = ($Myno > 10) ? "$GetTxt مليون" : "$GetTxt ملايين";
                if ($Myno == 1) $MyMillion = "مليون";
                if ($Myno == 2) $MyMillion = "مليونان";
            }
            if ($I == 6) {
                $MyThou = ($Myno > 10) ? "$GetTxt ألف" : "$GetTxt آلاف";
                if ($Myno == 1) $MyThou = "ألف";
                if ($Myno == 2) $MyThou = "ألفان";
            }
            if ($I == 9) $MyHun = $GetTxt;
            if ($I == 12) $MyFraction = $GetTxt;
        }
    }

    if ($Mybillion && ($MyMillion || $MyThou || $MyHun)) $Mybillion .= $MyAnd;
    if ($MyMillion && ($MyThou || $MyHun)) $MyMillion .= $MyAnd;
    if ($MyThou && $MyHun) $MyThou .= $MyAnd;

    if ($MyFraction) {
        if ($Mybillion || $MyMillion || $MyThou || $MyHun) {
            return "$Mybillion$MyMillion$MyThou$MyHun $MyCur$MyAnd$MyFraction $MySubCur";
        } else {
            return "$MyFraction $MySubCur";
        }
    }

    return "$Mybillion$MyMillion$MyThou$MyHun $MyCur";
  }

  private function float($numberText)
  {
    $float =  floatval(str_replace(",", "", $numberText));
    return round($float, 0);
  }

}
