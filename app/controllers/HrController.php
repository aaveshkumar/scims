<?php

class HrController
{
    public function events($request)
    {
        $events = db()->fetchAll("SELECT he.*, CONCAT(u.first_name, ' ', u.last_name) as creator_name FROM hr_events he LEFT JOIN users u ON he.created_by = u.id ORDER BY he.event_date DESC");
        
        return view('hr/events', [
            'title' => 'HR Events',
            'events' => $events
        ]);
    }

    public function createEvent($request)
    {
        if ($request->method() === 'POST') {
            $authUser = auth();
            $sql = "INSERT INTO hr_events (title, description, event_date, event_type, location, created_by, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
            
            db()->execute($sql, [
                $request->post('title'),
                $request->post('description'),
                $request->post('event_date'),
                $request->post('event_type') ?? 'event',
                $request->post('location'),
                isset($authUser['id']) ? $authUser['id'] : 1
            ]);
            
            flash('success', 'HR Event created successfully');
            return redirect('/hr/events');
        }
        
        return view('hr/create-event', ['title' => 'Create - HR Event']);
    }

    public function showEvent($request, $id)
    {
        $event = db()->fetchOne("SELECT he.*, CONCAT(u.first_name, ' ', u.last_name) as creator_name FROM hr_events he LEFT JOIN users u ON he.created_by = u.id WHERE he.id = ?", [$id]);
        
        if (!$event) {
            flash('error', 'HR Event not found');
            return redirect('/hr/events');
        }
        
        return view('hr/show-event', [
            'title' => 'View - HR Event',
            'event' => $event
        ]);
    }

    public function editEvent($request, $id)
    {
        $event = db()->fetchOne("SELECT * FROM hr_events WHERE id = ?", [$id]);
        
        if (!$event) {
            flash('error', 'HR Event not found');
            return redirect('/hr/events');
        }
        
        if ($request->method() === 'POST') {
            $sql = "UPDATE hr_events SET title = ?, description = ?, event_date = ?, event_type = ?, location = ?, updated_at = NOW() WHERE id = ?";
            
            db()->execute($sql, [
                $request->post('title'),
                $request->post('description'),
                $request->post('event_date'),
                $request->post('event_type'),
                $request->post('location'),
                $id
            ]);
            
            flash('success', 'HR Event updated successfully');
            return redirect('/hr/events');
        }
        
        return view('hr/edit-event', [
            'title' => 'Edit - HR Event',
            'event' => $event
        ]);
    }

    public function deleteEvent($request, $id)
    {
        db()->execute("DELETE FROM hr_events WHERE id = ?", [$id]);
        flash('success', 'HR Event deleted successfully');
        return redirect('/hr/events');
    }

    public function recruitment($request)
    {
        $positions = db()->fetchAll("SELECT rp.*, CONCAT(u.first_name, ' ', u.last_name) as created_by_name FROM recruitment_positions rp LEFT JOIN users u ON rp.created_by = u.id ORDER BY rp.created_at DESC");
        
        return view('hr/recruitment', [
            'title' => 'Recruitment Positions',
            'positions' => $positions
        ]);
    }

    public function createPosition($request)
    {
        if ($request->method() === 'POST') {
            $authUser = auth();
            $sql = "INSERT INTO recruitment_positions (title, department, description, requirements, number_of_positions, status, created_by, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
            
            db()->execute($sql, [
                $request->post('title'),
                $request->post('department'),
                $request->post('description'),
                $request->post('requirements'),
                $request->post('number_of_positions') ?? 1,
                $request->post('status') ?? 'open',
                isset($authUser['id']) ? $authUser['id'] : 1
            ]);
            
            flash('success', 'Position created successfully');
            return redirect('/hr/recruitment');
        }
        
        return view('hr/create-position', ['title' => 'Create - Recruitment Position']);
    }

    public function showPosition($request, $id)
    {
        $position = db()->fetchOne("SELECT rp.*, CONCAT(u.first_name, ' ', u.last_name) as created_by_name FROM recruitment_positions rp LEFT JOIN users u ON rp.created_by = u.id WHERE rp.id = ?", [$id]);
        
        if (!$position) {
            flash('error', 'Position not found');
            return redirect('/hr/recruitment');
        }
        
        return view('hr/show-position', [
            'title' => 'View - Recruitment Position',
            'position' => $position
        ]);
    }

    public function editPosition($request, $id)
    {
        $position = db()->fetchOne("SELECT * FROM recruitment_positions WHERE id = ?", [$id]);
        
        if (!$position) {
            flash('error', 'Position not found');
            return redirect('/hr/recruitment');
        }
        
        if ($request->method() === 'POST') {
            $sql = "UPDATE recruitment_positions SET title = ?, department = ?, description = ?, requirements = ?, number_of_positions = ?, status = ?, updated_at = NOW() WHERE id = ?";
            
            db()->execute($sql, [
                $request->post('title'),
                $request->post('department'),
                $request->post('description'),
                $request->post('requirements'),
                $request->post('number_of_positions'),
                $request->post('status'),
                $id
            ]);
            
            flash('success', 'Position updated successfully');
            return redirect('/hr/recruitment');
        }
        
        return view('hr/edit-position', [
            'title' => 'Edit - Recruitment Position',
            'position' => $position
        ]);
    }

