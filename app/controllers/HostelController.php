<?php

class HostelController
{
    public function index($request)
    {
        $filters = [
            'search' => $request->get('search'),
            'hostel_type' => $request->get('hostel_type'),
            'status' => $request->get('status')
        ];
        
        $hostels = Hostel::getAll($filters);
        $types = Hostel::getTypes();
        $stats = Hostel::getStatistics();
        
        $wardens = db()->fetchAll(
            "SELECT id, CONCAT(first_name, ' ', last_name) as name FROM users WHERE role_name IN ('staff', 'admin')"
        );
        
        return view('hostel/index', [
            'title' => 'Hostel Management',
            'hostels' => $hostels,
            'types' => $types,
            'stats' => $stats,
            'wardens' => $wardens,
            'filters' => $filters
        ]);
    }

    public function create($request)
    {
        $wardens = db()->fetchAll(
            "SELECT id, CONCAT(first_name, ' ', last_name) as name FROM users WHERE role_name IN ('staff', 'admin')"
        );
        
        return view('hostel/create', [
            'title' => 'Add New Hostel',
            'wardens' => $wardens
        ]);
    }

    public function store($request)
    {
        $rules = [
            'name' => 'required',
            'total_rooms' => 'required|numeric'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'name' => $request->post('name'),
                'hostel_type' => $request->post('hostel_type'),
                'address' => $request->post('address'),
                'warden_id' => $request->post('warden_id'),
                'total_rooms' => $request->post('total_rooms'),
                'occupied_rooms' => 0,
                'status' => $request->post('status') ?? 'active'
            ];

            Hostel::create($data);
            flash('success', 'Hostel added successfully');
            return redirect('/hostel');
        } catch (Exception $e) {
            flash('error', 'Failed to add hostel: ' . $e->getMessage());
            return back();
        }
    }

    public function show($request, $id)
    {
        $hostel = Hostel::find($id);
        
        if (!$hostel) {
            flash('error', 'Hostel not found');
            return redirect('/hostel');
        }
        
        $rooms = HostelRoom::getAll(['hostel_id' => $id]);
        $residents = HostelResident::getAll(['hostel_id' => $id, 'status' => 'active']);
        $complaints = HostelComplaint::getAll(['hostel_id' => $id, 'status' => 'pending']);
        
        return view('hostel/show', [
            'title' => 'Hostel Details',
            'hostel' => $hostel,
            'rooms' => $rooms,
            'residents' => $residents,
            'complaints' => $complaints
        ]);
    }

    public function edit($request, $id)
    {
        $hostel = Hostel::find($id);
        
        if (!$hostel) {
            flash('error', 'Hostel not found');
            return redirect('/hostel');
        }
        
        $wardens = db()->fetchAll(
            "SELECT id, CONCAT(first_name, ' ', last_name) as name FROM users WHERE role_name IN ('staff', 'admin')"
        );
        
        return view('hostel/edit', [
            'title' => 'Edit Hostel',
            'hostel' => $hostel,
            'wardens' => $wardens
        ]);
    }

    public function update($request, $id)
    {
        $rules = [
            'name' => 'required',
            'total_rooms' => 'required|numeric'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'name' => $request->post('name'),
                'hostel_type' => $request->post('hostel_type'),
                'address' => $request->post('address'),
                'warden_id' => $request->post('warden_id'),
                'total_rooms' => $request->post('total_rooms'),
                'occupied_rooms' => $request->post('occupied_rooms'),
                'status' => $request->post('status')
            ];

            Hostel::update($id, $data);
            flash('success', 'Hostel updated successfully');
            return redirect('/hostel');
        } catch (Exception $e) {
            flash('error', 'Failed to update hostel: ' . $e->getMessage());
            return back();
        }
    }

    public function destroy($request, $id)
    {
        try {
            Hostel::delete($id);
            flash('success', 'Hostel deleted successfully');
            return redirect('/hostel');
        } catch (Exception $e) {
            flash('error', 'Failed to delete hostel: ' . $e->getMessage());
            return back();
        }
    }

    public function residents($request)
    {
        $filters = [
            'search' => $request->get('search'),
            'hostel_id' => $request->get('hostel_id'),
            'status' => $request->get('status')
        ];
        
        $residents = HostelResident::getAll($filters);
        $hostels = Hostel::getAll(['status' => 'active']);
        $stats = HostelResident::getStatistics();
        
        return view('hostel/residents', [
            'title' => 'Hostel Residents',
            'residents' => $residents,
            'hostels' => $hostels,
            'stats' => $stats,
            'filters' => $filters
        ]);
    }
    
    public function createResident($request)
    {
        $hostels = Hostel::getAll(['status' => 'active']);
        $studentsWithoutHostel = db()->fetchAll(
            "SELECT s.id, u.first_name, u.last_name, s.roll_number
             FROM students s 
             JOIN users u ON s.user_id = u.id
             LEFT JOIN hostel_residents r ON s.id = r.student_id AND r.status = 'active' 
             WHERE r.id IS NULL 
             ORDER BY u.first_name, u.last_name
             LIMIT 100"
        );
        $availableRooms = HostelRoom::getAvailableRooms();
        
        return view('hostel/residents/create', [
            'title' => 'Add Resident',
            'hostels' => $hostels,
            'studentsWithoutHostel' => $studentsWithoutHostel,
            'availableRooms' => $availableRooms
        ]);
    }
    
    public function editResident($request, $id)
    {
        $resident = HostelResident::find($id);
        if (!$resident) {
            flash('error', 'Resident not found');
            return redirect('/hostel/residents');
        }
        
        $hostels = Hostel::getAll(['status' => 'active']);
        $availableRooms = HostelRoom::getAvailableRooms();
        
        return view('hostel/residents/edit', [
            'title' => 'Edit Resident',
            'resident' => $resident,
            'hostels' => $hostels,
            'availableRooms' => $availableRooms
        ]);
    }
    
    public function updateResident($request, $id)
    {
        try {
            $data = [
                'hostel_id' => $request->post('hostel_id'),
                'room_id' => $request->post('room_id'),
                'admission_date' => $request->post('admission_date'),
                'checkout_date' => $request->post('checkout_date'),
                'guardian_contact' => $request->post('guardian_contact'),
                'emergency_contact' => $request->post('emergency_contact'),
                'status' => $request->post('status')
            ];

            HostelResident::update($id, $data);
            flash('success', 'Resident updated successfully');
            return redirect('/hostel/residents');
        } catch (Exception $e) {
            flash('error', 'Failed to update resident: ' . $e->getMessage());
            return back();
        }
    }
    
    public function deleteResident($request, $id)
    {
        try {
            HostelResident::delete($id);
            flash('success', 'Resident removed successfully');
            return redirect('/hostel/residents');
        } catch (Exception $e) {
            flash('error', 'Failed to remove resident: ' . $e->getMessage());
            return back();
        }
    }
    
    public function storeResident($request)
    {
        $rules = [
            'student_id' => 'required',
            'hostel_id' => 'required',
            'room_id' => 'required',
            'admission_date' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $studentId = $request->post('student_id');
            $roomId = $request->post('room_id');
            
            if (HostelResident::isStudentResident($studentId)) {
                flash('error', 'Student is already a resident in another hostel');
                return back();
            }
            
            if (!HostelRoom::hasCapacity($roomId)) {
                flash('error', 'Selected room has reached maximum capacity');
                return back();
            }
            
            $data = [
                'student_id' => $studentId,
                'hostel_id' => $request->post('hostel_id'),
                'room_id' => $roomId,
                'admission_date' => $request->post('admission_date'),
                'checkout_date' => $request->post('checkout_date'),
                'guardian_contact' => $request->post('guardian_contact'),
                'emergency_contact' => $request->post('emergency_contact'),
                'status' => 'active'
            ];

            HostelResident::create($data);
            flash('success', 'Resident added successfully');
            return redirect('/hostel/residents');
        } catch (Exception $e) {
            flash('error', 'Failed to add resident: ' . $e->getMessage());
            return back();
        }
    }

    public function visitors($request)
    {
        $filters = [
            'search' => $request->get('search'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to')
        ];
        
        $visitors = HostelVisitor::getAll($filters);
        $activeVisitors = HostelVisitor::getActiveVisitors();
        $residents = HostelResident::getAll(['status' => 'active']);
        $stats = HostelVisitor::getStatistics();
        
        return view('hostel/visitors', [
            'title' => 'Hostel Visitors',
            'visitors' => $visitors,
            'activeVisitors' => $activeVisitors,
            'residents' => $residents,
            'stats' => $stats,
            'filters' => $filters
        ]);
    }
    
    public function createVisitor($request)
    {
        $residents = HostelResident::getAll(['status' => 'active']);
        return view('hostel/visitors/create', [
            'title' => 'Add Visitor',
            'residents' => $residents
        ]);
    }

    public function storeVisitor($request)
    {
        $rules = [
            'resident_id' => 'required',
            'visitor_name' => 'required',
            'visit_date' => 'required',
            'entry_time' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'resident_id' => $request->post('resident_id'),
                'visitor_name' => $request->post('visitor_name'),
                'visitor_phone' => $request->post('visitor_phone'),
                'visitor_id_proof' => $request->post('visitor_id_proof'),
                'visit_date' => $request->post('visit_date'),
                'entry_time' => $request->post('entry_time'),
                'exit_time' => $request->post('exit_time'),
                'purpose' => $request->post('purpose'),
                'approved_by' => auth()['id']
            ];

            HostelVisitor::create($data);
            flash('success', 'Visitor entry recorded successfully');
            return redirect('/hostel/visitors');
        } catch (Exception $e) {
            flash('error', 'Failed to record visitor: ' . $e->getMessage());
            return back();
        }
    }

    public function editVisitor($request, $id)
    {
        $visitor = HostelVisitor::find($id);
        if (!$visitor) {
            flash('error', 'Visitor not found');
            return redirect('/hostel/visitors');
        }

        $residents = HostelResident::getAll(['status' => 'active']);
        return view('hostel/visitors/edit', [
            'title' => 'Edit Visitor',
            'visitor' => $visitor,
            'residents' => $residents
        ]);
    }

    public function updateVisitor($request, $id)
    {
        $visitor = HostelVisitor::find($id);
        if (!$visitor) {
            flash('error', 'Visitor not found');
            return redirect('/hostel/visitors');
        }

        $rules = [
            'resident_id' => 'required',
            'visitor_name' => 'required',
            'visit_date' => 'required',
            'entry_time' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'resident_id' => $request->post('resident_id'),
                'visitor_name' => $request->post('visitor_name'),
                'visitor_phone' => $request->post('visitor_phone'),
                'visitor_id_proof' => $request->post('visitor_id_proof'),
                'visit_date' => $request->post('visit_date'),
                'entry_time' => $request->post('entry_time'),
                'exit_time' => $request->post('exit_time'),
                'purpose' => $request->post('purpose')
            ];

            HostelVisitor::update($id, $data);
            flash('success', 'Visitor updated successfully');
            return redirect('/hostel/visitors');
        } catch (Exception $e) {
            flash('error', 'Failed to update visitor: ' . $e->getMessage());
            return back();
        }
    }

    public function deleteVisitor($request, $id)
    {
        try {
            HostelVisitor::delete($id);
            flash('success', 'Visitor deleted successfully');
        } catch (Exception $e) {
            flash('error', 'Failed to delete visitor: ' . $e->getMessage());
        }
        return redirect('/hostel/visitors');
    }

    public function complaints($request)
    {
        $filters = [
            'hostel_id' => $request->get('hostel_id'),
            'status' => $request->get('status'),
            'priority' => $request->get('priority'),
            'complaint_type' => $request->get('complaint_type')
        ];
        
        $complaints = HostelComplaint::getAll($filters);
        $hostels = Hostel::getAll(['status' => 'active']);
        $residents = HostelResident::getAll(['status' => 'active']);
        $stats = HostelComplaint::getStatistics();
        $types = HostelComplaint::getComplaintTypes();
        
        $staff = db()->fetchAll(
            "SELECT DISTINCT u.id, CONCAT(u.first_name, ' ', u.last_name) as name 
             FROM users u
             JOIN staff s ON u.id = s.user_id
             ORDER BY u.first_name"
        );
        
        return view('hostel/complaints', [
            'title' => 'Hostel Complaints',
            'complaints' => $complaints,
            'hostels' => $hostels,
            'residents' => $residents,
            'stats' => $stats,
            'types' => $types,
            'staff' => $staff,
            'filters' => $filters
        ]);
    }

    public function createComplaint($request)
    {
        $hostels = Hostel::getAll(['status' => 'active']);
        $residents = HostelResident::getAll(['status' => 'active']);
        $types = HostelComplaint::getComplaintTypes();
        $staff = db()->fetchAll(
            "SELECT DISTINCT u.id, CONCAT(u.first_name, ' ', u.last_name) as name 
             FROM users u JOIN staff s ON u.id = s.user_id ORDER BY u.first_name"
        );
        
        return view('hostel/complaints/create', [
            'title' => 'Add Complaint',
            'hostels' => $hostels,
            'residents' => $residents,
            'types' => $types,
            'staff' => $staff
        ]);
    }

    public function editComplaint($request, $id)
    {
        $complaint = HostelComplaint::find($id);
        if (!$complaint) {
            flash('error', 'Complaint not found');
            return redirect('/hostel/complaints');
        }

        $hostels = Hostel::getAll(['status' => 'active']);
        $residents = HostelResident::getAll(['status' => 'active']);
        $types = HostelComplaint::getComplaintTypes();
        $staff = db()->fetchAll(
            "SELECT DISTINCT u.id, CONCAT(u.first_name, ' ', u.last_name) as name 
             FROM users u JOIN staff s ON u.id = s.user_id ORDER BY u.first_name"
        );
        
        return view('hostel/complaints/edit', [
            'title' => 'Edit Complaint',
            'complaint' => $complaint,
            'hostels' => $hostels,
            'residents' => $residents,
            'types' => $types,
            'staff' => $staff
        ]);
    }

    public function updateComplaint($request, $id)
    {
        $complaint = HostelComplaint::find($id);
        if (!$complaint) {
            flash('error', 'Complaint not found');
            return redirect('/hostel/complaints');
        }

        $rules = [
            'resident_id' => 'required',
            'hostel_id' => 'required',
            'description' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'resident_id' => $request->post('resident_id'),
                'hostel_id' => $request->post('hostel_id'),
                'complaint_type' => $request->post('complaint_type'),
                'description' => $request->post('description'),
                'priority' => $request->post('priority'),
                'status' => $request->post('status'),
                'assigned_to' => $request->post('assigned_to'),
                'remarks' => $request->post('remarks')
            ];

            HostelComplaint::update($id, $data);
            flash('success', 'Complaint updated successfully');
            return redirect('/hostel/complaints');
        } catch (Exception $e) {
            flash('error', 'Failed to update complaint: ' . $e->getMessage());
            return back();
        }
    }

    public function deleteComplaint($request, $id)
    {
        try {
            HostelComplaint::delete($id);
            flash('success', 'Complaint deleted successfully');
        } catch (Exception $e) {
            flash('error', 'Failed to delete complaint: ' . $e->getMessage());
        }
        return redirect('/hostel/complaints');
    }
    
    public function storeComplaint($request)
    {
        $rules = [
            'resident_id' => 'required',
            'hostel_id' => 'required',
            'description' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'resident_id' => $request->post('resident_id'),
                'hostel_id' => $request->post('hostel_id'),
                'complaint_type' => $request->post('complaint_type'),
                'description' => $request->post('description'),
                'priority' => $request->post('priority') ?? 'medium',
                'status' => 'pending',
                'assigned_to' => $request->post('assigned_to'),
                'remarks' => $request->post('remarks')
            ];

            HostelComplaint::create($data);
            flash('success', 'Complaint registered successfully');
            return redirect('/hostel/complaints');
        } catch (Exception $e) {
            flash('error', 'Failed to register complaint: ' . $e->getMessage());
            return back();
        }
    }

    // Hostel Rooms Management
    public function roomsIndex($request)
    {
        $filters = [
            'search' => $request->get('search'),
            'hostel_id' => $request->get('hostel_id'),
            'status' => $request->get('status')
        ];
        
        $rooms = HostelRoom::getAll($filters);
        $hostels = Hostel::getAll(['status' => 'active']);
        $stats = HostelRoom::getStatistics();
        
        return view('hostel/rooms/index', [
            'title' => 'Hostel Rooms',
            'rooms' => $rooms,
            'hostels' => $hostels,
            'stats' => $stats,
            'filters' => $filters
        ]);
    }

    public function createRoom($request)
    {
        $hostels = Hostel::getAll(['status' => 'active']);
        
        return view('hostel/rooms/create', [
            'title' => 'Add New Room',
            'hostels' => $hostels,
            'roomTypes' => ['single' => 'Single', 'double' => 'Double', 'triple' => 'Triple', 'quad' => 'Quad']
        ]);
    }

    public function storeRoom($request)
    {
        $rules = [
            'hostel_id' => 'required',
            'room_number' => 'required',
            'room_type' => 'required',
            'capacity' => 'required|numeric'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'hostel_id' => $request->post('hostel_id'),
                'room_number' => $request->post('room_number'),
                'room_type' => $request->post('room_type'),
                'capacity' => $request->post('capacity'),
                'floor_number' => $request->post('floor_number') ?? 1,
                'room_fee' => $request->post('room_fee') ?? 0,
                'status' => $request->post('status') ?? 'active'
            ];

            HostelRoom::create($data);
            flash('success', 'Room added successfully');
            return redirect('/hostel/rooms');
        } catch (Exception $e) {
            flash('error', 'Failed to add room: ' . $e->getMessage());
            return back();
        }
    }

    public function editRoom($request, $id)
    {
        $room = HostelRoom::find($id);
        
        if (!$room) {
            flash('error', 'Room not found');
            return redirect('/hostel/rooms');
        }
        
        $hostels = Hostel::getAll(['status' => 'active']);
        
        return view('hostel/rooms/edit', [
            'title' => 'Edit Room',
            'room' => $room,
            'hostels' => $hostels,
            'roomTypes' => ['single' => 'Single', 'double' => 'Double', 'triple' => 'Triple', 'quad' => 'Quad']
        ]);
    }

    public function updateRoom($request, $id)
    {
        $rules = [
            'hostel_id' => 'required',
            'room_number' => 'required',
            'room_type' => 'required',
            'capacity' => 'required|numeric'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'hostel_id' => $request->post('hostel_id'),
                'room_number' => $request->post('room_number'),
                'room_type' => $request->post('room_type'),
                'capacity' => $request->post('capacity'),
                'floor_number' => $request->post('floor_number') ?? 1,
                'room_fee' => $request->post('room_fee') ?? 0,
                'status' => $request->post('status')
            ];

            HostelRoom::update($id, $data);
            flash('success', 'Room updated successfully');
            return redirect('/hostel/rooms');
        } catch (Exception $e) {
            flash('error', 'Failed to update room: ' . $e->getMessage());
            return back();
        }
    }

    public function deleteRoom($request, $id)
    {
        try {
            HostelRoom::delete($id);
            flash('success', 'Room deleted successfully');
            return redirect('/hostel/rooms');
        } catch (Exception $e) {
            flash('error', 'Failed to delete room: ' . $e->getMessage());
            return back();
        }
    }
}
