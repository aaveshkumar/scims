<?php

class InventoryController
{
    public function index($request)
    {
        $filters = [
            'search' => $request->get('search'),
            'category' => $request->get('category'),
            'status' => $request->get('status'),
            'item_condition' => $request->get('item_condition')
        ];
        
        $assets = Asset::getAll($filters);
        $categories = Asset::getCategories();
        $stats = Asset::getStatistics();
        $warrantyExpiring = Asset::getWarrantyExpiring(30);
        
        $users = db()->fetchAll(
            "SELECT id, CONCAT(first_name, ' ', last_name) as name FROM users"
        );
        
        return view('inventory/index', [
            'title' => 'Asset Management',
            'assets' => $assets,
            'categories' => $categories,
            'stats' => $stats,
            'warrantyExpiring' => $warrantyExpiring,
            'users' => $users,
            'filters' => $filters
        ]);
    }

    public function create($request)
    {
        $users = db()->fetchAll(
            "SELECT id, CONCAT(first_name, ' ', last_name) as name FROM users"
        );
        
        return view('inventory/create', [
            'title' => 'Add New Asset',
            'users' => $users
        ]);
    }

    public function store($request)
    {
        $rules = [
            'asset_code' => 'required',
            'name' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'asset_code' => $request->post('asset_code'),
                'name' => $request->post('name'),
                'category' => $request->post('category'),
                'description' => $request->post('description'),
                'purchase_date' => $request->post('purchase_date'),
                'purchase_cost' => $request->post('purchase_cost'),
                'current_value' => $request->post('current_value') ?? $request->post('purchase_cost'),
                'depreciation_rate' => $request->post('depreciation_rate'),
                'location' => $request->post('location'),
                'assigned_to' => $request->post('assigned_to'),
                'item_condition' => $request->post('item_condition') ?? 'good',
                'warranty_expiry' => $request->post('warranty_expiry'),
                'status' => $request->post('status') ?? 'active'
            ];

            Asset::create($data);
            flash('success', 'Asset added successfully');
            return redirect('/inventory');
        } catch (Exception $e) {
            $errorMsg = ErrorHandler::getDatabaseErrorMessage($e, 'Adding asset');
            flash('error', $errorMsg);
            return back();
        }
    }

    public function show($request, $id)
    {
        $asset = Asset::find($id);
        
        if (!$asset) {
            flash('error', 'Asset not found');
            return redirect('/inventory');
        }
        
        return view('inventory/show', [
            'title' => 'Asset Details',
            'asset' => $asset
        ]);
    }

    public function edit($request, $id)
    {
        $asset = Asset::find($id);
        
        if (!$asset) {
            flash('error', 'Asset not found');
            return redirect('/inventory');
        }
        
        $users = db()->fetchAll(
            "SELECT id, CONCAT(first_name, ' ', last_name) as name FROM users"
        );
        
        return view('inventory/edit', [
            'title' => 'Edit Asset',
            'asset' => $asset,
            'users' => $users
        ]);
    }

    public function update($request, $id)
    {
        $rules = [
            'asset_code' => 'required',
            'name' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'asset_code' => $request->post('asset_code'),
                'name' => $request->post('name'),
                'category' => $request->post('category'),
                'description' => $request->post('description'),
                'purchase_date' => $request->post('purchase_date'),
                'purchase_cost' => $request->post('purchase_cost'),
                'current_value' => $request->post('current_value'),
                'depreciation_rate' => $request->post('depreciation_rate'),
                'location' => $request->post('location'),
                'assigned_to' => $request->post('assigned_to'),
                'item_condition' => $request->post('item_condition'),
                'warranty_expiry' => $request->post('warranty_expiry'),
                'status' => $request->post('status')
            ];

            Asset::update($id, $data);
            flash('success', 'Asset updated successfully');
            return redirect('/inventory');
        } catch (Exception $e) {
            $errorMsg = ErrorHandler::getDatabaseErrorMessage($e, 'Updating asset');
            flash('error', $errorMsg);
            return back();
        }
    }

    public function destroy($request, $id)
    {
        try {
            Asset::delete($id);
            flash('success', 'Asset deleted successfully');
            return redirect('/inventory');
        } catch (Exception $e) {
            $errorMsg = ErrorHandler::getDatabaseErrorMessage($e, 'Deleting asset');
            flash('error', $errorMsg);
            return back();
        }
    }

    public function stock($request)
    {
        $filters = [
            'search' => $request->get('search'),
            'category' => $request->get('category'),
            'status' => $request->get('status')
        ];
        
        $items = InventoryItem::getAll($filters);
        $categories = InventoryItem::getCategories();
        $stats = InventoryItem::getStatistics();
        $lowStock = InventoryItem::getLowStockItems();
        $outOfStock = InventoryItem::getOutOfStockItems();
        
        return view('inventory/stock', [
            'title' => 'Inventory Stock Management',
            'items' => $items,
            'categories' => $categories,
            'stats' => $stats,
            'lowStock' => $lowStock,
            'outOfStock' => $outOfStock,
            'filters' => $filters
        ]);
    }
    
    public function storeStock($request)
    {
        $rules = [
            'item_code' => 'required',
            'name' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'item_code' => $request->post('item_code'),
                'name' => $request->post('name'),
                'category' => $request->post('category'),
                'description' => $request->post('description'),
                'unit' => $request->post('unit') ?? 'piece',
                'quantity' => $request->post('quantity') ?? 0,
                'reorder_level' => $request->post('reorder_level') ?? 10,
                'unit_price' => $request->post('unit_price'),
                'location' => $request->post('location'),
                'status' => 'in_stock'
            ];

            InventoryItem::create($data);
            flash('success', 'Stock item added successfully');
            return redirect('/inventory/stock');
        } catch (Exception $e) {
            $errorMsg = ErrorHandler::getDatabaseErrorMessage($e, 'Adding stock item');
            flash('error', $errorMsg);
            return back();
        }
    }

    public function purchaseOrders($request)
    {
        $filters = [
            'search' => $request->get('search'),
            'status' => $request->get('status'),
            'supplier_id' => $request->get('supplier_id')
        ];
        
        $orders = PurchaseOrder::getAll($filters);
        $suppliers = Supplier::getAll(['status' => 'active']);
        $stats = PurchaseOrder::getStatistics();
        $pending = PurchaseOrder::getPendingOrders();
        
        return view('inventory/purchase_orders', [
            'title' => 'Purchase Orders',
            'orders' => $orders,
            'suppliers' => $suppliers,
            'stats' => $stats,
            'pending' => $pending,
            'filters' => $filters
        ]);
    }
    
    public function storePurchaseOrder($request)
    {
        $rules = [
            'supplier_id' => 'required',
            'order_date' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'po_number' => PurchaseOrder::generatePONumber(),
                'supplier_id' => $request->post('supplier_id'),
                'order_date' => $request->post('order_date'),
                'expected_delivery' => $request->post('expected_delivery'),
                'total_amount' => 0,
                'status' => 'pending',
                'created_by' => auth()['id'],
                'remarks' => $request->post('remarks')
            ];

            PurchaseOrder::create($data);
            flash('success', 'Purchase order created successfully');
            return redirect('/inventory/purchase-orders');
        } catch (Exception $e) {
            $errorMsg = ErrorHandler::getDatabaseErrorMessage($e, 'Creating purchase order');
            flash('error', $errorMsg);
            return back();
        }
    }

    public function suppliers($request)
    {
        $filters = [
            'search' => $request->get('search'),
            'status' => $request->get('status'),
            'city' => $request->get('city')
        ];
        
        $suppliers = Supplier::getAll($filters);
        $cities = Supplier::getCities();
        $stats = Supplier::getStatistics();
        
        return view('inventory/suppliers', [
            'title' => 'Supplier Management',
            'suppliers' => $suppliers,
            'cities' => $cities,
            'stats' => $stats,
            'filters' => $filters
        ]);
    }
    
    public function storeSupplier($request)
    {
        $rules = [
            'supplier_code' => 'required',
            'name' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'supplier_code' => $request->post('supplier_code'),
                'name' => $request->post('name'),
                'contact_person' => $request->post('contact_person'),
                'email' => $request->post('email'),
                'phone' => $request->post('phone'),
                'address' => $request->post('address'),
                'city' => $request->post('city'),
                'country' => $request->post('country'),
                'payment_terms' => $request->post('payment_terms'),
                'status' => 'active'
            ];

            Supplier::create($data);
            flash('success', 'Supplier added successfully');
            return redirect('/inventory/suppliers');
        } catch (Exception $e) {
            $errorMsg = ErrorHandler::getDatabaseErrorMessage($e, 'Adding supplier');
            flash('error', $errorMsg);
            return back();
        }
    }
    
    public function updateStock($request, $id)
    {
        $rules = [
            'item_code' => 'required',
            'name' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'item_code' => $request->post('item_code'),
                'name' => $request->post('name'),
                'category' => $request->post('category'),
                'description' => $request->post('description'),
                'unit' => $request->post('unit') ?? 'piece',
                'quantity' => $request->post('quantity') ?? 0,
                'reorder_level' => $request->post('reorder_level') ?? 10,
                'unit_price' => $request->post('unit_price'),
                'location' => $request->post('location'),
                'status' => $request->post('status') ?? 'in_stock'
            ];

            InventoryItem::update($id, $data);
            flash('success', 'Stock item updated successfully');
            return redirect('/inventory/stock');
        } catch (Exception $e) {
            $errorMsg = ErrorHandler::getDatabaseErrorMessage($e, 'Updating stock item');
            flash('error', $errorMsg);
            return back();
        }
    }
    
    public function deleteStock($request, $id)
    {
        try {
            InventoryItem::delete($id);
            flash('success', 'Stock item deleted successfully');
            return redirect('/inventory/stock');
        } catch (Exception $e) {
            $errorMsg = ErrorHandler::getDatabaseErrorMessage($e, 'Deleting stock item');
            flash('error', $errorMsg);
            return back();
        }
    }
    
    public function updatePurchaseOrder($request, $id)
    {
        $rules = [
            'supplier_id' => 'required',
            'order_date' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'supplier_id' => $request->post('supplier_id'),
                'order_date' => $request->post('order_date'),
                'expected_delivery' => $request->post('expected_delivery'),
                'status' => $request->post('status'),
                'remarks' => $request->post('remarks')
            ];

            PurchaseOrder::update($id, $data);
            flash('success', 'Purchase order updated successfully');
            return redirect('/inventory/purchase-orders');
        } catch (Exception $e) {
            $errorMsg = ErrorHandler::getDatabaseErrorMessage($e, 'Updating purchase order');
            flash('error', $errorMsg);
            return back();
        }
    }

    public function approvePurchaseOrder($request, $id)
    {
        try {
            PurchaseOrder::approve($id, auth()['id']);
            flash('success', 'Purchase order approved successfully');
            return redirect('/inventory/purchase-orders');
        } catch (Exception $e) {
            $errorMsg = ErrorHandler::getDatabaseErrorMessage($e, 'Approving purchase order');
            flash('error', $errorMsg);
            return back();
        }
    }
    
    public function deletePurchaseOrder($request, $id)
    {
        try {
            PurchaseOrder::delete($id);
            flash('success', 'Purchase order deleted successfully');
            return redirect('/inventory/purchase-orders');
        } catch (Exception $e) {
            $errorMsg = ErrorHandler::getDatabaseErrorMessage($e, 'Deleting purchase order');
            flash('error', $errorMsg);
            return back();
        }
    }
    
    public function updateSupplier($request, $id)
    {
        $rules = [
            'supplier_code' => 'required',
            'name' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'supplier_code' => $request->post('supplier_code'),
                'name' => $request->post('name'),
                'contact_person' => $request->post('contact_person'),
                'email' => $request->post('email'),
                'phone' => $request->post('phone'),
                'address' => $request->post('address'),
                'city' => $request->post('city'),
                'country' => $request->post('country'),
                'payment_terms' => $request->post('payment_terms'),
                'status' => $request->post('status') ?? 'active'
            ];

            Supplier::update($id, $data);
            flash('success', 'Supplier updated successfully');
            return redirect('/inventory/suppliers');
        } catch (Exception $e) {
            $errorMsg = ErrorHandler::getDatabaseErrorMessage($e, 'Updating supplier');
            flash('error', $errorMsg);
            return back();
        }
    }
    
    public function deleteSupplier($request, $id)
    {
        try {
            Supplier::delete($id);
            flash('success', 'Supplier deleted successfully');
            return redirect('/inventory/suppliers');
        } catch (Exception $e) {
            $errorMsg = ErrorHandler::getDatabaseErrorMessage($e, 'Deleting supplier');
            flash('error', $errorMsg);
            return back();
        }
    }
}
