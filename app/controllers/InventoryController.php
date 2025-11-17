<?php

class InventoryController
{
    public function index($request)
    {
        return view('inventory/index', ['title' => 'Inventory Management']);
    }

    public function create($request)
    {
        return view('inventory/create', ['title' => 'Create - Inventory Management']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/inventory');
    }

    public function show($request, $id)
    {
        return view('inventory/show', ['title' => 'View - Inventory Management', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('inventory/edit', ['title' => 'Edit - Inventory Management', 'id' => $id]);
    }

    public function update($request, $id)
    {
        flash('success', 'Record updated successfully');
        return redirect('/inventory');
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/inventory');
    }
}
    public function stock($request)
    {
        return view('inventory/stock', ['title' => 'Inventory Stock']);
    }

    public function purchaseOrders($request)
    {
        return view('inventory/purchase_orders', ['title' => 'Purchase Orders']);
    }

    public function suppliers($request)
    {
        return view('inventory/suppliers', ['title' => 'Suppliers']);
    }
}
