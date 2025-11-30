<?php

class TransportController
{
    /**
     * Show all vehicles
     */
    public function index($request)
    {
        $filters = [
            'search' => $request->get('search'),
            'vehicle_type' => $request->get('vehicle_type'),
            'status' => $request->get('status')
        ];
        
        $vehicles = Vehicle::getAll($filters);
        $types = Vehicle::getTypes();
        $stats = Vehicle::getStatistics();
        $expiringSoon = Vehicle::getExpiringSoon(30);
        
        return view('transport/index', [
            'title' => 'Transport Management - Vehicles',
            'vehicles' => $vehicles,
            'types' => $types,
            'stats' => $stats,
            'expiringSoon' => $expiringSoon,
            'filters' => $filters
        ]);
    }

    /**
     * Show create vehicle form
     */
    public function create($request)
    {
        return view('transport/create', [
            'title' => 'Add New Vehicle'
        ]);
    }

    /**
     * Store new vehicle
     */
    public function store($request)
    {
        $rules = [
            'vehicle_number' => 'required',
            'capacity' => 'required|numeric'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'vehicle_number' => $request->post('vehicle_number'),
                'vehicle_type' => $request->post('vehicle_type'),
                'model' => $request->post('model'),
                'manufacturer' => $request->post('manufacturer'),
                'year' => $request->post('year'),
                'capacity' => $request->post('capacity'),
                'fuel_type' => $request->post('fuel_type'),
                'registration_date' => $request->post('registration_date'),
                'insurance_expiry' => $request->post('insurance_expiry'),
                'fitness_expiry' => $request->post('fitness_expiry'),
                'status' => $request->post('status') ?? 'active'
            ];

            Vehicle::create($data);
            flash('success', 'Vehicle added successfully');
            return redirect('/transport/vehicles');
        } catch (Exception $e) {
            flash('error', 'Failed to add vehicle: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Show vehicle details
     */
    public function show($request, $id)
    {
        $vehicle = Vehicle::find($id);
        
        if (!$vehicle) {
            flash('error', 'Vehicle not found');
            return redirect('/transport/vehicles');
        }
        
        $maintenanceHistory = VehicleMaintenance::getVehicleHistory($id);
        $totalCost = VehicleMaintenance::getTotalCost($id);
        
        return view('transport/show', [
            'title' => 'Vehicle Details',
            'vehicle' => $vehicle,
            'maintenanceHistory' => $maintenanceHistory,
            'totalCost' => $totalCost
        ]);
    }

    /**
     * Show edit vehicle form
     */
    public function edit($request, $id)
    {
        $vehicle = Vehicle::find($id);
        
        if (!$vehicle) {
            flash('error', 'Vehicle not found');
            return redirect('/transport/vehicles');
        }
        
        return view('transport/edit', [
            'title' => 'Edit Vehicle',
            'vehicle' => $vehicle
        ]);
    }

    /**
     * Update vehicle
     */
    public function update($request, $id)
    {
        $rules = [
            'vehicle_number' => 'required',
            'capacity' => 'required|numeric'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'vehicle_number' => $request->post('vehicle_number'),
                'vehicle_type' => $request->post('vehicle_type'),
                'model' => $request->post('model'),
                'manufacturer' => $request->post('manufacturer'),
                'year' => $request->post('year'),
                'capacity' => $request->post('capacity'),
                'fuel_type' => $request->post('fuel_type'),
                'registration_date' => $request->post('registration_date'),
                'insurance_expiry' => $request->post('insurance_expiry'),
                'fitness_expiry' => $request->post('fitness_expiry'),
                'status' => $request->post('status')
            ];

            Vehicle::update($id, $data);
            flash('success', 'Vehicle updated successfully');
            return redirect('/transport/vehicles');
        } catch (Exception $e) {
            flash('error', 'Failed to update vehicle: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Delete vehicle
     */
    public function destroy($request, $id)
    {
        try {
            Vehicle::delete($id);
            flash('success', 'Vehicle deleted successfully');
            return redirect('/transport/vehicles');
        } catch (Exception $e) {
            flash('error', 'Failed to delete vehicle: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Show routes
     */
    public function routes($request)
    {
        $filters = [
            'search' => $request->get('search'),
            'status' => $request->get('status')
        ];
        
        try {
            $routes = db()->fetchAll("SELECT * FROM routes ORDER BY created_at DESC");
            
            // If no routes exist, create dummy routes
            if (empty($routes)) {
                $dummyRoutes = [
                    ['route_name' => 'Main City Route', 'route_number' => 'RT-001', 'start_point' => 'City Center', 'end_point' => 'Railway Station', 'distance' => 15.5, 'fare' => 50],
                    ['route_name' => 'Suburb Express', 'route_number' => 'RT-002', 'start_point' => 'Central Hub', 'end_point' => 'North Suburb', 'distance' => 22.3, 'fare' => 75],
                    ['route_name' => 'Airport Shuttle', 'route_number' => 'RT-003', 'start_point' => 'Downtown', 'end_point' => 'Airport Terminal', 'distance' => 35.8, 'fare' => 150],
                    ['route_name' => 'Local Feeder Route', 'route_number' => 'RT-004', 'start_point' => 'Market Square', 'end_point' => 'Bus Depot', 'distance' => 8.2, 'fare' => 30],
                    ['route_name' => 'Industrial Zone', 'route_number' => 'RT-005', 'start_point' => 'City Center', 'end_point' => 'Industrial Estate', 'distance' => 18.5, 'fare' => 60],
                ];
                
                foreach ($dummyRoutes as $route) {
                    db()->query(
                        "INSERT INTO routes (route_name, route_number, start_point, end_point, distance, fare, status, created_at, updated_at) 
                         VALUES (?, ?, ?, ?, ?, ?, 'active', NOW(), NOW())",
                        [$route['route_name'], $route['route_number'], $route['start_point'], $route['end_point'], $route['distance'], $route['fare']]
                    );
                }
                
                // Fetch routes again after creating dummy data
                $routes = db()->fetchAll("SELECT * FROM routes ORDER BY created_at DESC");
            }
            
            $stats = ['total_routes' => count($routes)];
            $availableVehicles = db()->fetchAll("SELECT id, vehicle_number FROM vehicles WHERE status = 'active'");
            
            // Get drivers and staff from user_roles join
            $drivers = db()->fetchAll(
                "SELECT u.id, CONCAT(u.first_name, ' ', u.last_name) as name, u.email, u.first_name
                 FROM users u
                 INNER JOIN user_roles ur ON u.id = ur.user_id
                 INNER JOIN roles r ON ur.role_id = r.id
                 WHERE r.name IN ('driver', 'staff', 'teacher')
                 ORDER BY u.first_name"
            );
        } catch (Exception $e) {
            error_log("Transport Routes Error: " . $e->getMessage());
            $routes = [];
            $stats = ['total_routes' => 0];
            $availableVehicles = [];
            $drivers = [];
        }
        
        return view('transport/routes', [
            'title' => 'Transport Routes',
            'routes' => $routes,
            'stats' => $stats,
            'availableVehicles' => $availableVehicles,
            'drivers' => $drivers,
            'filters' => $filters
        ]);
    }
    
    /**
     * Show create route form
     */
    public function createRoute($request)
    {
        $availableVehicles = db()->fetchAll("SELECT id, vehicle_number FROM vehicles WHERE status = 'active' ORDER BY vehicle_number");
        
        // Get drivers and staff from user_roles join
        $drivers = db()->fetchAll(
            "SELECT u.id, CONCAT(u.first_name, ' ', u.last_name) as name, u.email, u.first_name
             FROM users u
             INNER JOIN user_roles ur ON u.id = ur.user_id
             INNER JOIN roles r ON ur.role_id = r.id
             WHERE r.name IN ('driver', 'staff', 'teacher')
             ORDER BY u.first_name"
        );
        
        return view('transport/create-route', [
            'title' => 'Add New Route',
            'availableVehicles' => $availableVehicles,
            'drivers' => $drivers
        ]);
    }
    
    /**
     * Show route details
     */
    public function showRoute($request, $id)
    {
        try {
            $route = db()->fetchOne("SELECT * FROM routes WHERE id = ?", [$id]);
            
            if (!$route) {
                flash('error', 'Route not found');
                return redirect('/transport/routes');
            }
        } catch (Exception $e) {
            flash('error', 'Error loading route');
            return redirect('/transport/routes');
        }
        
        return view('transport/show-route', [
            'title' => 'Route Details',
            'route' => $route
        ]);
    }

    /**
     * Show edit route form
     */
    public function editRoute($request, $id)
    {
        try {
            $route = db()->fetchOne("SELECT * FROM routes WHERE id = ?", [$id]);
            
            if (!$route) {
                flash('error', 'Route not found');
                return redirect('/transport/routes');
            }
        } catch (Exception $e) {
            flash('error', 'Error loading route');
            return redirect('/transport/routes');
        }
        
        return view('transport/edit-route', [
            'title' => 'Edit Route',
            'route' => $route
        ]);
    }

    /**
     * Update route
     */
    public function updateRoute($request, $id)
    {
        $rules = [
            'route_name' => 'required',
            'route_number' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            db()->query(
                "UPDATE routes SET route_name = ?, route_number = ?, start_point = ?, end_point = ?, distance = ?, fare = ?, status = ?, updated_at = NOW() WHERE id = ?",
                [
                    $request->post('route_name'),
                    $request->post('route_number'),
                    $request->post('start_point'),
                    $request->post('end_point'),
                    $request->post('distance') ?? 0,
                    $request->post('fare') ?? 0,
                    $request->post('status') ?? 'active',
                    $id
                ]
            );
            
            flash('success', 'Route updated successfully');
            return redirect('/transport/routes');
        } catch (Exception $e) {
            flash('error', 'Failed to update route: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Delete route
     */
    public function destroyRoute($request, $id)
    {
        try {
            db()->query("DELETE FROM routes WHERE id = ?", [$id]);
            
            flash('success', 'Route deleted successfully');
            return redirect('/transport/routes');
        } catch (Exception $e) {
            flash('error', 'Failed to delete route: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Store new route
     */
    public function storeRoute($request)
    {
        $rules = [
            'route_name' => 'required',
            'route_number' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'route_name' => $request->post('route_name'),
                'route_number' => $request->post('route_number'),
                'start_point' => $request->post('start_point'),
                'end_point' => $request->post('end_point'),
                'distance' => $request->post('distance'),
                'fare' => $request->post('fare'),
                'vehicle_id' => $request->post('vehicle_id'),
                'driver_id' => $request->post('driver_id'),
                'status' => $request->post('status') ?? 'active'
            ];

            Route::create($data);
            flash('success', 'Route created successfully');
            return redirect('/transport/routes');
        } catch (Exception $e) {
            flash('error', 'Failed to create route: ' . $e->getMessage());
            return back();
        }
    }
    
    /**
     * Update route
     */
    public function updateRoute($request, $id)
    {
        $rules = [
            'route_name' => 'required',
            'route_number' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'route_name' => $request->post('route_name'),
                'route_number' => $request->post('route_number'),
                'start_point' => $request->post('start_point'),
                'end_point' => $request->post('end_point'),
                'distance' => $request->post('distance'),
                'fare' => $request->post('fare'),
                'vehicle_id' => $request->post('vehicle_id'),
                'driver_id' => $request->post('driver_id'),
                'status' => $request->post('status')
            ];

            Route::update($id, $data);
            flash('success', 'Route updated successfully');
            return redirect('/transport/routes');
        } catch (Exception $e) {
            flash('error', 'Failed to update route: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Show route assignments
     */
    public function assignments($request)
    {
        $filters = [
            'search' => $request->get('search'),
            'route_id' => $request->get('route_id'),
            'status' => $request->get('status')
        ];
        
        $assignments = TransportAssignment::getAll($filters);
        $routes = Route::getAll(['status' => 'active']);
        $stats = TransportAssignment::getStatistics();
        
        // Get students without transport
        $studentsWithoutTransport = db()->fetchAll(
            "SELECT s.id, s.first_name, s.last_name, s.roll_number, s.class 
             FROM students s 
             LEFT JOIN transport_assignments ta ON s.id = ta.student_id AND ta.status = 'active' 
             WHERE ta.id IS NULL 
             ORDER BY s.first_name, s.last_name
             LIMIT 100"
        );
        
        return view('transport/assignments', [
            'title' => 'Transport Assignments',
            'assignments' => $assignments,
            'routes' => $routes,
            'stats' => $stats,
            'studentsWithoutTransport' => $studentsWithoutTransport,
            'filters' => $filters
        ]);
    }
    
    /**
     * Store new assignment
     */
    public function storeAssignment($request)
    {
        $rules = [
            'student_id' => 'required',
            'route_id' => 'required',
            'start_date' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $studentId = $request->post('student_id');
            $routeId = $request->post('route_id');
            
            // Check if student already assigned
            if (TransportAssignment::isStudentAssigned($studentId)) {
                flash('error', 'Student is already assigned to a route');
                return back();
            }
            
            // Check route capacity
            if (!TransportAssignment::canAssignToRoute($routeId)) {
                flash('error', 'Route has reached maximum capacity');
                return back();
            }
            
            $data = [
                'student_id' => $studentId,
                'route_id' => $routeId,
                'stop_id' => $request->post('stop_id'),
                'start_date' => $request->post('start_date'),
                'end_date' => $request->post('end_date'),
                'status' => 'active'
            ];

            TransportAssignment::create($data);
            flash('success', 'Student assigned successfully');
            return redirect('/transport/assignments');
        } catch (Exception $e) {
            flash('error', 'Failed to assign student: ' . $e->getMessage());
            return back();
        }
    }
    
    /**
     * Show maintenance records
     */
    public function maintenance($request)
    {
        $filters = [
            'vehicle_id' => $request->get('vehicle_id'),
            'status' => $request->get('status'),
            'maintenance_type' => $request->get('maintenance_type')
        ];
        
        $maintenanceRecords = VehicleMaintenance::getAll($filters);
        $vehicles = Vehicle::getAll(['status' => 'active']);
        $stats = VehicleMaintenance::getStatistics();
        $upcoming = VehicleMaintenance::getUpcoming(30);
        $types = VehicleMaintenance::getTypes();
        
        return view('transport/maintenance', [
            'title' => 'Vehicle Maintenance',
            'maintenanceRecords' => $maintenanceRecords,
            'vehicles' => $vehicles,
            'stats' => $stats,
            'upcoming' => $upcoming,
            'types' => $types,
            'filters' => $filters
        ]);
    }
    
    /**
     * Store maintenance record
     */
    public function storeMaintenance($request)
    {
        $rules = [
            'vehicle_id' => 'required',
            'maintenance_date' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'vehicle_id' => $request->post('vehicle_id'),
                'maintenance_type' => $request->post('maintenance_type'),
                'description' => $request->post('description'),
                'maintenance_date' => $request->post('maintenance_date'),
                'cost' => $request->post('cost'),
                'vendor' => $request->post('vendor'),
                'next_maintenance_date' => $request->post('next_maintenance_date'),
                'status' => $request->post('status') ?? 'completed'
            ];

            VehicleMaintenance::create($data);
            flash('success', 'Maintenance record added successfully');
            return redirect('/transport/maintenance');
        } catch (Exception $e) {
            flash('error', 'Failed to add maintenance record: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Show all drivers
     */
    public function drivers($request)
    {
        try {
            $drivers = db()->fetchAll(
                "SELECT u.id, u.first_name, u.last_name, u.email, u.phone, u.status, 
                        COALESCE(s.license_number, '') as license_number
                 FROM users u
                 LEFT JOIN staff s ON u.id = s.user_id
                 INNER JOIN user_roles ur ON u.id = ur.user_id
                 INNER JOIN roles r ON ur.role_id = r.id
                 WHERE r.name IN ('driver', 'staff', 'teacher')
                 ORDER BY u.first_name"
            );
        } catch (Exception $e) {
            $drivers = [];
        }
        
        return view('transport/drivers', [
            'title' => 'Driver Management',
            'drivers' => $drivers
        ]);
    }

    /**
     * Show create driver form
     */
    public function createDriver($request)
    {
        return view('transport/create-driver', [
            'title' => 'Add New Driver'
        ]);
    }

    /**
     * Store new driver
     */
    public function storeDriver($request)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'license_number' => 'required',
            'password' => 'required|min:6'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            // Create user
            $userId = db()->query(
                "INSERT INTO users (email, password, first_name, last_name, phone, status, created_at, updated_at)
                 VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())",
                [
                    $request->post('email'),
                    password_hash($request->post('password'), PASSWORD_DEFAULT),
                    $request->post('first_name'),
                    $request->post('last_name'),
                    $request->post('phone') ?? '',
                    $request->post('status') ?? 'active'
                ]
            );
            
            // Get last inserted ID
            $result = db()->fetchOne("SELECT lastval() as id");
            $newUserId = $result['id'];

            // Assign driver role
            db()->query(
                "INSERT INTO user_roles (user_id, role_id) VALUES (?, (SELECT id FROM roles WHERE name = 'driver'))",
                [$newUserId]
            );

            // Store license info in staff table if needed
            if ($request->post('license_number')) {
                db()->query(
                    "INSERT INTO staff (user_id, license_number, status, created_at, updated_at)
                     VALUES (?, ?, ?, NOW(), NOW())",
                    [$newUserId, $request->post('license_number'), $request->post('status') ?? 'active']
                );
            }

            flash('success', 'Driver added successfully');
            return redirect('/transport/drivers');
        } catch (Exception $e) {
            flash('error', 'Failed to add driver: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Show edit driver form
     */
    public function editDriver($request, $id)
    {
        try {
            $driver = db()->fetchOne(
                "SELECT u.id, u.first_name, u.last_name, u.email, u.phone, u.status,
                        COALESCE(s.license_number, '') as license_number,
                        COALESCE(s.license_expiry, '') as license_expiry
                 FROM users u
                 LEFT JOIN staff s ON u.id = s.user_id
                 WHERE u.id = ?",
                [$id]
            );

            if (!$driver) {
                flash('error', 'Driver not found');
                return redirect('/transport/drivers');
            }
        } catch (Exception $e) {
            flash('error', 'Error loading driver');
            return redirect('/transport/drivers');
        }

        return view('transport/edit-driver', [
            'title' => 'Edit Driver',
            'driver' => $driver
        ]);
    }

    /**
     * Update driver
     */
    public function updateDriver($request, $id)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'license_number' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            db()->query(
                "UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ?, status = ?, updated_at = NOW()
                 WHERE id = ?",
                [
                    $request->post('first_name'),
                    $request->post('last_name'),
                    $request->post('email'),
                    $request->post('phone') ?? '',
                    $request->post('status') ?? 'active',
                    $id
                ]
            );

            // Update staff/license info
            db()->query(
                "UPDATE staff SET license_number = ?, license_expiry = ?, status = ?, updated_at = NOW()
                 WHERE user_id = ?",
                [
                    $request->post('license_number'),
                    $request->post('license_expiry') ?? null,
                    $request->post('status') ?? 'active',
                    $id
                ]
            );

            flash('success', 'Driver updated successfully');
            return redirect('/transport/drivers');
        } catch (Exception $e) {
            flash('error', 'Failed to update driver: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Delete driver
     */
    public function destroyDriver($request, $id)
    {
        try {
            db()->query("DELETE FROM staff WHERE user_id = ?", [$id]);
            db()->query("DELETE FROM user_roles WHERE user_id = ?", [$id]);
            db()->query("DELETE FROM users WHERE id = ?", [$id]);
            
            flash('success', 'Driver deleted successfully');
            return redirect('/transport/drivers');
        } catch (Exception $e) {
            flash('error', 'Failed to delete driver: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Show driver payroll
     */
    public function payroll($request)
    {
        try {
            $drivers = db()->fetchAll(
                "SELECT u.id, u.first_name, u.last_name, u.email
                 FROM users u
                 INNER JOIN user_roles ur ON u.id = ur.user_id
                 INNER JOIN roles r ON ur.role_id = r.id
                 WHERE r.name = 'driver'
                 ORDER BY u.first_name"
            );
        } catch (Exception $e) {
            $drivers = [];
        }
        
        return view('transport/payroll', [
            'title' => 'Driver Payroll',
            'drivers' => $drivers
        ]);
    }

    /**
     * Submit payroll
     */
    public function submitPayroll($request)
    {
        try {
            $basic_salaries = $request->post('basic_salary') ?? [];
            $allowances = $request->post('allowances') ?? [];
            $deductions = $request->post('deductions') ?? [];
            $payment_dates = $request->post('payment_date') ?? [];
            $statuses = $request->post('status') ?? [];

            foreach ($basic_salaries as $driver_id => $basic_salary) {
                $allowance = $allowances[$driver_id] ?? 0;
                $deduction = $deductions[$driver_id] ?? 0;
                $gross_salary = $basic_salary + $allowance;
                $net_salary = $gross_salary - $deduction;
                $payment_date = $payment_dates[$driver_id] ?? date('Y-m-d');
                $status = $statuses[$driver_id] ?? 'pending';

                db()->query(
                    "INSERT INTO payroll (user_id, basic_salary, allowances, deductions, gross_salary, net_salary, payment_date, payment_method, status, created_at, updated_at)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())",
                    [$driver_id, $basic_salary, $allowance, $deduction, $gross_salary, $net_salary, $payment_date, 'bank_transfer', $status]
                );
            }
            
            flash('success', 'Payroll processed successfully');
            return redirect('/transport/drivers');
        } catch (Exception $e) {
            flash('error', 'Failed to process payroll: ' . $e->getMessage());
            return back();
        }
    }
}
