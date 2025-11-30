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
            $stats = ['total_routes' => count($routes)];
            $availableVehicles = db()->fetchAll("SELECT id, vehicle_number FROM vehicles WHERE status = 'active'");
            
            // Get drivers (users with driver role)
            $drivers = db()->fetchAll(
                "SELECT id, CONCAT(first_name, ' ', last_name) as name, email FROM users WHERE role = 'driver' OR role = 'staff' ORDER BY first_name"
            );
        } catch (Exception $e) {
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
        $drivers = db()->fetchAll("SELECT id, CONCAT(first_name, ' ', last_name) as name, email FROM users WHERE role = 'driver' OR role = 'staff' ORDER BY first_name");
        
        return view('transport/create-route', [
            'title' => 'Add New Route',
            'availableVehicles' => $availableVehicles,
            'drivers' => $drivers
        ]);
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
}
