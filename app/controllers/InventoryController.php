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
            flash('error', 'Failed to add asset: ' . $e->getMessage());
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
            flash('error', 'Failed to update asset: ' . $e->getMessage());
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
            flash('error', 'Failed to delete asset: ' . $e->getMessage());
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
            flash('error', 'Failed to add stock item: ' . $e->getMessage());
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
            flash('error', 'Failed to create purchase order: ' . $e->getMessage());
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
            flash('error', 'Failed to add supplier: ' . $e->getMessage());
            return back();
        }
    }
}