    public function deletePosition($request, $id)
    {
        db()->execute("DELETE FROM recruitment_positions WHERE id = ?", [$id]);
        flash('success', 'Position deleted successfully');
        return redirect('/hr/recruitment');
    }

    public function payroll($request)
    {
        $payrolls = db()->fetchAll("SELECT p.*, CONCAT(s.first_name, ' ', s.last_name) as staff_name FROM payroll p LEFT JOIN staff s ON p.staff_id = s.id ORDER BY p.payment_date DESC NULLS LAST");
        
        return view('hr/payroll', [
            'title' => 'Payroll Management',
            'payrolls' => $payrolls
        ]);
    }

    public function createPayroll($request)
    {
        if ($request->method() === 'POST') {
            $authUser = auth();
            $basic_salary = $request->post('basic_salary') ?? 0;
            $allowances = $request->post('allowances') ?? 0;
            $deductions = $request->post('deductions') ?? 0;
            $gross_salary = $basic_salary + $allowances;
            $net_salary = $gross_salary - $deductions;
            
            $sql = "INSERT INTO payroll (payroll_number, staff_id, month, year, basic_salary, allowances, deductions, gross_salary, net_salary, payment_date, payment_method, status, created_by) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            db()->execute($sql, [
                'PAYROLL-' . time(),
                $request->post('staff_id'),
                $request->post('month'),
                $request->post('year'),
                $basic_salary,
                $allowances,
                $deductions,
                $gross_salary,
                $net_salary,
                $request->post('payment_date'),
                $request->post('payment_method'),
                $request->post('status') ?? 'pending',
                isset($authUser['id']) ? $authUser['id'] : 1
            ]);
            
            flash('success', 'Payroll created successfully');
            return redirect('/hr/payroll');
        }
        
        $staff = db()->fetchAll("SELECT id, CONCAT(first_name, ' ', last_name) as name FROM staff ORDER BY first_name");
        return view('hr/create-payroll', [
            'title' => 'Create - Payroll',
            'staff' => $staff
        ]);
    }

    public function showPayroll($request, $id)
    {
        $payroll = db()->fetchOne("SELECT p.*, CONCAT(s.first_name, ' ', s.last_name) as staff_name FROM payroll p LEFT JOIN staff s ON p.staff_id = s.id WHERE p.id = ?", [$id]);
        
        if (!$payroll) {
            flash('error', 'Payroll record not found');
            return redirect('/hr/payroll');
        }
        
        return view('hr/show-payroll', [
            'title' => 'View - Payroll',
            'payroll' => $payroll
        ]);
    }

    public function editPayroll($request, $id)
    {
        $payroll = db()->fetchOne("SELECT * FROM payroll WHERE id = ?", [$id]);
        
        if (!$payroll) {
            flash('error', 'Payroll record not found');
            return redirect('/hr/payroll');
        }
        
        if ($request->method() === 'POST') {
            $basic_salary = $request->post('basic_salary') ?? 0;
            $allowances = $request->post('allowances') ?? 0;
            $deductions = $request->post('deductions') ?? 0;
            $gross_salary = $basic_salary + $allowances;
            $net_salary = $gross_salary - $deductions;
            
            $sql = "UPDATE payroll SET staff_id = ?, month = ?, year = ?, basic_salary = ?, allowances = ?, deductions = ?, gross_salary = ?, net_salary = ?, payment_date = ?, payment_method = ?, status = ?, updated_at = NOW() WHERE id = ?";
            
            db()->execute($sql, [
                $request->post('staff_id'),
                $request->post('month'),
                $request->post('year'),
                $basic_salary,
                $allowances,
                $deductions,
                $gross_salary,
                $net_salary,
                $request->post('payment_date'),
                $request->post('payment_method'),
                $request->post('status'),
                $id
            ]);
            
            flash('success', 'Payroll updated successfully');
            return redirect('/hr/payroll');
        }
        
        $staff = db()->fetchAll("SELECT id, CONCAT(first_name, ' ', last_name) as name FROM staff ORDER BY first_name");
        return view('hr/edit-payroll', [
            'title' => 'Edit - Payroll',
            'payroll' => $payroll,
            'staff' => $staff
        ]);
    }

    public function deletePayroll($request, $id)
    {
        db()->execute("DELETE FROM payroll WHERE id = ?", [$id]);
        flash('success', 'Payroll record deleted successfully');
        return redirect('/hr/payroll');
    }
}
