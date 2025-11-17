<?php

class ReportCardController
{
    public function index($request)
    {
        return view('report-cards/index', ['title' => 'Report Cards']);
    }

    public function generate($request)
    {
        $classId = $request->post('class_id');
        $examId = $request->post('exam_id');
        
        flash('success', 'Report cards generated successfully');
        return redirect('/report-cards');
    }

    public function download($request, $studentId, $examId)
    {
        flash('success', 'Report card download initiated');
        return back();
    }

    public function print($request, $studentId, $examId)
    {
        return view('report-cards/print', [
            'title' => 'Print Report Card',
            'studentId' => $studentId,
            'examId' => $examId
        ]);
    }
}
