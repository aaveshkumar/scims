<?php

class LeaveController
{
    private $leaveModel;

    public function __construct()
    {
        $this->leaveModel = new Leave();
    }

    public function index($request)
    {
        $status = $request->get('status', '');
        
        if ($status) {
            $leaves = $this->leaveModel->getLeavesByStatus($status);
        } else {
            $leaves = $this->leaveModel->all();
        }

        return view('leave.index', [
            'leaves' => $leaves,
            'statuses' => ['pending', 'approved', 'rejected'],
            'currentStatus' => $status
        ]);
    }

    public function create($request)
    {
        return view('leave.create', ['title' => 'Request Leave']);
    }

    public function store($request)
    {
        $data = [
            'user_id' => auth()['id'],
            'leave_type' => $request->post('leave_type'),
            'start_date' => $request->post('start_date'),
            'end_date' => $request->post('end_date'),
            'reason' => $request->post('reason'),
            'status' => 'pending'
        ];

        if ($this->leaveModel->create($data)) {
            flash('success', 'Leave request submitted successfully');
            return redirect('/leave');
        }

        flash('error', 'Failed to submit leave request');
        return back();
    }

    public function show($request, $id)
    {
        $leave = $this->leaveModel->find($id);
        if (!$leave) {
            flash('error', 'Leave request not found');
            return redirect('/leave');
        }
        return view('leave.show', ['leave' => $leave, 'title' => 'View Leave']);
    }

    public function edit($request, $id)
    {
        $leave = $this->leaveModel->find($id);
        if (!$leave) {
            flash('error', 'Leave request not found');
            return redirect('/leave');
        }
        return view('leave.edit', ['leave' => $leave, 'title' => 'Edit Leave']);
    }

    public function update($request, $id)
    {
        $this->leaveModel->update($id, [
            'leave_type' => $request->post('leave_type'),
            'start_date' => $request->post('start_date'),
            'end_date' => $request->post('end_date'),
            'reason' => $request->post('reason')
        ]);

        flash('success', 'Leave request updated successfully');
        return redirect('/leave');
    }

    public function destroy($request, $id)
    {
        $this->leaveModel->delete($id);
        flash('success', 'Leave request deleted successfully');
        return redirect('/leave');
    }
}