<?php

namespace App\Http\Controllers;

use App\Report;

class controllerWord extends Controller
{
    public function createReport($id)
    {
        $report = Report::find($id);
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $sectionStyle = array(
            'borderTopSize' => 15,
            'borderLeftSize' => 15,
            'borderRightSize' => 15,
            'borderBottomSize' => 15,
            'rtl' => 'true',
        );

        $newSection = $phpWord->addSection($sectionStyle);

        $header = $newSection->addHeader();
        $header->addImage('assets/images/logo.png');

        $newSection->addText('تقرير يومى', array('rtl' => true, 'size' => 25, 'bold' => true, 'underline' => 'single'), array('align' => 'center'));

        $newSection->addListItem('التاريخ  : '.$report->report_date, 0, array('rtl' => true, 'size' => 15, 'bold' => true), array('align' => 'right'), array('bidi' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START));
        $newSection->addListItem('المحافظة : '.$report->city->city_name, 0, array('rtl' => true, 'size' => 15, 'bold' => true), array('align' => 'right'), array('bidi' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START));
        $newSection->addListItem('المدرسة : '.$report->school->school_name, 0, array('rtl' => true, 'size' => 15, 'bold' => true), array('align' => 'right'), array('bidi' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START));
        $newSection->addListItem('عدد الطلاب الحاضرين : '.$report->student_number, 0, array('rtl' => true, 'size' => 15, 'bold' => true), array('align' => 'right'), array('bidi' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START));
        $newSection->addListItem(' المسئول من شركة ويل سبرنج : '.$report->admin, 0, array('rtl' => true, 'size' => 15, 'bold' => true), array('align' => 'right'), array('bidi' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START));
        $newSection->addListItem(' هدف اليوم : '.$report->goal->goal_name, 0, array('rtl' => true, 'size' => 15, 'bold' => true), array('align' => 'right'), array('bidi' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START));

        $newSection->addListItem('قصص نجاح خلال اليوم : ', 0, array('rtl' => true, 'size' => 14, 'bold' => true), array('align' => 'right'), array('bidi' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START));
        if ($report->success_story == '') {
            $newSection->addText('..........................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................', array('rtl' => true, 'size' => 18, 'bold' => true), array('rtl' => 'true'), array('align' => 'right'));
        } else {
            $newSection->addText($report->success_story, array('rtl' => true, 'size' => '14'), array('bidi' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH, 'indent' => 1));
        }

        $newSection->addListItem(' التحديات التى واجهتنا : ', 0, array('rtl' => true, 'size' => 14, 'bold' => true), array('align' => 'right'), array('bidi' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START));
        if ($report->challenges == '') {
            $newSection->addText('..........................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................', array('rtl' => true, 'size' => 18, 'bold' => true), array('rtl' => 'true'), array('align' => 'right'));
        } else {
            $newSection->addText($report->challenges, array('rtl' => true, 'size' => '14'), array('bidi' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH, 'indent' => 1));
        }

        $newSection->addText('- تقرير الملاحظات', array('rtl' => true, 'size' => '14'), array('bidi' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH, 'indent' => 1));

        $fancyTableStyleName = 'تقرير الملاحظات';
        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '00000', 'cellMargin' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT, 'cellSpacing' => 1, 'rightFromText' => true, 'width' => '100%');
        $fancyTableFirstRowStyle = array('borderBottomSize' => 18, 'borderBottomColor' => '0000', 'bgColor' => '000');
        $fancyTableCellStyle = array('valign' => 'center');
        $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $fancyTableFontStyle = array('bold' => true);
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
        $table = $newSection->addTable($fancyTableStyleName);

        $table->addRow(80);
        $table->addCell(6000)->addText(htmlspecialchars('ملاحظات'), array('rtl' => true, 'size' => 14, 'bold' => true), array('align' => 'center'));
        $table->addCell(2000)->addText(htmlspecialchars('النسبة'), array('rtl' => true, 'size' => 14, 'bold' => true), array('align' => 'center'));
        $table->addCell(2000)->addText('اسم الفريق', array('rtl' => true, 'size' => 14, 'bold' => true), array('align' => 'center'));

        foreach ($report->report_note as $rnum => $rvalue) {
            $table->addRow();

            $table->addCell(2000)->addText(htmlspecialchars($rvalue->notes), array('rtl' => true, 'size' => 12), array('align' => 'center'));
            $table->addCell(2000)->addText(htmlspecialchars($rvalue->rate), array('rtl' => true, 'size' => 12), array('align' => 'center'));
            $table->addCell(2000)->addText(htmlspecialchars($rvalue->team_name), array('rtl' => true, 'size' => 12), array('align' => 'center'));
        }

        if (count($report->report_note) < 22) {
            $newSection->addTextBreak(5);
        }

        $newSection->addText('- الانشطة التى تم تنفيذها خلال اليوم', array('rtl' => true, 'size' => '14'), array('bidi' => true));

        $fancyTableStyleName = 'الانشطة';
        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '00000', 'cellMargin' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT, 'cellSpacing' => 1, 'rightFromText' => true, 'width' => '100%');
        $fancyTableFirstRowStyle = array('borderBottomSize' => 18, 'borderBottomColor' => '0000', 'bgColor' => '000');
        $fancyTableCellStyle = array('valign' => 'center');
        $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $fancyTableFontStyle = array('bold' => true);
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
        $table_two = $newSection->addTable($fancyTableStyleName);

        $table_two->addRow(80);
        $table_two->addCell(4000)->addText(htmlspecialchars('صورة اللعبة'), array('rtl' => true, 'size' => 14, 'bold' => true), array('align' => 'center'));
        $table_two->addCell(4000)->addText(htmlspecialchars('الادوات'), array('rtl' => true, 'size' => 14, 'bold' => true), array('align' => 'center'));
        $table_two->addCell(4000)->addText(htmlspecialchars('شرح اللعبة'), array('rtl' => true, 'size' => 14, 'bold' => true), array('align' => 'center'));
        $table_two->addCell(1000)->addText('اسم اللعبة', array('rtl' => true, 'size' => 14, 'bold' => true), array('align' => 'center'));

        foreach ($report->activity as $rnum => $rvalue) {
            $table_two->addRow();
            if ($rvalue->game_img != '') {
                $table_two->addCell(1000)->addImage('upload/activity/'.$rvalue->game_img, array('width' => 80, 'height' => 80, 'align' => 'left'));
                $table_two->addCell(1000)->addText(htmlspecialchars($rvalue->game_tools), array('rtl' => true, 'size' => 12), array('align' => 'center'));
                $table_two->addCell(4000)->addText(htmlspecialchars($rvalue->explain_game), array('rtl' => true, 'size' => 12), array('align' => 'center'));
                $table_two->addCell(4000)->addText(htmlspecialchars($rvalue->game_name), array('rtl' => true, 'size' => 12), array('align' => 'center'));
            } else {
                $table_two->addCell(1000)->addText('', array('rtl' => true, 'size' => 12), array('align' => 'center'));
                $table_two->addCell(1000)->addText(htmlspecialchars($rvalue->game_tools), array('rtl' => true, 'size' => 12), array('align' => 'center'));
                $table_two->addCell(4000)->addText(htmlspecialchars($rvalue->explain_game), array('rtl' => true, 'size' => 12), array('align' => 'center'));
                $table_two->addCell(4000)->addText(htmlspecialchars($rvalue->game_name), array('rtl' => true, 'size' => 12), array('align' => 'center'));
            }
        }

        $name_file = $report->report_date.'.docx';
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path($name_file));

        $name_file = $report->report_date.'.docx';

        return response()->download(storage_path($name_file));
    }
}
